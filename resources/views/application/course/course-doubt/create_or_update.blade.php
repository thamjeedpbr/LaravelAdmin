@extends('layouts.master')
@section('title')
    Course Doubt Answering
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course master')
        @endslot
        @slot('title')
            Course Doubt Answering
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Doubt from {{ $course->course_name }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('course_doubt.index') }}">
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="las la-list"></i>@lang('common.list')</button></a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post" action="{{ route('course_doubt.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-12 col-md-12">
                                    <label for="type" class="form-label">Question</label>
                                    <p>{{ $editable->doubt }}</p>

                                </div>
                                <div class="col-xxl-12 col-md-4">
                                    <label class="form-label">Answer</label>
                                    <textarea class="form-control" name="answer" rows="10" required> @if ($editable)
                                        {{ $editable->answer }}
                                        @endif
                                        </textarea>
                                </div>

                                <input type="hidden" name="id" value="{{ $editable->id }}">
                                <div class="text-end mb-4">
                                    <button type="submit" class="btn btn-primary w-sm">
                                        @lang('common.update')

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
