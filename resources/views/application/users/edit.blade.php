@extends('layouts.master')
@section('title')
    @lang('app.users')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.app')
        @endslot
        @slot('title')
            @lang('app.users')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('common.edit') @lang('app.user')</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('users.index') }}">
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="las la-list"></i>@lang('common.list')</button></a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        value="{{ $editable->name }}">
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        value="{{ $editable->email }}">
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" id="phone" name="phone" required
                                        value="{{ $editable->phone }}">
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-control" data-choices name="role" id="role" required>
                                        <option value>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if ($editable->roles->first()->id == $role->id) selected @endif>{{ $role->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <label for="no_of_client" class="form-label">No.of Clients</label>
                                    <input type="number" class="form-control" id="no_of_client"
                                        value="{{ $editable->no_of_client }}" name="no_of_client" required>
                                </div>
                                <div class="col-xxl-4 col-md-4">
                                    <label for="valid_till" class="form-label">Valid Till</label>
                                    <input type="datetime-local" class="form-control" id="valid_till"
                                        value="{{ $editable->valid_till }}" name="valid_till" required>
                                </div>
                                <input type="hidden" name="id" value="{{ $editable->id }}">
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#form").submit(function(e) {
                e.preventDefault();
                var data = new FormData(this);
                var url = "{{ route('users.update', $editable->id) }}";
                ajaxRequest('post', url, data, $(this), "{{ route('users.index') }}");


            });
        });
    </script>
@endsection
