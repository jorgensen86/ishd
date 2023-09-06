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
    <x-modal.close-button></x-modal.close-button>
    <x-modal.save-button data-Form="#queueForm"></x-modal.save-button>
</div>
