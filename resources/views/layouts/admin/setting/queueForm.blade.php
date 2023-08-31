<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="queueForm" autocomplete="false">
        @csrf
        <x-admin.form.text name="name" id="inputName" placeholder="{{ __('admin/setting/subject.name') }}" :value="$data->name"></x-admin.form.text>
        <x-admin.form.checkbox :active="$data->active"></x-admin.form.checkbox>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#queueForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
