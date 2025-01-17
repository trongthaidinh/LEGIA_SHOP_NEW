<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
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
            $language = request()->segment(1);
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
            return back()->with('error', 'Đã xảy ra lỗi khi tải đơn hàng.');
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
            $language = request()->segment(1);
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
            return back()->with('error', 'Đã xảy ra lỗi khi tải trang tạo đơn hàng.');
        }
    }

    /**
     * Store a newly created order in storage.
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            // First validate basic order information
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_email' => 'nullable|email|max:255',
                'shipping_address' => 'required|string|max:255',
                'shipping_city' => 'required|string|max:255',
                'shipping_district' => 'required|string|max:255',
                'shipping_ward' => 'required|string|max:255',
                'shipping_amount' => 'numeric|min:0',
                'notes' => 'nullable|string',
                'items' => 'array|min:1',
                'items.*.product_id' => 'exists:products,id',
                'items.*.quantity' => 'integer|min:1'
            ]);

            // Generate order number
            $validated['order_number'] = $this->generateOrderNumber();
            $validated['status'] = Order::STATUS_PENDING;
            $validated['total_amount'] = 0; // Will be updated after creating items
            $validated['language'] = request()->segment(1);

            // Create order
            $order = Order::create($validated);

            // Validate and create order items
            $totalAmount = 0;
            foreach ($request->input('items', []) as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Validate stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Số lượng hàng không đủ cho sản phẩm: {$product->name}");
                }

                // Create order item
                $orderItem = $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity']
                ]);

                // Update total amount
                $totalAmount += $orderItem->total;

                // Update product stock
                $product->decrement('stock', $item['quantity']);
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route($validated['language'] . '.admin.orders.show', $order)
                ->with('success', 'Đơn hàng đã được tạo thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in OrderController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Đã xảy ra lỗi khi tạo đơn hàng: ' . $e->getMessage());
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
            return back()->with('error', 'Đã xảy ra lỗi khi tải đơn hàng.');
        }
    }

    /**
     * Update the specified order status.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(OrderRequest $request, Order $order)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $order->update($validated);

            DB::commit();
            return back()->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in OrderController@updateStatus: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật trạng thái đơn hàng.');
        }
    }

    /**
     * Process the order.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Order $order)
    {
        try {
            DB::beginTransaction();

            if ($order->status !== Order::STATUS_PENDING) {
                throw new \Exception('Chỉ có thể xử lý các đơn hàng đang chờ xử lý.');
            }

            $order->update(['status' => 'processed']);

            DB::commit();
            return back()->with('success', 'Đơn hàng đã được xử lý thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in OrderController@process: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng: ' . $e->getMessage());
        }
    }

    /**
     * Cancel the specified order.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            // Check if order can be cancelled
            if ($order->status === 'cancelled') {
                throw new \Exception('Đơn hàng đã được hủy trước đó.');
            }

            // Restore product stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
            
            // Update order status to cancelled
            $order->update([
                'status' => 'cancelled'
            ]);

            DB::commit();
            $language = request()->segment(1);
            return redirect()->route($language . '.admin.orders.index')
                ->with('success', 'Đơn hàng đã được hủy thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in OrderController@destroy: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Generate unique order number.
     *
     * @return string
     */
    private function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        return "{$prefix}-{$date}-{$random}";
    }
} 