<div class="modal-header bg-light">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="roleForm" autocomplete="false">
        @csrf
        <x-form.text name="name" id="inputName" placeholder="{{ __('role.name') }}" :value="$data->name"></x-form.text>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <x-modal.close-button></x-modal.close-button>
    <button type="button" id="btnSave" data-form="#roleForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
