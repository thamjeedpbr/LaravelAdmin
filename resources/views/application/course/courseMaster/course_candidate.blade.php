@extends('layouts.master')
@section('title')
    Candidates of {{ \App\Models\CoursesMaster::getName($course_master_id) }}
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
            Candidates of {{ \App\Models\CoursesMaster::getName($course_master_id) }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Candidates of
                        {{ \App\Models\CoursesMaster::getName($course_master_id) }}
                    </h4>
                    <div class="flex-shrink-0">
                        {{-- <a href="{{ route('course_master.create') }}">
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="las la-plus"></i>@lang('common.add')</button></a> --}}
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div id="customerList">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap" id="data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sort">#SL</th>
                                        <th class="sort" data-sort="course_name">Roll Number</th>
                                        <th class="sort" data-sort="action">Name</th>
                                        <th class="sort" data-sort="course_id">Age</th>
                                        <th class="sort" data-sort="course_topic">Mobile Number</th>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            var course_master_id = {{ $course_master_id }};
            var table = $('#data-table').DataTable({
                "dom": 'Blfrtip', // Include the Buttons extension along with length changing input control
                "bDestroy": true,
                orderable: false,
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,

                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, 2000, -1],
                    [10, 25, 50, 100, 500, 1000, 2000, 'All']
                ],
                ajax: {
                    url: '{{ route('course_master.candidate.data', ['id' => ':id']) }}'.replace(':id',
                        course_master_id),
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'roll_number',
                        name: 'roll_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ]
            });

        });
    </script>
@endsection
