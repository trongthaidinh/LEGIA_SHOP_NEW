<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $language = request()->segment(2);
            $query = Order::with('items')
                ->where('language', $language)
                ->latest();

            // Search functionality
            if ($search = $request->input('search')) {
                $query->where(function($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_phone', 'like', "%{$search}%")
                      ->orWhere('customer_email', 'like', "%{$search}%");
                });
            }

            // Filter by status
            if ($status = $request->input('status')) {
                $query->where('status', $status);
            }

            $orders = $query->paginate(10);

            return view('admin.orders.index', [
                'orders' => $orders,
                'statuses' => Order::getStatuses()
            ]);
        } catch (\Exception $e) {
            Log::error('Error in OrderController@index: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching orders.');
        }
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $language = request()->segment(2);
            $products = Product::where('is_active', true)
                             ->where('stock', '>', 0)
                             ->where('language', $language)
                             ->select('id', 'name', 'price', 'stock')
                             ->orderBy('name')
                             ->get();

            return view('admin.orders.create', [
                'products' => $products,
                'statuses' => Order::getStatuses()
            ]);
        } catch (\Exception $e) {
            Log::error('Error in OrderController@create: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the create form.');
        }
    }

    /**
     * Store a newly created order in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $this->validateOrder($request);
            
            // Generate order number
            $validated['order_number'] = $this->generateOrderNumber();
            $validated['language'] = request()->segment(2);

            // Create order
            $order = Order::create($validated);

            // Create order items
            $this->createOrderItems($order, $request->input('items', []));

            // Update product stock
            $this->updateProductStock($request->input('items', []));

            DB::commit();
            return redirect()->route('admin.' . $validated['language'] . '.orders.show', $order)
                ->with('success', 'Order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in OrderController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while creating the order.');
        }
    }

    /**
     * Display the specified order.
     *
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        try {
            $order->load('items.product');
            
            return view('admin.orders.show', [
                'order' => $order,
                'statuses' => Order::getStatuses()
            ]);
        } catch (\Exception $e) {
            Log::error('Error in OrderController@show: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the order.');
        }
    }

    /**
     * Update the specified order status.
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'status' => 'required|in:' . implode(',', array_keys(Order::getStatuses()))
            ]);

            $order->update($validated);

            DB::commit();
            return back()->with('success', 'Order status updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in OrderController@updateStatus: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the order status.');
        }
    }

    /**
     * Remove the specified order from storage.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            // Restore product stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
            
            $order->delete();

            DB::commit();
            $language = request()->segment(2);
            return redirect()->route('admin.' . $language . '.orders.index')
                ->with('success', 'Order deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in OrderController@destroy: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the order.');
        }
    }

    /**
     * Validate order data.
     *
     * @param Request $request
     * @return array
     */
    private function validateOrder(Request $request): array
    {
        return $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_district' => 'required|string|max:255',
            'shipping_ward' => 'required|string|max:255',
            'shipping_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);
    }

    /**
     * Generate unique order number.
     *
     * @return string
     */
    private function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    /**
     * Create order items and calculate totals.
     *
     * @param Order $order
     * @param array $items
     * @return void
     */
    private function createOrderItems(Order $order, array $items): void
    {
        $totalAmount = 0;

        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            if ($product->stock < $item['quantity']) {
                throw new \Exception("Insufficient stock for product: {$product->name}");
            }

            $orderItem = $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'total' => $product->price * $item['quantity']
            ]);

            $totalAmount += $orderItem->total;
        }

        $order->update(['total_amount' => $totalAmount]);
    }

    /**
     * Update product stock after order creation.
     *
     * @param array $items
     * @return void
     */
    private function updateProductStock(array $items): void
    {
        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $product->decrement('stock', $item['quantity']);
        }
    }
} 