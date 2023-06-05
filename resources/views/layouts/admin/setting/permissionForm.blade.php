<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="permissionForm" autocomplete="false">
        @csrf
        <div class="form-group">
            <label for="inputName">{{ __('admin/setting/permission.name') }}</label>
            <input type="text" class="form-control form-control-border border-width-2" id="inputName" name="name" value="{{ $permission->name }}" placeholder="{{ __('admin/setting/permission.name') }}">
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#permissionForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
