@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Order Details: {{ $order->order_number }}</h2>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <button onclick="window.print()" class="btn btn-info ms-2">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Order Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Order Number:</th>
                            <td>{{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm">
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $order->customer_name }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $order->customer_phone }}</td>
                        </tr>
                        @if($order->customer_email)
                        <tr>
                            <th>Email:</th>
                            <td>{{ $order->customer_email }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Address:</th>
                            <td>{{ $order->shipping_address }}</td>
                        </tr>
                        <tr>
                            <th>City:</th>
                            <td>{{ $order->shipping_city }}</td>
                        </tr>
                        <tr>
                            <th>District:</th>
                            <td>{{ $order->shipping_district }}</td>
                        </tr>
                        <tr>
                            <th>Ward:</th>
                            <td>{{ $order->shipping_ward }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Order Items</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ number_format($item->price) }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->total) }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                            <td class="text-end">{{ number_format($order->total_amount) }}đ</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                            <td class="text-end">{{ number_format($order->shipping_amount) }}đ</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td class="text-end"><strong>{{ number_format($order->final_total) }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @if($order->notes)
    <!-- Notes -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Notes</h5>
        </div>
        <div class="card-body">
            {{ $order->notes }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    @media print {
        .btn, .alert, form {
            display: none !important;
        }
        .card {
            border: none !important;
        }
        .card-header {
            background: none !important;
            border-bottom: 1px solid #ddd !important;
        }
    }
</style>
@endpush
@endsection 