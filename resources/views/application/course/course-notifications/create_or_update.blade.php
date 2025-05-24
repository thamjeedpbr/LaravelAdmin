@extends('layouts.master')
@section('title')
    @lang('common.add')@lang('app.course-notification')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('app.course master')
        @endslot
        @slot('title')
            @if ($editable)
                @lang('common.edit')@lang('app.course-notification')
            @else
                @lang('common.add')@lang('app.course-notification')
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
                                    'name' => 'sent_to',
                                    'displayName' => 'Sent To',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'program_id',
                                    'displayName' => 'Program Id',
                                    'editable' => $editable,
                                    'required' => true,
                                ])

                                @include('components/formColumn', [
                                    'name' => 'program_name',
                                    'displayName' => 'Program Name',
                                    'editable' => $editable,
                                    'required' => true,
                                ])

                                @include('components/formColumn', [
                                    'name' => 'category',
                                    'displayName' => 'Category',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'group_id',
                                    'displayName' => 'Group',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'group_set_id',
                                    'displayName' => 'Group_set',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'group_set_srl_num',
                                    'displayName' => 'Group Set Srl Num',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'sent_from',
                                    'displayName' => 'Sent From',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                                   
                                @include('components/formColumn', [
                                    'name' => 'feedback_id',
                                    'displayName' => 'Feedback',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'notification_title',
                                    'displayName' => 'Notification Title',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                                @include('components/formColumn', [
                                    'name' => 'notification_text',
                                    'displayName' => 'Notification Text',
                                    'editable' => $editable,
                                    'required' => true,
                                ])
                              
                                @include('components/formColumn', [
                                    'name' => 'valid_t_ill_date_time',
                                    'displayName' => 'Valid Till Date Time',
                                    'editable' => $editable,
                                    'required' => true,
                                    'type'=>'date'
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
                    var url = "{{ route('course_notifications.store') }}";
                    data.append('id', {{ $editable->id }});
                    ajaxRequest('post', url, data, $(this), "{{ route('course_notifications.index') }}");
                @else
                    var url = '{{ route("course_notifications.store") }}';
                    ajaxRequest('post', url, data, $(this), "{{ route('course_notifications.index') }}");
                @endif
            });
        });
    </script>
@endsection
