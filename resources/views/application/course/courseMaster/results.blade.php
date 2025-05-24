@extends('layouts.master')
@section('title')
    @lang('app.courses') Results
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course ') Results
        @endslot
        @slot('title')
            @lang('app.courses') Results of {{ $coursesMaster->course_name }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('app.courses') Results of {{ $coursesMaster->course_name }}
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
   $(document).ready(function() {
    var courseid = @json($coursesMaster->id);
    var courseName = @json($coursesMaster->course_name); // Pass course name as a JavaScript variable

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
            url: '{{ route('get-course-results') }}',
            type: 'GET',
            data: {
                courseid: courseid
            }
        },
        columns: [
            { data: 'id', name: 'id', visible: false },
            { title: 'Roll Number', data: 'roll_number', name: 'roll_number' },
            { title: 'Name', data: 'candidate_name', name: 'candidate_name' },
            { title: 'Class Test', data: 'class_test_mark', name: 'class_test_mark' },
            { title: 'Review', data: 'review_mark', name: 'review_mark' },
            { title: 'Assignment', data: 'assignment_mark', name: 'assignment_mark' },
            { title: 'Final', data: 'final_mark', name: 'final_mark' },
            { title: 'Total', data: 'total_mark', name: 'total_mark' }
        ],
        buttons: [
            {
                extend: 'excelHtml5',
                title: function() { return 'Course Results of ' + courseName; }, // Use function to set dynamic title
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                title: function() { return 'Course Results of ' + courseName; }, // Use function to set dynamic title
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                title: function() { return 'Course Results of ' + courseName; }, // Use function to set dynamic title
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });
});

    </script>
@endsection
