<div class="modal-header bg-light">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="subjectForm" autocomplete="false">
        @csrf
        <x-form.text name="name" id="inputName" placeholder="{{ __('subject.name') }}" :value="$data->name"></x-form.text>
        <x-form.select name="queue_id" label="{{ __('subject.queue') }}" :selected="$data->queue_id" :options="$queues"></x-form.select>
        <x-form.checkbox :active="$data->active" label="{{ __('subject.status') }}"></x-form.checkbox>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <x-modal.close-button></x-modal.close-button>
    <x-modal.save-button data-Form="#subjectForm"></x-modal.save-button>
</div>
