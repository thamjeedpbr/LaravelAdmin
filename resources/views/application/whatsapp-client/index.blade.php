@extends('layouts.master')
@section('title')
    Whatsapp Modules
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            WhatsApp Client
        @endslot
        @slot('li_1_route')
        @endslot
        @slot('title')
            WhatsApp Client
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('common.add') WhatsApp Client</h4>

                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post">
                            @csrf
                            <div class="row gy-4">

                                <div class="col-xxl-12 col-md-12" id="module_div">
                                    <label for="client_id" class="form-label">Client Id</label>
                                    <input type="text" min="0" class="form-control" id="client_id"
                                        name="client_id" required readonly>
                                </div>
                                <div class="col-xxl-12 col-md-12" id="module_div">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" min="0" class="form-control" id="name" name="name"
                                        required>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <label for="phone_number" class="form-label">WhatsApp Number(with countrycode)</label>
                                    <input type="number" min="0" class="form-control" name="phone_number"
                                        placeholder="919544446002" id="phone_number" required>
                                </div>
                                <!-- QR Code Display Container -->
                                <div id="qr_code_container" class="col-xxl-12 col-md-12"></div>

                                <input type="hidden" value name="id" id="id">
                                <div class="text-end mb-4">
                                    <button type="button" id="init" class="btn btn-warning w-sm">Initialize</button>
                                </div>
                                <div class="text-end mb-4">
                                    <button type="submit" style="display: none;" id="saveButton"
                                        class="btn btn-primary w-sm">Save</button>
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
                    <h4 class="card-title mb-0">WhatsApp Client Lists</h4>
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
                                        <th class="sort" style="width: 50px;">ID</th>
                                        <th class="sort" data-sort="type">Client Id</th>
                                        <th class="sort" data-sort="type">User</th>
                                        <th class="sort" data-sort="type">Name</th>
                                        <th class="sort" data-sort="title">Phone</th>
                                        <th class="sort" data-sort="title">Status</th>
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

                        {{-- <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div> --}}
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
                ajax: '{{ route('get.whatsapp_client') }}',

                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'client_id',
                        name: 'client_id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('#init').click(function() {
                // Disable the button
                this.disabled = true;

                // Show a loading indicator (you can use a spinner or text)
                this.innerHTML = 'Loading...';
                // Retrieve values from form inputs
                var client_id = $('#client_id').val();
                var name = $('#name').val();
                var phone_number = $('#phone_number').val();
                var id = $('#id').val();

                // Construct the data object to be sent
                var data = {
                    phone_number: phone_number,
                    id: id,
                    name: name,
                    client_id: client_id
                };

                // Perform the AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{{ route('initialize.whatsapp_client') }}',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure you include CSRF token for Laravel
                    },
                    success: function(response) {
                        if (response.data) {
                            // Hide the initialization button
                            document.getElementById('init').style.display = 'none';

                            // Show the save button
                            document.getElementById('saveButton').style.display = 'block';
                            // Insert the QR code image into the form
                            $('#qr_code_container').html('<img src="' + response.data +
                                '" alt="QR Code" />');
                        } else {
                            document.getElementById('init').disabled = false;
                            document.getElementById('init').innerHTML = "Initialize";
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        document.getElementById('init').disabled = false;
                        document.getElementById('init').innerHTML = "Initialize";

                        alert('Error: ' + xhr.responseText);
                    }
                });

                alert('Phone number: ' + phone_number);
            });

            $("#form").submit(function(e) {
                e.preventDefault();
                var data = new FormData(this);
                ajaxRequest('post', '{{ route('whatsapp_client.store') }}', data, $(this));
                // Hide the initialization button
                document.getElementById('init').style.display = 'block';

                // Show the save button
                document.getElementById('saveButton').style.display = 'none';
                document.getElementById('qr_code_container').style.display = 'none';

                // enable the button
                document.getElementById('init').disabled = false;
                document.getElementById('init').innerHTML = "Initialize";
            });



            $('#data-table tbody').on('click', 'td .editBtn', function() {
                var row = $(this).closest('tr').index();
                var data = table.row(row).data();
                $('#client_id').val(data.client_id);
                $('#name').val(data.name);
                $('#phone_number').val(data.phone_number);
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
                        ajaxRequest('delete', '{{ route('whatsapp_client.destroy', '') }}/' + id +
                            '');
                    }
                });
            });
        });
    </script>
@endsection
