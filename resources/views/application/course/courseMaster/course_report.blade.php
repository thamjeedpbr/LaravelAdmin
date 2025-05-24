@extends('layouts.master')
@section('title')
    Course Module Report
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Course Modules {{ \App\Models\CoursesMaster::getName($module->courses_master_id) }}
        @endslot
        @slot('li_1_route')
            {{ route('course_master.modules', $module->courses_master_id) }}
        @endslot
        @slot('title')
            Course Module Report
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Course Module Report  {{ \App\Models\CoursesMaster::getName($module->courses_master_id) }}</h4>
                    <div class="flex-shrink-0">
                        <a href="#">
                            <button type="button" id='evalute' class="btn btn-primary rounded-pill">
                                Evaluate</button></a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div id="customerList">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap" id="data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="display: none;"></th>
                                        <th class="sort" style="width: 50px;">Roll No</th>
                                        <th class="sort" data-sort="module_id">Candidate Name</th>
                                        <th class="sort" data-sort="maximum_mark"> Mark</th>
                                        <th class="sort" data-sort="app_ans_active_start_time">Start time</th>
                                        <th class="sort" data-sort="app_ans_active_end_time">End time</th>
                                        <th class="sort" data-sort="app_ans_active_end_time">Remark</th>
                                        <th class="sort" data-sort="">Action</th>
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
        var moduleid = @json($module->id);
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('course_module_report.data') }}',
                    type: 'GET',
                    data: {
                        moduleid: moduleid
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'roll_number',
                        name: 'courses_candidates.roll_number'
                    },
                    {
                        data: 'name',
                        name: 'courses_candidates.name'
                    },
                    {
                        data: 'mark',
                        name: 'mark'
                    },
                    {
                        data: 'start_at',
                        name: 'start_at'
                    },
                    {
                        data: 'end_at',
                        name: 'end_at'
                    },
                    {
                        data: 'remark',
                        name: 'remark'
                    },
                    {
                        orderable: false,
                        data: 'action',
                        name: 'action'
                    },

                ]
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
        $('#evalute').on('click', function() {
            ajaxRequest('get', '{{ route('course_module.evalute', '') }}/' + moduleid + '');
        });
    </script>
@endsection
