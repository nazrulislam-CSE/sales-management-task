@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-cart-plus me-2"></i> Add Sale</h5>
                    <a href="{{ route('sales.index') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <!-- Alert Area -->
                    <div id="alert-area"></div>

                    <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
                        @csrf

                        <!-- Customer and Date -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-select" required>
                                    <option value="">-- Select Customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Line Items -->
                        <div id="line-items">
                            <div class="row mb-3 line-item align-items-end">
                                <div class="col-md-3">
                                    <label>Product</label>
                                    <select name="product_id[]" class="form-select product-select" required>
                                        <option value="">-- Select --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Qty</label>
                                    <input type="number" name="quantity[]" class="form-control quantity" min="1" value="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label>Price</label>
                                    <input type="text" name="price[]" class="form-control price" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label>Discount (%)</label>
                                    <input type="number" name="discount[]" class="form-control discount" min="0" max="100" value="0">
                                </div>
                                <div class="col-md-2">
                                    <label>Total</label>
                                    <input type="text" class="form-control total" readonly>
                                </div>
                                <div class="col-md-1 d-flex gap-1">
                                    <button type="button" class="btn btn-success btn-sm add-line" title="Add">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm remove-line" title="Remove">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- Grand Total and Submit -->
                        <div class="row mt-4 align-items-center">
                            <div class="col-md-9 text-end">
                                <label class="form-label fw-bold fs-5">Grand Total:</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="grand_total" name="grand_total" class="form-control text-end fw-bold fs-5" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Sale
                                </button>
                            </div>
                        </div>
                    </form>

                </div> <!-- card-body -->
            </div> <!-- card -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    let lineIndex = 1;

    // Calculate row total
    function calculateRowTotal(row) {
        let qty = parseFloat(row.find('.quantity').val()) || 0;
        let price = parseFloat(row.find('.price').val()) || 0;
        let discount = parseFloat(row.find('.discount').val()) || 0;
        let total = qty * price;
        total -= total * (discount / 100);
        row.find('.total').val(total.toFixed(2));
    }

    // Calculate grand total
    function calculateGrandTotal() {
        let total = 0;
        $('.total').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#grand_total').val(total.toFixed(2));
    }

    // When product is selected
    $(document).on('change', '.product-select', function() {
        let price = $(this).find(':selected').data('price') || 0;
        let row = $(this).closest('.line-item');
        row.find('.price').val(price);
        calculateRowTotal(row);
        calculateGrandTotal();
    });

    // On quantity or discount change
    $(document).on('input', '.quantity, .discount', function() {
        let row = $(this).closest('.line-item');
        calculateRowTotal(row);
        calculateGrandTotal();
    });

    // Add line item
    $(document).on('click', '.add-line', function() {
        let newRow = $('#line-items .line-item:first').clone();
        newRow.find('select, input').each(function() {
            let name = $(this).attr('name');
            if (name) {
                let newName = name.replace(/\d+/, lineIndex);
                $(this).attr('name', newName);
            }
            $(this).val('');
        });
        newRow.find('.quantity').val(1);
        newRow.find('.discount').val(0);
        newRow.find('.total, .price').val('');
        $('#line-items').append(newRow);
        lineIndex++;
    });

    // Remove line item
    $(document).on('click', '.remove-line', function() {
        if ($('.line-item').length > 1) {
            $(this).closest('.line-item').remove();
            calculateGrandTotal();
        } else {
            alert('At least one product line is required.');
        }
    });

    // Submit form
    $('#saleForm').submit(function(e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: "POST",
            data: form.serialize(),
            success: function(response) {
                toastr.success('Sale created successfully!');
                form.trigger('reset');
                $('#line-items').find('.line-item:gt(0)').remove();
                $('#line-items .line-item:first').find('input, select').val('');
                $('#line-items .line-item:first').find('.quantity').val(1);
                $('#line-items .line-item:first').find('.discount').val(0);
                $('#grand_total').val('');
                lineIndex = 1;
            },
            error: function(xhr) {
                toastr.error('Something went wrong!');
            }
        });
    });
});
</script>
@endpush
