<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="roleForm" autocomplete="false">
        @csrf
        <div class="form-group">
            <label for="inputName">{{ __('admin/setting/role.name') }}</label>
            <input type="text" class="form-control form-control-border border-width-2" id="inputName" name="name" value="{{ $role->name }}" placeholder="{{ __('admin/setting/role.name') }}">
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#roleForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
