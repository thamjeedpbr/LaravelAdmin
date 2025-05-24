@extends('layouts.master')
@section('title')
    @lang('common.add')@lang('app.course-module-question')
@endsection
@section('content')
    @component('components.breadcrumb')
        @if (isset($data))
            @slot('li_1')
                Question {{ \App\Models\CoursesMaster::getName($data['master_id']) . '-' }}
                {{ \App\Models\CoursesModuleAnswerString::getName($data['module_id']) }}
            @endslot
            @slot('li_1_route')
                {{ route('view.course_module_questions', $data['module_id']) }}
            @endslot
        @elseif (isset($editable))
            @slot('li_1')
                Question {{ \App\Models\CoursesMaster::getName($editable->courses_master_id) . '-' }}
                {{ \App\Models\CoursesModuleAnswerString::getName($editable->module_id) }}
            @endslot
            @slot('li_1_route')
                {{ route('view.course_module_questions', $editable->module_id) }}
            @endslot
        @endif
        @slot('title')
            @if ($editable)
                @lang('common.edit')@lang('app.course-module-question')
            @else
                @lang('common.add')@lang('app.course-module-question')
            @endif
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    @if (isset($data))
                        <h4 class="card-title mb-0 flex-grow-1">Add Question
                            {{ \App\Models\CoursesModuleQuestions::nextQuestionNumber($data['module_id']) }} for
                            @if (isset($data))
                                {{ \App\Models\CoursesMaster::getName($data['master_id']) . '-' }}
                                {{ \App\Models\CoursesModuleAnswerString::getName($data['module_id']) }}
                            @endif
                        </h4>
                    @elseif (isset($editable))
                        <h4 class="card-title mb-0 flex-grow-1">Edit Question {{ $editable->q_num }} for
                            @if (isset($editable))
                                {{ \App\Models\CoursesMaster::getName($editable->courses_master_id) . '-' }}
                                {{ \App\Models\CoursesModuleAnswerString::getName($editable->module_id) }}
                            @endif
                        </h4>
                    @else
                        <h4 class="card-title mb-0 flex-grow-1">Add Question</h4>
                    @endif
                    <div class="flex-shrink-0">
                        @if (isset($data))
                            <a href="{{ route('view.course_module_questions', $data['module_id']) }}">
                                <button type="button" class="btn btn-primary rounded-pill">
                                    <i class="las la-list"></i>@lang('common.list')</button></a>
                        @elseif(isset($editable))
                            <a href="{{ route('view.course_module_questions', $editable->module_id) }}">
                                <button type="button" class="btn btn-primary rounded-pill">
                                    <i class="las la-list"></i>@lang('common.list')</button></a>
                        @else
                            <a href="{{ route('course_module_questions.index') }}">
                                <button type="button" class="btn btn-primary rounded-pill">
                                    <i class="las la-list"></i>@lang('common.list')</button></a>
                        @endif

                    </div>

                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">

                                {{-- @include('components/formColumn', [
                                    'name' => 'course_type',
                                    'displayName' => 'Course Type',
                                    'editable' => $editable,
                                    'required' => true,
                                ]) --}}
                                @if (isset($data))
                                    <input type="hidden" name="courses_master_id" id="courses_master_id"
                                        value="{{ $data['master_id'] }}">
                                    <input type="hidden" name="module_id" id="module_data"
                                        value="{{ $data['module_id'] }}">
                                    <input type="hidden" name="q_num" id="q_num"
                                        value="{{ \App\Models\CoursesModuleQuestions::nextQuestionNumber($data['module_id']) }}">
                                @else
                                    <div class="col-xxl-4 col-md-4"
                                        @if ($editable) style="pointer-events: none;" @endif>
                                        <label for="courses_master_id" class="form-label">Course Master</label>
                                        <select class="form-control select2" name="courses_master_id"
                                            id="courses_master_id">
                                            <option>Select One</option>
                                            @foreach ($courses_masters as $courses_master)
                                                <option value="{{ $courses_master->id }}"
                                                    @if ($editable) {{ $courses_master->id == $editable->courses_master_id ? 'selected' : '' }} @endif>
                                                    {{ $courses_master->course_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xxl-4 col-md-4"
                                        @if ($editable) style="pointer-events: none;" @endif>
                                        <label for="module_id" class="form-label">Course Module</label>
                                        <select class="form-control select2" name="module_id" id="module_data">
                                            <option>Select One</option>
                                            @foreach ($courses_modules as $courses_module)
                                                <option value="{{ $courses_module->id }}"
                                                    @if ($editable) {{ $courses_module->id == $editable->module_id ? 'selected' : '' }} @endif>
                                                    {{ $courses_module->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @include('components/formColumn', [
                                        'name' => 'q_num',
                                        'displayName' => 'Question Number',
                                        'editable' => $editable,
                                        'required' => true,
                                        'type' => 'number',
                                    ])
                                @endif


                                <div class="col-xxl-12 col-md-12">
                                    <label for="question" class="form-label">Question </label>
                                    <input type="textarea" class="form-control" id="question" name="question"
                                        @if ($editable) value="{{ $editable['question'] }}" @endif
                                        required>
                                </div>

                                @include('components/formColumn', [
                                    'name' => 'video_link',
                                    'displayName' => 'Video Link',
                                    'editable' => $editable,
                                    'required' => false,
                                ])


                                @include('components/formColumn', [
                                    'name' => 'question_audio',
                                    'displayName' => 'Question Audio',
                                    'editable' => $editable,
                                    'required' => false,
                                    'type' => 'file',
                                    'accept' => '.mp3',
                                    
                                ])
                              
                                <div class="col-xxl-4 col-md-4">
                                    <label for="group" class="form-label">Group </label>
                                    <input type="number" class="form-control" id="group" name="group" min="1"
                                        step="1"
                                        @if ($editable) value="{{ $editable['group'] }}" @else value="1" @endif
                                        required>
                                </div>
                                @if (isset($editable['question_audio']))
                                <div class="col-xxl-4 col-md-4">
                                    <label for="question_audio_url" class="form-label">Question
                                        Audio File</label>
                                    <audio controls>
                                        <source src="{{ $editable['question_audio_url'] }}" type="audio/mp3">
                                    </audio>
                                    <audio src="" autoplay></audio>

                                </div>
                            @endif
                            </div>
                            <div class="row gy-6 " style="margin-top: 14px;" id="options_data">
                                @include('application/course/course-module-questions/course-answer-options')
                            </div>
                    </div>

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
        var moduleid = $("#module_data").val();
        $(document).ready(function() {
            $("#form").submit(function(e) {
                e.preventDefault();
                var data = new FormData(this);
                @if ($editable)
                    var url = "{{ route('course_module_questions.store') }}";
                    data.append('id', {{ $editable->id }});
                    ajaxRequest('post', url, data, $(this),
                        '{{ route('view.course_module_questions', '') }}/' + moduleid + '')
                @else
                    var url = '{{ route('course_module_questions.store') }}';
                    ajaxRequest('post', url, data, $(this),
                        '{{ route('view.course_module_questions', '') }}/' + moduleid + '')
                @endif
            });
        });
        $("#courses_master_id").change(function(e) {
            e.preventDefault();
            var courses_master_id = this.value;
            $("#module_data").html('');
            $.ajax({
                url: "{{ route('get.module.for.course') }}",
                type: "POST",
                data: {
                    courses_master_id: courses_master_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    $('#module_data').html('<option value="">Select One</option>');
                    $.each(res.data, function(key, value) {
                        $("#module_data").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });

        });
        $("#module_data").change(function(e) {
            e.preventDefault();
            var courses_module_id = this.value;
            $("#options_data").html('');
            $.ajax({
                url: "{{ route('get.options.for.questions') }}",
                type: "POST",
                data: {
                    courses_module_id: courses_module_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    $('#options_data').html(res.data);

                }
            });
        });
    </script>
@endsection
