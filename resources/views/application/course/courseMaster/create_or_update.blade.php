@extends('layouts.master')
@section('title')
    @lang('common.add')@lang('app.course')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Course Master
        @endslot
        @slot('li_1_route')
            {{ route('course_master.index') }}
        @endslot

        @slot('title')
            @if ($editable)
                @lang('common.edit')@lang('app.course')
            @else
                @lang('common.add')@lang('app.course')
            @endif
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('common.details')</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('course_master.index') }}">
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
                                    'name' => 'course_name',
                                    'displayName' => 'Course Name',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'course_name_eng',
                                    'displayName' => 'Course Name (Eng)',
                                    'editable' => $editable,
                                    'required' => true,
                                ])

                                <div class="col-xxl-4 col-md-12">
                                    <label for="type" class="form-label">Course Type</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="">Select Course Type</option>
                                        @foreach (App\Models\CoursesMaster::courseTypeOptions() as $key => $type)
                                            <option value="{{ $key }}"
                                                @if (isset($editable->type) && $editable->type == $key) selected @endif>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @include('components/formColumn', [
                                    'name' => 'scholar',
                                    'displayName' => 'Scholar',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'course_description',
                                    'displayName' => 'Course Description',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'total_modules',
                                    'displayName' => 'Total Modules',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                <div class="col-xxl-4 col-md-12">
                                    <label for="featured_type" class="form-label">Feature Type</label>
                                    <select class="form-control" id="featured_type" name="featured_type" required>
                                        <option>Select One</option>
                                        @foreach (App\Models\CoursesMaster::featuredTypeOptions() as $option)
                                            <option value="{{ $option }}"
                                                @if ($editable) {{ $editable->featured_type == $option ? 'selected' : '' }} @endif>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @include('components/formColumn', [
                                    'name' => 'wt_class_test',
                                    'displayName' => 'Class Test Weightage',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type' => 'number',
                                ])

                                @include('components/formColumn', [
                                    'name' => 'wt_review',
                                    'displayName' => 'Review Weightage',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type' => 'number',
                                ])

                                @include('components/formColumn', [
                                    'name' => 'wt_assignment',
                                    'displayName' => 'Assignment Weightage',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type' => 'number',
                                ])

                                @include('components/formColumn', [
                                    'name' => 'wt_final',
                                    'displayName' => 'Final Exam Weightage',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type' => 'number',
                                ])
                                @include('components/formColumn', [
                                    'name' => 'class_test_last_date',
                                    'displayName' => 'Course Class Test Last Date',
                                    'editable' => $editable,
                                    'required' => false,
                                    'type' => 'datetime-local',
                                ])
                                <div class="col-xxl-4 col-md-12">
                                    <label for="available_days" class="form-label ">Available Days</label>
                                    <select class="form-control select2" id="available_days" name="available_days[]"
                                        multiple >
                                        @foreach (App\Models\CoursesMaster::availableDaysOptions() as $key => $day)
                                            <option value="{{ $key }}"
                                                @if (isset($editable->available_days) && in_array($key, explode(',', $editable->available_days))) selected @endif>
                                                {{ $day }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @include('components/formColumn', [
                                    'name' => 'start_time',
                                    'displayName' => 'Course Start Time',
                                    'editable' => $editable,
                                    'required' => false,
                                    'type' => 'datetime-local',
                                ])
                                @include('components/formColumn', [
                                    'name' => 'end_time',
                                    'displayName' => 'Course End Time',
                                    'editable' => $editable,
                                    'required' => false,
                                    'type' => 'datetime-local',
                                ])

                                @include('components/formColumn', [
                                    'name' => 'publish_date',
                                    'displayName' => 'Course Publish Date',
                                    'editable' => $editable,
                                    'required' => false,
                                    'type' => 'datetime-local',
                                ])
                                @if ($editable)
                                @include('components/formColumn', [
                                    'name' => 'is_checked',
                                    'placeholder'=> '1 => Completed, 0 => Need To Check',
                                    'displayName' => 'Course Valuation Status',
                                    'editable' => $editable,
                                    'required' => false,
                                    'type' => 'number',
                                ])
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
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#available_days').select2({
                placeholder: "Select Available Days",
                allowClear: true
            });
        });

        $(document).ready(function() {
            $("#form").submit(function(e) {
                e.preventDefault();
                var data = new FormData(this);
                @if ($editable)
                    var url = "{{ route('course_master.store') }}";
                    data.append('id', {{ $editable->id }});
                    ajaxRequest('post', url, data, $(this), "{{ route('course_master.index') }}");
                @else
                    var url = '{{ route('course_master.store') }}';
                    ajaxRequest('post', url, data, $(this), "{{ route('course_master.index') }}");
                @endif
            });
        });
    </script>
@endsection
