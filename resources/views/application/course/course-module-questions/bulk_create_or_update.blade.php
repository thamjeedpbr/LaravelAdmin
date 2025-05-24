@extends('layouts.master')
@section('title')
    @lang('common.add') Bulk @lang('app.course-module-question')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Question {{ \App\Models\CoursesMaster::getName($data['master_id']) . '-' }}
            {{ \App\Models\CoursesModuleAnswerString::getName($data['module_id']) }}
        @endslot
        @slot('li_1_route')
            {{ route('view.course_module_questions', $data['module_id']) }}
        @endslot
        @slot('title')
            @if ($data['questions'])
                @lang('common.edit') Bulk @lang('app.course-module-question')
            @else
                @lang('common.add') Bulk @lang('app.course-module-question')
            @endif
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    @if ($data['questions'])
                        <h4 class="card-title mb-0 flex-grow-1">Edit Question for
                        @else
                            <h4 class="card-title mb-0 flex-grow-1">Add Bulk Question
                    @endif
                    for
                    @if (isset($data))
                        {{ \App\Models\CoursesMaster::getName($data['master_id']) . '-' }}
                        {{ \App\Models\CoursesModuleAnswerString::getName($data['module_id']) }}
                    @endif
                    </h4>

                    <div class="flex-shrink-0">
                        <a href="{{ route('view.course_module_questions', $data['module_id']) }}">
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="las la-list"></i>@lang('common.list')</button></a>
                    </div>

                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <form id="form" enctype="multipart/form-data" method="post">
                            @csrf
                            <input type="hidden" name="module_id" id="module_data" value="{{ $data['module_id'] }}">
                            @if ($data['questions'])
                                @foreach ($data['questions'] as $questionIndex => $question)
                                    <div class="card">
                                        <h4 class="title mb-0 flex-grow-1" style="text-align: center;">Question
                                            {{ $questionIndex + 1 }}</h4>
                                        <div class="card-body">
                                            <div class="row gy-4">
                                                <input type="hidden" name="questions[{{ $questionIndex }}][id]"
                                                    id="id{{ $questionIndex }}" value="{{ $question->id }}">
                                                <input type="hidden"
                                                    name="questions[{{ $questionIndex }}][courses_master_id]"
                                                    id="courses_master_id_{{ $questionIndex }}"
                                                    value="{{ $data['master_id'] }}">
                                                <input type="hidden" name="questions[{{ $questionIndex }}][module_id]"
                                                    id="module_data_{{ $questionIndex }}"
                                                    value="{{ $data['module_id'] }}">
                                                <input type="hidden" name="questions[{{ $questionIndex }}][q_num]"
                                                    id="q_num_{{ $questionIndex }}" value="{{ $questionIndex + 1 }}">

                                                <div class="col-xxl-12 col-md-12">
                                                    <label for="question_{{ $questionIndex }}" class="form-label">Question
                                                        {{ $questionIndex + 1 }}</label>
                                                    <textarea class="form-control" id="question_{{ $questionIndex }}" name="questions[{{ $questionIndex }}][question]"
                                                        required>{{ $question->question }}</textarea>
                                                </div>


                                                <div class="col-xxl-4 col-md-4">
                                                    <label for="video_link_{{ $questionIndex }}" class="form-label">Video
                                                        Link</label>
                                                    <input type="file" class="form-control"
                                                        id="video_link_{{ $questionIndex }}"
                                                        name="questions[{{ $questionIndex }}][video_link]" value="">
                                                </div>
                                                <div class="col-xxl-4 col-md-4">
                                                    <label for="group_{{ $questionIndex }}" class="form-label">Group
                                                    </label>
                                                    <input type="number" class="form-control"
                                                        id="group_{{ $questionIndex }}"
                                                        name="questions[{{ $questionIndex }}][group]" min="1"
                                                        step="1" value="{{ $question->group }}" required>
                                                </div>


                                                <div class="col-xxl-4 col-md-4">
                                                    <label for="question_audio_{{ $questionIndex }}"
                                                        class="form-label">Question Audio</label>
                                                    <input type="file" class="form-control"
                                                        id="question_audio_{{ $questionIndex }}"
                                                        name="questions[{{ $questionIndex }}][question_audio]"
                                                        value="" accept=".mp3">
                                                </div>
                                                @if (isset($question->question_audio))
                                                    <div class="col-xxl-4 col-md-4">
                                                        <label for="question_audio_url{{ $questionIndex }}"
                                                            class="form-label">Question Audio File</label>
                                                        <audio controls>
                                                            <source src="{{ $question->question_audio_url }}"
                                                                type="audio/mp3">
                                                        </audio>
                                                    </div>
                                                @endif


                                            </div>

                                            <div class="row gy-6" style="margin-top: 14px;"
                                                id="options_data_{{ $questionIndex }}">
                                                <h5 class="form-label" style="text-align: center;">Answer Options for
                                                    Question {{ $questionIndex + 1 }}</h5>
                                                <div class="row gy-6">
                                                    @foreach ($question->options as $optionIndex => $option)
                                                        <div class="col-xxl-4 col-md-4">
                                                            <label class="form-label">Answer Option
                                                                {{ $optionIndex + 1 }}</label>

                                                            @if ($data['module_type'] == 'Review')
                                                                <span style="display: inline-flex; align-items: center;">
                                                                    <label class="form-label"
                                                                        style="margin-right: 5px;">Option Mark</label>
                                                                    <input type="hidden"
                                                                        name="questions[{{ $questionIndex }}][answer][{{ $optionIndex }}][id]"
                                                                        value="{{ $option->id }}">
                                                                    <input type="number" class="form-control"
                                                                        name="questions[{{ $questionIndex }}][answer][{{ $optionIndex }}][mark]"
                                                                        value="{{ $option->mark }}"
                                                                        style="width: 60px; padding: 2px;">
                                                                </span>
                                                            @else
                                                                <span style="display: inline-flex; align-items: center;">
                                                                    <label class="form-label"
                                                                        style="margin-right: 5px;">Correct
                                                                        Answer</label>
                                                                    <input type="hidden"
                                                                        name="questions[{{ $questionIndex }}][answer][{{ $optionIndex }}][id]"
                                                                        value="{{ $option->id }}">
                                                                    <input type="checkbox"
                                                                        name="questions[{{ $questionIndex }}][answer][{{ $optionIndex }}][true]"
                                                                        value="1"
                                                                        @if ($option->is_answer) checked @endif>
                                                                </span>
                                                            @endif
                                                            <input type="text" class="form-control"
                                                                name="questions[{{ $questionIndex }}][answer][{{ $optionIndex }}][option]"
                                                                value="{{ $option->option }}" required>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @for ($q = 1; $q <= $data['no_of_questions']; $q++)
                                    <div class="card">
                                        <h4 class="title mb-0 flex-grow-1" style="text-align: center;">Question
                                            {{ $q }}</h4>
                                        <div class="card-body">

                                            <div class="row gy-4">
                                                <input type="hidden"
                                                    name="questions[{{ $q }}][courses_master_id]"
                                                    id="courses_master_id_{{ $q }}"
                                                    value="{{ $data['master_id'] }}">
                                                <input type="hidden" name="questions[{{ $q }}][module_id]"
                                                    id="module_data_{{ $q }}"
                                                    value="{{ $data['module_id'] }}">
                                                <input type="hidden" name="questions[{{ $q }}][q_num]"
                                                    id="q_num_{{ $q }}" value="{{ $q }}">
                                                <div class="col-xxl-12 col-md-12">
                                                    <label for="question_{{ $q }}" class="form-label">Question
                                                        {{ $q }}</label>
                                                    <textarea class="form-control" id="question_{{ $q }}" name="questions[{{ $q }}][question]"
                                                        required></textarea>
                                                </div>
                                                @include('components/formColumn', [
                                                    'name' => 'questions[' . $q . '][question_audio]',
                                                    'displayName' => 'Question Audio',
                                                    'editable' => false,
                                                    'required' => false,
                                                    'type' => 'file',
                                                ])
                                                @include('components/formColumn', [
                                                    'name' => 'questions[' . $q . '][video_link]',
                                                    'displayName' => 'Video Link',
                                                    'editable' => false,
                                                    'required' => false,
                                                ])
                                                <div class="col-xxl-4 col-md-4">
                                                    <label for="group_{{ $q }}" class="form-label">Group
                                                    </label>
                                                    <input type="number" class="form-control"
                                                        id="group_{{ $q }}"
                                                        name="questions[{{ $q }}][group]" min="1"
                                                        step="1" value="1" required>
                                                </div>
                                            </div>

                                            <div class="row gy-6" style="margin-top: 14px;"
                                                id="options_data_{{ $q }}">
                                                <h5 class="form-label" style="text-align: center;">Answer Options for
                                                    Question {{ $q }}</h5>

                                                <div class="row gy-6">
                                                    @for ($o = 1; $o <= $data['no_of_options']; $o++)
                                                        <div class="col-xxl-4 col-md-4">
                                                            <div style="display: flex; align-items: center;">
                                                                <label class="form-label"
                                                                    style="margin-right: 10px;">Answer Option
                                                                    {{ $o }}</label>
                                                                @if ($data['module_type'] == 'Review')
                                                                    <span
                                                                        style="display: inline-flex; align-items: center;">
                                                                        <label class="form-label"
                                                                            style="margin-right: 5px;">Option Mark</label>
                                                                        <input type="number" class="form-control"
                                                                            name="questions[{{ $q }}][answer][{{ $o }}][mark]"
                                                                            value=""
                                                                            style="width: 60px; padding: 2px;">
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        style="display: inline-flex; align-items: center;">
                                                                        <label class="form-label"
                                                                            style="margin-right: 5px;">Correct
                                                                            Answer</label>
                                                                        <input type="hidden"
                                                                            name="questions[{{ $q }}][answer][{{ $o }}][id]"
                                                                            value="">
                                                                        <input type="checkbox"
                                                                            name="questions[{{ $q }}][answer][{{ $o }}][true]"
                                                                            value="1">
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="questions[{{ $q }}][answer][{{ $o }}][option]"
                                                                value="" required style="margin-top: 10px;">
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                    </div>

                    <div class="text-end mb-4">
                        <button type="submit" class="btn btn-primary w-sm">
                            @if ($data['questions'])
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
            var moduleid = $("#module_data").val();
            $("#form").submit(function(e) {
                e.preventDefault();
                var data = new FormData(this);
                var url = '{{ route('store.bulk.course_module_questions') }}';
                var rurl = '{{ route('view.course_module_questions', '') }}/' + moduleid;
                ajaxRequest('post', url, data, $(this),
                    '{{ route('view.course_module_questions', '') }}/' + moduleid + '')
            });
        });
    </script>
@endsection
