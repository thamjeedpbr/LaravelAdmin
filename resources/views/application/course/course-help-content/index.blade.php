@extends('layouts.master')
@section('title')
    @lang('app.courses') Content Helper
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Course Master
        @endslot
        @slot('li_1_route')
            {{ route('course_master.index') }}
        @endslot
        @slot('title')
            @lang('app.courses') Content Helper For {{ $course->course_name }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('app.courses') Content Helper For {{ $course->course_name }}
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('course_help_contents.create', ['courseid' => $course->id]) }}">
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
                                        <th class="sort" style="width: 50px;">#SL</th>
                                        <th class="sort" data-sort="type">Content Type</th>
                                        <th class="sort" data-sort="action" style="width: 50px;">Action</th>
                                        <th class="sort" data-sort="title">Title</th>
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
            var courseid = @json($course->id);
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('get.course_help_contents') }}',
                    type: 'GET',
                    data: {
                        courseid: courseid
                    }
                },

                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
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
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'title',
                        name: 'title'
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
        });
    </script>
@endsection
