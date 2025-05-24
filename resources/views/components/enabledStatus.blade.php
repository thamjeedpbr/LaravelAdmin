@php
$checked = $item == 1 ? 'checked' : '';
@endphp
<div class="form-check form-switch form-switch-right form-switch-md">
    <input class="form-check-input code-switcher enableBtn" type="checkbox" {{ $checked }}>
</div>
