<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="userForm" autocomplete="false">
        @csrf
        <x-form.text name="name" id="inputName" placeholder="{{ __('admin/user/user.fullname') }}" :value="$data->name"></x-form.text>
        <x-form.text name="email" id="inputEmail" placeholder="{{ __('admin/user/user.email') }}" :value="$data->email"></x-form.text>
        <x-form.text name="username" id="inputUsername" placeholder="{{ __('admin/user/user.username') }}" :value="$data->email"></x-form.text>
        <x-form.text name="password" id="inputPassword" placeholder="{{ __('admin/user/user.password') }}" value=""></x-form.text>
        <x-form.select label="{{ __('admin/user/user.role') }}" :selected="$data->roles->count() ? $data->roles->first()->id : 0" name="role" :options="$roles"></x-form.select>
        <x-form.checkbox :active="$data->active"></x-form.checkbox>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#userForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>