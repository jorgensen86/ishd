<div class="modal-header">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="clientForm">
        @csrf
        <div class="form-group">
            <input type="hidden" name="ticket_id" value="{{ $ticket_id }}">
            <input type="hidden" name="author_id" value="{{ auth()->user()->user_id }}">
            <x-admin.ckeditor label="{{ __('ticket.message') }}"  id="bodyEditor" name="body"></x-admin.ckeditor>
        </div>
        <div class="form-group">
            <x-admin.dropzone :action="route('upload')" formId="ticketForm"></x-admin.dropzone>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#clientForm" class="btn btn-sm btn-success">{{ __('el.button_send') }}</button>
</div>
<link rel="stylesheet" href="{{ asset('assets/plugins/ckeditor/css/ckeditor.css') }}">
<script src="{{ asset('assets/plugins/ckeditor/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor.create( document.querySelector('#bodyEditor'));
</script>
