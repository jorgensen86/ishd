<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="roleForm" autocomplete="false">
        @csrf
        <x-admin.form.select label="{{ __('admin/email/imap.queue') }}" inputName="queue_id" :options="$queues" :selected="$data->queue_id"></x-admin.form.select>
        <x-admin.form.text inputName="host" labelFor="input-host" placeholder="{{ __('admin/email/imap.host') }}" :value="$data->host"></x-admin.form.text>
        <x-admin.form.text inputName="username" labelFor="input-username" placeholder="{{ __('admin/email/imap.username') }}" :value="$data->username"></x-admin.form.text>
        <x-admin.form.text inputName="password" labelFor="input-password" placeholder="{{ __('admin/email/imap.password') }}" value=""></x-admin.form.text>
        <x-admin.form.text inputName="port" labelFor="input-port" placeholder="{{ __('admin/email/imap.port') }}" :value="$data->port"></x-admin.form.text>
        <div class="form-group">
            <label>{{  __('admin/email/imap.encryption') }}</label>
            <select name="encryption" class="form-control">
                <option value="">{{ __('el.text_no') }}</option>
                <option {{ $data->encryption === 'ssl' ? 'selected' : null }} value="ssl">Ssl</option>
                <option {{ $data->encryption === 'tls' ? 'selected' : null }} value="tls">Tls</option>
                <option {{ $data->encryption === 'starttls' ? 'selected' : null }} value="starttls">Starttls</option>
                <option {{ $data->encryption === 'notls' ? 'selected' : null }} value="notls">Notls</option>
            </select>
        </div>
        <div class="form-group">
            <label>{{  __('admin/email/imap.cert') }}</label>
            <select name="validate_cert" class="form-control">
                <option  {{ $data->validate_cert === 0 ? 'selected' : null }} value="0">{{ __('el.text_no') }}</option>
                <option  {{ $data->validate_cert === 1 ? 'selected' : null }} value="1">{{ __('el.text_yes') }}</option>
            </select>
        </div>
        <x-admin.form.checkbox :active="$data->active"></x-admin.form.checkbox>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#roleForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
