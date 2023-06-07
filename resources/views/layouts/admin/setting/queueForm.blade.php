<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="queueForm" autocomplete="false">
        @csrf
        <div class="form-group">
            <label for="inputName">{{ __('admin/setting/queue.name') }}</label>
            <input type="text" class="form-control form-control-border border-width-2" id="inputName" name="name" value="{{ $queue->name }}" placeholder="{{ __('admin/setting/queue.name') }}">
        </div>
        <div class="custom-control custom-switch mb-3">
            <input type="checkbox" class="custom-control-input" id="inputActive" name="active" value="1"
                {{ $queue->active ? 'checked' : null }}>
            <label class="custom-control-label" for="inputActive">{{ __('el.enable') }}</label>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#queueForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
