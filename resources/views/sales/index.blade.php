@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sales List</h5>
                    <div>
                        <a href="{{ route('sales.create') }}" class="btn btn-success btn-sm me-2">
                            <i class="fas fa-plus me-1"></i> Add Sale
                        </a>
                        <a href="{{ route('sales.trashed') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-trash-restore me-1"></i> Restore List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form id="filter-form" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <input type="text" name="customer_name" class="form-control" placeholder="Customer Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_from" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_to" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-1">
                            <button type="button" id="reset-filter" class="btn btn-danger w-100">Clear</button>
                        </div>
                    </form>

                    <!-- DataTable -->
                    <table class="table table-bordered data-table table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">Sale Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="saleDetails">
        <!-- AJAX-loaded content will be here -->
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">
$(function () {
   var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('sales.index') }}",
        data: function (d) {
            d.customer_name = $('input[name=customer_name]').val();
            d.product_name  = $('input[name=product_name]').val();
            d.date_from     = $('input[name=date_from]').val();
            d.date_to       = $('input[name=date_to]').val();
        }
    },
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            text: 'Copy',
            className: 'btn btn-secondary btn-sm'
        },
        {
            extend: 'excelHtml5',
            text: 'Excel',
            className: 'btn btn-success btn-sm'
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            className: 'btn btn-danger btn-sm'
        },
        {
            extend: 'print',
            text: 'Print',
            className: 'btn btn-info btn-sm'
        },
        {
            text: 'Reset Filters',
            className: 'btn btn-warning btn-sm',
            action: function () {
                $('#filter-form')[0].reset();
                table.draw();
            }
        }
    ],
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'customer_name', name: 'customer.name'},
        {data: 'date', name: 'date'},
        {data: 'total', name: 'total'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
    });


    // Filter form submit
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });

    // Reset button
    $('#reset-filter').click(function () {
        $('#filter-form')[0].reset();
        table.draw();
    });

    // show
    $(document).on('click', '.btn-view', function() {
        var id = $(this).data('id');

        $.get('/sales/' + id, function(data) {
        let createdAt = new Date(data.created_at);
        let options = { day: 'numeric', month: 'long', year: 'numeric' };
        let formattedDate = createdAt.toLocaleDateString('en-US', options);

        let html = `
            <p><strong>Customer:</strong> ${data.customer?.name ?? 'N/A'}</p>
            <p><strong>Total Amount:</strong> ${data.total}</p>
            <p><strong>Created At:</strong> ${formattedDate}</p>
            <h5>Products:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
        `;

        data.items.forEach(item => {
            html += `
                <tr>
                    <td>${item.product?.name ?? 'N/A'}</td>
                    <td>${item.quantity}</td>
                    <td>${item.price}</td>
                    <td>${(item.quantity * item.price).toFixed(2)}</td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
        `;

        $('#saleDetails').html(html);
        $('#viewModal').modal('show');
        });
    });


    // Trash
    $(document).on('click', '.btn-trash', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to move this sale to trash!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, trash it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/sales/' + id + '/trash', {_token: '{{ csrf_token() }}'}, function(data) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    $('.data-table').DataTable().ajax.reload();
                }).fail(function() {
                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );
                });
            }
        });
        });

    });
</script>
@endpush
