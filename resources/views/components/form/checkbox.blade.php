<div class="custom-control custom-switch mb-3">
    <input type="checkbox" class="custom-control-input" id="inputActive" name="active" value="1"
        {{ $active ? 'checked' : null }}>
    <label class="custom-control-label" for="inputActive">{{ __('el.enable') }}</label>
</div>