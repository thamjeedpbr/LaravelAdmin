@extends('layouts.master')
@section('title')
    @lang('app.courses') Late Request
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course master')
        @endslot
        @slot('title')
            @lang('app.courses') Late Request
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('app.courses') Late Request
                    </h4>
                    <div class="flex-shrink-0">

                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div id="customerList">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap" id="data-table">
                                <thead class="table-light">

                                </thead>
                                <tbody class="form-check-all">
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                        orders for you search.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('get.course_late_contents') }}',
                    type: 'GET',
                },

                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'course_name',
                        name: 'course_name',
                        title: 'Course Name'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        title: 'Candidate Name'
                    },
                    {
                        data: 'comments',
                        name: 'comments',
                        title: 'Reason'
                    },
                    {
                        data: 'date_range',
                        name: 'date_range',
                        title: 'Date Range'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        title: 'Status'
                    },
                    {
                        data: 'answered_by',
                        name: 'answered_by',
                        title: 'Replied By'
                    }, // Add this column
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        title: 'Actions'
                    }
                ]
            });


            $('#data-table tbody').on('click', 'td .editBtn', function() {
                var row = $(this).closest('tr').index();
                var data = table.row(row).data();
                $('#name').val(data.display_name);
                $('#id').val(data.id);
                $('#name').focus();
            });

            $('#data-table tbody').on('click', 'td .removeBtn', function() {
                var row = $(this).closest('tr').index();
                var data = table.row(row).data();
                var deleteUrl = $(this).attr('delete-url');
                var id = data.id;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                    cancelButtonClass: 'btn btn-danger w-xs mt-2',
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(function(result) {
                    if (result.value) {
                        ajaxRequest('delete', deleteUrl);
                    }
                });
            });


            $(document).on('click', '.status-btn', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');

                $.ajax({
                    url: '{{ route('course_late.status') }}', // Your route here
                    method: 'POST',
                    data: {
                        id: id,
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // CSRF token for security
                    },
                    success: function(response) {
                        // Update the status in the DataTable row
                        var row = $('button[data-id="' + id + '"]').closest('td');
                        if (status == 1) {
                            row.html('<span">Approved</span>');
                        } else if (status == 2) {
                            row.html('<span">Rejected</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                    }
                });
            });


            $('#data-table tbody').on('click', 'td .enableBtn', function() {
                var checked = $(this).prop("checked");
                var row = $(this).closest('tr').index();
                var data = table.row(row).data();
                // Send AJAX request
                $.ajax({
                    url: '{{ route('course_doubt.public') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Include CSRF token in headers
                    },
                    data: {
                        checked: checked,
                        id: data.id
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Status Updated",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "Some thing Wentwrong",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Some thing Wentwrong",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                });
            });
        });
    </script>
@endsection
