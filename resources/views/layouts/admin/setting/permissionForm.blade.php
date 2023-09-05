<div class="modal-header bg-light">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="permissionForm" autocomplete="false">
        @csrf
        <x-form.text name="name" id="inputName" placeholder="{{ __('permission.name') }}" :value="$data->name"></x-form.text>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <x-modal.close-button></x-modal.close-button>
    <button type="button" id="btnSave" data-form="#permissionForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
