<div class="form-group">
    <label>{{ $label }}</label>
    <select name="{{ $inputName }}" class="form-control">
        <option value="">{{ __('el.text_select') }}</option>
        @foreach ($options as $option)
            @if (is_array($option))
                <option {{ $selected == $option['id'] ? 'selected' : null }} value="{{ $option['id'] }}">
                    {{ $option['name'] }}</option>
            @else
                <option {{ $selected == $option->id ? 'selected' : null }} value="{{ $option->id }}">
                    {{ $option->name }}</option>
            @endif
        @endforeach
    </select>
</div>
