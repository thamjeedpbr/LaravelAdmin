@extends('layouts.master')
@section('title')
    @lang('app.course-refrences')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course master')
        @endslot
        @slot('title')
            @lang('app.course-refrences')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('app.course-refrences')</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('course_refrences.create')}}">
                        <button type="button" class="btn btn-primary rounded-pill">
                            <i class="las la-plus"></i>@lang('common.add')</button></a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div id="customerList">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap" id="data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="display: none;"></th>
                                        <th scope="col" style="width: 20px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <th class="sort" style="width: 50px;">#SL</th>
                                        <th class="sort" data-sort="type">Type</th>
                                        <th class="sort" data-sort="type_number">Type Number</th>
                                        <th class="sort" data-sort="module_id">Module Id</th>
                                        <th class="sort" data-sort="ref_num">Refrence Number</th>
                                        <th class="sort" data-sort="reference_text">Refrence Text</th>
                                        <th class="sort" data-sort="action" style="width: 50px;">Action</th>
                                    </tr>
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
                                    <p class="text-muted mb-0"></p>
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
                ajax: '{{ route("get.course_refrences") }}',
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'check_box',
                        name: 'check_box'
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'type_number',
                        name: 'type_number'
                    },
                    {
                        data: 'module_id',
                        name: 'module_id'
                    },
                    {
                        data: 'ref_num',
                        name: 'ref_num'
                    },
                    {
                        data: 'reference_text',
                        name: 'reference_text'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            $("#form").submit(function(e) {
                e.preventDefault();
                var data = new FormData(this);
                ajaxRequest('post', '{{ route('users.store') }}', data ,$(this));
            });

            $('#data-table tbody').on('click', 'td .enableBtn', function() {
                var checked = $(this).prop("checked");
                var row = $(this).closest('tr').index();
                var data = table.row(row).data();
                ajaxRequest('post', '{{ route('users.change-status') }}',{ id : data.id});
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
        });
    </script>
@endsection
