@extends('layouts.master')
@section('title')
    @lang('common.add')@lang('app.course-module-answer')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course master')
        @endslot
        @slot('title')
            @if ($editable)
                @lang('common.edit')@lang('app.course-module-answer')
            @else
                @lang('common.add')@lang('app.course-module-answer')
            @endif
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('common.details')</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('course_parameters.index') }}">
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
                                    'name' => 'module_id',
                                    'displayName' => 'Module Id',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type'=>'number'
                                ])
                                @include('components/formColumn', [
                                    'name' => 'app_ans_active_start_time',
                                    'displayName' => 'Active Start Time',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type'=>'time'
                                ])

                                @include('components/formColumn', [
                                    'name' => '	app_ans_active_end_time',
                                    'displayName' => 'Active End Time',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type'=>'time'
                                ])

                                @include('components/formColumn', [
                                    'name' => 'maximum_mark',
                                    'displayName' => 'Maximum Mark',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'answer_string',
                                    'displayName' => 'Answer',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => '	q1valid',
                                    'displayName' => 'Q1 Valid',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'q2valid',
                                    'displayName' => 'Q2 Valid',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'q3valid',
                                    'displayName' => 'Q3 Valid',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                                   
                                @include('components/formColumn', [
                                    'name' => 'courses_master_id',
                                    'displayName' => 'Course',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type'=>'number'
                                ])

                                @include('components/formColumn', [
                                    'name' => 'num_of_answers',
                                    'displayName' => 'Number of Answers',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type'=>'number'
                                ])
                                @include('components/formColumn', [
                                    'name' => 'num_of_correct_answer',
                                    'displayName' => 'Num Of Correct Answer',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                              
                                @include('components/formColumn', [
                                    'name' => 'comments',
                                    'displayName' => 'Comments',
                                    'editable' => $editable,
                                    'required' => true,
                                ])

                                @include('components/formColumn', [
                                    'name' => 'address3',
                                    'displayName' => 'Address',
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
                    var url = "{{ route('course_module_answers.store') }}";
                    data.append('id', {{ $editable->id }});
                    ajaxRequest('post', url, data, $(this), "{{ route('course_module_answers.index') }}");
                @else
                    var url = '{{ route("course_module_answers.store") }}';
                    ajaxRequest('post', url, data, $(this), "{{ route('course_module_answers.index') }}");
                @endif
            });
        });
    </script>
@endsection
