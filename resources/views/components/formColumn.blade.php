{{-- [
    'name' => 'course_name',
    'displayName' => 'Course Name',
    'editable' => $editable,
    'required' => true,
    'type'=>'text'
] --}}
<div class="col-xxl-4 col-md-4">
    <label for="{{ $name }}" class="form-label">{{ $displayName }}</label>
    <input type="{{ $type ?? 'text' }}" placeholder="{{ $placeholder ?? '' }}" class="form-control" id="{{ $name }}"
        name="{{ $name }}" @if ($editable) value="{{ $editable[$name] }}" @endif
        @if ($required) required @endif
        @isset($accept) accept="{{ $accept }}" @endisset>
</div>
