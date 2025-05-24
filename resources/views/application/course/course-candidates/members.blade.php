@extends('layouts.master')
@section('title')
user Modules
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('settings.settings')
        @endslot
        @slot('title')
           Members
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('common.add') Members</h4>

                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post">
                            @csrf
                            <div class="row gy-4">
                               
                                <div class="col-xxl-12 col-md-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="age" min="1" name="age"
                                        value="0" required>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                        value="">
                                </div>
                           
                                <input type="hidden" value name="id" id="id">
                                <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
                                <div class="text-end mb-4">
                                    <button type="submit" class="btn btn-primary w-sm">Save</button>
                                </div>
                            </div>
                        </form>
                        <!--end row-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
        </div>


        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Members of {{ $user->name }}</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customerList">
                        {{-- <div class="row g-4 mb-3">
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control search" placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap" id="data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="display: none;"></th>
                                        <th class="sort" style="width: 50px;">Id</th>
                                        <th class="sort" data-sort="module_id">Name</th>
                                        <th class="sort" data-sort="module_id">Age</th>
                                        <th class="sort" data-sort="module_id">Roll Number</th>
                                        <th class="sort" data-sort="module_id">Mobile</th>
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
                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                        orders for you search.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
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
            var userid = @json($user->id);
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('user_members.data') }}',
                    type: 'GET',
                    data: {
                        userid: userid
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
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
                        data: 'roll_number',
                        name: 'roll_number'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
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
                ajaxRequest('post', '{{ route('user_members.save') }}', data, $(this));
            });



            $('#data-table tbody').on('click', 'td .editBtn', function() {
                var row = $(this).closest('tr').index();
                var data = table.row(row).data();
                console.log(data);
                $('#name').val(data.name);
                $('#age').val(data.age);
                $('#mobile').val(data.mobile);
                $('#id').val(data.id);
                $('#name').focus();
            });

            $('#data-table tbody').on('click', 'td .removeBtn', function() {
                var row = $(this).closest('tr').index();
                var data = table.row(row).data();
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
                        ajaxRequest('delete', '{{ route('user_members.destroy', '') }}/' + id + '');
                    }
                });
            });
        });
    </script>
@endsection
