<div class="modal-header bg-light">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="subjectForm" autocomplete="false">
        @csrf
        <x-form.text name="name" id="inputName" placeholder="{{ __('subject.name') }}" :value="$data->name"></x-form.text>
        <x-form.select name="queue_id" label="{{ __('subject.queue') }}" :selected="$data->queue_id" :options="$queues"></x-form.select>
        <x-admin.form.checkbox :active="$data->active"></x-admin.form.checkbox>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" id="btnCancel" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#subjectForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
