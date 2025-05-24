@extends('layouts.master')
@section('title')
    @lang('common.add')@lang('app.course-refrence')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course master')
        @endslot
        @slot('title')
            @if ($editable)
                @lang('common.edit')@lang('app.course-refrence')
            @else
                @lang('common.add')@lang('app.course-refrence')
            @endif
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('common.details')</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('course_refrences.index') }}">
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="las la-list"></i>@lang('common.list')</button></a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post">
                            @csrf
                            <div class="row gy-4">

                                @include('components/formColumn', [
                                    'name' => 'type',
                                    'displayName' => 'Type',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'type_number',
                                    'displayName' => 'Type Number (Eng)',
                                    'editable' => $editable,
                                    'required' => true,
                                ])

                                @include('components/formColumn', [
                                    'name' => 'module_id',
                                    'displayName' => 'Module ID',
                                    'editable' => $editable,
                                    'required' => true,
                                ])

                                @include('components/formColumn', [
                                    'name' => 'ref_num',
                                    'displayName' => 'Reference Number',
                                    'editable' => $editable,
                                    'required' => true,
                                ])

                                @include('components/formColumn', [
                                    'name' => 'reference_text',
                                    'displayName' => 'Reference Text',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'courses_master_id',
                                    'displayName' => 'Course Master Id',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                <div class="text-end mb-4">
                                    <button type="submit" class="btn btn-primary w-sm">
                                        @if ($editable)
                                            @lang('common.update')
                                        @else
                                            @lang('common.save')
                                        @endif
                                    </button>
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
                @if ($editable)
                    var url = "{{ route('course_refrences.store') }}";
                    data.append('id', {{ $editable->id }});
                    ajaxRequest('post', url, data, $(this), "{{ route('course_refrences.index') }}");
                @else
                    var url = '{{ route("course_refrences.store") }}';
                    ajaxRequest('post', url, data, $(this), "{{ route('course_refrences.index') }}");
                @endif
            });
        });
    </script>
@endsection
