@extends('layouts.master')
@section('title')
    @lang('app.courses') Assignment
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course ') Assignment
        @endslot
        @slot('title')
            @lang('app.courses') Assignment of {{ $coursesMaster->course_name }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('app.courses') Assignment of {{ $coursesMaster->course_name }}
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
    <!-- Modal HTML Structure -->
    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="fileModalBody">
                    <!-- File previews will be dynamically added here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="openInNewTabBtn" style="display: none;">Open in New
                        Tab</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <style>
        .file-preview img {
            max-width: 100%;
            max-height: 80vh;
            /* Adjust height to fit viewport */
            margin-bottom: 10px;
        }

        .file-preview iframe {
            width: 100%;
            height: 80vh;
            /* Adjust height to fit viewport */
        }
    </style>
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
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('get_course.assignment') }}',
                    type: 'GET',
                    data: {
                        courseid: courseid
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        title: 'Roll Number',
                        data: 'roll_number',
                        name: 'roll_number'
                    },
                    {
                        title: 'Name',
                        data: 'candidate_name',
                        name: 'candidate_name'
                    },
                    {
                        title: 'Assignment',
                        data: 'files',
                        name: 'files'
                    }

                ],
                dom: 'Bfrtip', // Add the buttons to the DataTable
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'Course Results',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Course Results',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Course Results',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

        });
        $(document).ready(function() {
            $('#data-table').on('click', '.view-files', function() {
                var files = $(this).data('files'); // Get files data from the button's data attribute
                var fileArray = files.split(',');
                var previewHtml = '';

                if (fileArray.length === 0) {
                    previewHtml = '<p>No files available.</p>';
                } else {
                    fileArray.forEach(function(fileUrl) {
                        var fileExtension = fileUrl.split('.').pop().toLowerCase();

                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                            // Handle image files
                            previewHtml += '<div class="file-preview">';
                            previewHtml += '<img src="' + fileUrl +
                                '" class="img-fluid" style="max-width: 100%; max-height: 80vh; margin-bottom: 10px;" />';
                            previewHtml += '<br><a href="' + fileUrl +
                                '" target="_blank" class="btn btn-primary">Open Image in New Tab</a>';
                            previewHtml += '</div>';
                        } else if (fileExtension === 'pdf') {
                            // Handle PDF files
                            previewHtml += '<div class="file-preview">';
                            previewHtml += '<iframe src="' + fileUrl +
                                '" style="width: 100%; height: 80vh;" frameborder="0"></iframe>';
                            previewHtml += '<br><a href="' + fileUrl +
                                '" target="_blank" class="btn btn-primary">Open PDF in New Tab</a>';
                            previewHtml += '</div>';
                        } else {
                            // Handle other file types
                            previewHtml += '<div class="file-preview">';
                            previewHtml += '<a href="' + fileUrl +
                                '" target="_blank" class="btn btn-primary">Download ' + fileUrl
                                .split('/').pop() + '</a>';
                            previewHtml += '</div>';
                        }
                    });
                }

                $('#fileModalBody').html(previewHtml);
                $('#fileModal').modal('show');
            });
        });
    </script>
@endsection
