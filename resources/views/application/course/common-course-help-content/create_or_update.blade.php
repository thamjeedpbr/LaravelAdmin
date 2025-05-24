@extends('layouts.master')
@section('title')
    @lang('common.add') Cource Help Content
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course master')
        @endslot
        @slot('title')
            @if ($editable)
                @lang('common.edit') Cource Help Content
            @else
                @lang('common.add') Cource Help Content
            @endif
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Common Cource Help Content</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('common.course_help_contents.index') }}">
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="las la-list"></i>@lang('common.list')</button></a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post" action="{{ route('common.course_help_contents.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-4 col-md-12">
                                    <label for="type" class="form-label">Content Type</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option>Select One</option>
                                        @foreach (App\Models\CourseHelpContent::getCommonTypeOptions() as $option)
                                            <option value="{{ $option }}"
                                                @if ($editable) {{ $editable->type == $option ? 'selected' : '' }} @endif>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @include('components/formColumn', [
                                    'name' => 'title',
                                    'displayName' => 'Title',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'file',
                                    'displayName' => 'File/Image',
                                    'editable' => $editable,
                                    'required' => false,
                                    'type' => 'file',
                                ])
                                <div class="col-xxl-4 col-md-12">
                                    <label for="course_type" class="form-label">Course Type</label>
                                    <select class="form-control" id="course_type" name="course_type" required>
                                        <option>Select One</option>
                                        @foreach (App\Models\CourseHelpContent::getCourseTypeOptions() as $name => $option)
                                            <option value="{{ $option }}"
                                                @if ($editable) {{ $editable->course_type == $option ? 'selected' : '' }} @endif>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-12 col-md-4">
                                    <label class="form-label">Content</label>
                                    <textarea class="form-control" name="html" id="editor" rows="10" required> @if ($editable)
{{ $editable->html }}
@endif
                                        </textarea>
                                </div>
                                @if ($editable)
                                    <input type="hidden" name="id" value="{{ $editable->id }}">
                                @endif
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
    <!-- ckeditor -->
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
    {{-- <script>
        $(document).ready(function() {
            var courseid = @json($course->id);
            var courseHelpContentsShowUrl = '{{ route('course_help_contents.show', '') }}/' + courseid + '';
            $("#form").submit(function(e) {
                e.preventDefault();
                var data = new FormData(this);
                console.log(data);
                @if ($editable)
                    var url = "{{ route('course_help_contents.store') }}";
                    data.append('id', {{ $editable->id }});
                    ajaxRequest('post', url, data, $(this), courseHelpContentsShowUrl);
                @else
                    var url = '{{ route('course_help_contents.store') }}';
                    ajaxRequest('post', url, data, $(this), courseHelpContentsShowUrl);
                @endif
            });
        });
    </script> --}}
@endsection
