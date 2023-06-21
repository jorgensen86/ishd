<div class="form-group">
    <label>{{ $label }}</label>
    <select name="{{ $inputName }}" class="form-control">
        @foreach ($options as $option)
            <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    </select>
</div>