<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="permissionForm" autocomplete="false">
        @csrf
        <x-admin.form.text inputName="name" labelFor="inputName" placeholder="{{ __('admin/setting/subject.name') }}" :value="$data->name"></x-admin.form.text>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#permissionForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
