@if ($editable)
    <h4 class="form-label">Answer Options</h4>

    <div class="row gy-6">
        @php
            $i = 1;
        @endphp
        @foreach ($options as $option)
            <div class="col-xxl-4 col-md-4">
                <label class="form-label">answer_option_{{ $i }}</label>
                @if ($module_type == 'Review')
                    <span style="margin-left: 20px; display: inline-flex; align-items: center;">
                        <label class="form-label" style="margin-right: 5px;">Option Mark</label>
                        <input type="hidden" name='answer[{{ $i }}][id]' value="{{ $option->id }}">
                        <input type="text" class="form-control" name='answer[{{ $i }}][mark]'
                            value="{{ $option->mark ?? '' }}" style="width: 60px; padding: 2px; margin: 0 5px;">
                    </span>
                @else
                    <span style="margin-left: 100px;">
                        <label class="form-label">Correct Answer</label>
                        <input type="hidden" name='answer[{{ $i }}][id]' value="{{ $option->id }}">
                        <input type="checkbox" name='answer[{{ $i }}][true]' value="1"
                            @if ($option->is_answer == 1) checked @endif>
                    </span>
                @endif
                <input type="{{ $type ?? 'text' }}" class="form-control" name='answer[{{ $i }}][option]'
                    @if ($editable) value="{{ $option->option }}" @endif required>
            </div>
            @php
                $i++;
            @endphp
        @endforeach

    </div>
@elseif(isset($options))
    <h4 class="form-label">Answer Options</h4>

    <div class="row gy-6">
        @for ($i = 1; $i <= $options; $i++)
            <div class="col-xxl-4 col-md-4">
                <label class="form-label">Answer Option {{ $i }}</label>

                @if ($data['module_type'] == 'Review')
                    <span style="margin-left: 20px; display: inline-flex; align-items: center;">
                        <label class="form-label" style="margin-right: 5px;">Option Mark</label>
                        <input type="text" class="form-control" name="answer[{{ $i }}][mark]"
                            value="" style="width: 60px; padding: 2px; margin: 0 5px;">
                    </span>
                @else
                    <span style="margin-left: 100px;">
                        <label class="form-label">Correct Answer</label>
                        <input type="checkbox" name="answer[{{ $i }}][true]" value="1">
                    </span>
                @endif
                <input type="{{ $type ?? 'text' }}" class="form-control" name="answer[{{ $i }}][option]"
                    @if ($editable) value="{{ $editable[$name] }}" @endif required>
            </div>
        @endfor
    </div>
@endif
