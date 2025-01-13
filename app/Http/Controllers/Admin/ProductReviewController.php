<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with('product')
            ->latest()
            ->paginate(10);

        return view('admin.product-reviews.index', compact('reviews'));
    }

    public function show(ProductReview $productReview)
    {
        return view('admin.product-reviews.show', compact('productReview'));
    }

    public function approve(ProductReview $productReview)
    {
        $productReview->update(['is_approved' => true]);
        return redirect()->route(app()->getLocale() . '.admin.product-reviews.index')
            ->with('success', 'Đã duyệt đánh giá thành công');
    }

    public function reject(ProductReview $productReview)
    {
        $productReview->update(['is_approved' => false]);
        return redirect()->route(app()->getLocale() . '.admin.product-reviews.index')
            ->with('success', 'Đã hủy duyệt đánh giá thành công');
    }

    public function destroy(ProductReview $productReview)
    {
        $productReview->delete();
        return redirect()->route(app()->getLocale() . '.admin.product-reviews.index')
            ->with('success', 'Đã xóa đánh giá thành công');
    }
} 