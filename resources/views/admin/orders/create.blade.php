@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Create New Order</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
        @csrf
        <div class="row">
            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" 
                                id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_city" class="form-label">City</label>
                            <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" 
                                id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" required>
                            @error('shipping_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_district" class="form-label">District</label>
                            <input type="text" class="form-control @error('shipping_district') is-invalid @enderror" 
                                id="shipping_district" name="shipping_district" value="{{ old('shipping_district') }}" required>
                            @error('shipping_district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_ward" class="form-label">Ward</label>
                            <input type="text" class="form-control @error('shipping_ward') is-invalid @enderror" 
                                id="shipping_ward" name="shipping_ward" value="{{ old('shipping_ward') }}" required>
                            @error('shipping_ward')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Order Items</h5>
                <button type="button" class="btn btn-sm btn-primary" id="addItem">
                    <i class="fas fa-plus"></i> Add Item
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="itemsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Items will be added here dynamically -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                <td><span id="subtotal">0</span>đ</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                                <td>
                                    <input type="number" class="form-control form-control-sm @error('shipping_amount') is-invalid @enderror" 
                                        name="shipping_amount" value="{{ old('shipping_amount', 0) }}" min="0" required>
                                    @error('shipping_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong><span id="total">0</span>đ</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Additional Notes</h5>
            </div>
            <div class="card-body">
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                    name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Order
            </button>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const products = @json($products);
    let itemCount = 0;

    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }

    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-total').forEach(el => {
            subtotal += parseFloat(el.dataset.total || 0);
        });
        
        const shipping = parseFloat(document.querySelector('input[name="shipping_amount"]').value || 0);
        const total = subtotal + shipping;

        document.getElementById('subtotal').textContent = formatPrice(subtotal);
        document.getElementById('total').textContent = formatPrice(total);
    }

    function createItemRow() {
        itemCount++;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="items[${itemCount}][product_id]" class="form-select product-select" required>
                    <option value="">Select Product</option>
                    ${products.map(p => `<option value="${p.id}" data-price="${p.price}" data-stock="${p.stock}">${p.name}</option>`).join('')}
                </select>
            </td>
            <td class="item-price">-</td>
            <td class="item-stock">-</td>
            <td>
                <input type="number" name="items[${itemCount}][quantity]" class="form-control item-quantity" 
                    min="1" value="1" required style="width: 100px">
            </td>
            <td class="item-total" data-total="0">0đ</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-item">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        document.querySelector('#itemsTable tbody').appendChild(row);

        // Initialize Select2
        $(row).find('.product-select').select2();

        // Add event listeners
        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.item-quantity');
        const removeButton = row.querySelector('.remove-item');

        select.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const price = option.dataset.price;
            const stock = option.dataset.stock;
            
            row.querySelector('.item-price').textContent = price ? formatPrice(price) + 'đ' : '-';
            row.querySelector('.item-stock').textContent = stock || '-';
            quantityInput.max = stock;
            
            updateRowTotal(row);
        });

        quantityInput.addEventListener('change', () => updateRowTotal(row));
        removeButton.addEventListener('click', () => {
            row.remove();
            updateTotals();
        });
    }

    function updateRowTotal(row) {
        const select = row.querySelector('.product-select');
        const quantity = parseInt(row.querySelector('.item-quantity').value);
        const option = select.options[select.selectedIndex];
        const price = parseFloat(option.dataset.price || 0);
        const total = price * quantity;

        row.querySelector('.item-total').textContent = formatPrice(total) + 'đ';
        row.querySelector('.item-total').dataset.total = total;
        updateTotals();
    }

    // Initial setup
    document.getElementById('addItem').addEventListener('click', createItemRow);
    document.querySelector('input[name="shipping_amount"]').addEventListener('input', updateTotals);
    createItemRow(); // Add first row automatically
</script>
@endpush
@endsection 