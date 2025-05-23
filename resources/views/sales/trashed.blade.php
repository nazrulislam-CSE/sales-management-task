@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sales Trashed List</h5>
                    <div>
                        <a href="{{ route('sales.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
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
@endsection

@push('scripts')
<script type="text/javascript">
$(function () {
   var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('sales.trashed') }}",
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

    // Restore
    $(document).on('click', '.btn-restore', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to restore this sale?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/sales/' + id + '/restore', {_token: '{{ csrf_token() }}'}, function(data) {
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
                    Swal.fire('Error!', 'Restore failed.', 'error');
                });
            }
        });
    });

    // Force Delete
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you absolutely sure?',
            text: "This will permanently delete the sale!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it permanently!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/sales/' + id + '/force-delete',
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(data) {
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
                    },
                    error: function() {
                        Swal.fire('Error!', 'Delete failed.', 'error');
                    }
                });
            }
        });
    });
 
});
</script>
@endpush
