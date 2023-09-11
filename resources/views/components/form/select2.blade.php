<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $id }}" style="visibility:hidden"
        {{ $multiple ? 'multiple' : null }}>
        @if ($options)
            @foreach ($options as $option)
                <option value="{{ $option->invoice_id }}" @selected(true)>{{ $option->invoice_number }} ({{ $option->domain }})</option>
            @endforeach
        @endif
    </select>
</div>
