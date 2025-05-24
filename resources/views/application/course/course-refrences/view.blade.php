@extends('layouts.master')
@section('title')
    @lang('common.add')@lang('app.course-refrence')
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
            @lang('app.course-refrence') For
            {{ \App\Models\CoursesMaster::getName($module->courses_master_id) . ' ' . \App\Models\CoursesModuleAnswerString::getName($module->id) }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('common.details')</h4>

                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post" action="{{ route('course_refrences.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <input type="hidden" name="courses_master_id" id="courses_master_id"
                                    value="{{ $module->courses_master_id }}">
                                <input type="hidden" name="module_id" id="module_id" value="{{ $module->id }}">
                                @if ($reference)
                                    <input type="hidden" name="id" id="id" value="{{ $reference->id }}">
                                @endif
                                @include('components/formColumn', [
                                    'name' => 'class_audio',
                                    'displayName' => 'Class Audio',
                                    'editable' => false,
                                    'required' => false,
                                    'type' => 'file',
                                    'accept' => '.mp3',

                                ])
                                @include('components/formColumn', [
                                    'name' => 'class_video_link',
                                    'displayName' => 'Video ID',
                                    'editable' => $reference,
                                    'required' => false,
                                    'placeholder' => 'z3yJ-UfHwL8',
                                ])
                                @if ($reference)
                                    @if (isset($reference->class_audio))
                                        <div class="col-xxl-4 col-md-4">
                                            <div class="col-xxl-4 col-md-4">
                                                <label for="class_audio_ur" class="form-label">Class
                                                    Audio File</label>
                                                <audio controls>
                                                    <source src="{{ $reference->class_audio_url }}" type="audio/mp3">
                                                </audio>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="col-xxl-12 col-md-4">
                                    <label class="form-label">Reference</label>
                                    <textarea class="form-control" name="reference" id="editor" rows="10"> @if ($reference)
{{ $reference->reference_text }}
@endif
                                    </textarea>
                                </div>
                                <div class="text-end mb-4">
                                    <button type="submit" class="btn btn-primary w-sm">
                                        @if ($reference)
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
@endsection
