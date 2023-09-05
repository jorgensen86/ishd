<div class="modal-header bg-light">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="queueForm" autocomplete="false">
        @csrf
        <x-admin.form.text name="name" id="inputName" placeholder="{{ __('queue.name') }}" :value="$data->name"></x-admin.form.text>
        <x-form.checkbox :active="$data->active" :label="__('queue.status')"></x-form.checkbox>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" id="btnCancel" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#queueForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
