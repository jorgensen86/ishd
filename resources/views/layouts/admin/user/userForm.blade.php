<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="userForm" autocomplete="false">
        @csrf
        <x-admin.form.text inputName="name" labelFor="inputName" placeholder="{{ __('admin/user/user.fullname') }}" :value="$data->name"></x-admin.form.text>
        <x-admin.form.text inputName="email" labelFor="inputEmail" placeholder="{{ __('admin/user/user.email') }}" :value="$data->email"></x-admin.form.text>
        <x-admin.form.text inputName="username" labelFor="inputUsername" placeholder="{{ __('admin/user/user.username') }}" :value="$data->email"></x-admin.form.text>
        <x-admin.form.text inputName="password" labelFor="inputPassword" placeholder="{{ __('admin/user/user.password') }}" value=""></x-admin.form.text>
        <x-admin.form.select label="{{ __('admin/user/user.role') }}" :selected="$data->roles->count() ? $data->roles->first()->id : 0" inputName="role" :options="$roles"></x-admin.form.select>
        <x-admin.form.checkbox :active="$data->active"></x-admin.form.checkbox>
        {{-- <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}"
                placeholder="{{ __('user.username') }}">
        </div>
                <div class="form-group">
            <select class="form-control" name="role">
                <option value="">{{  __('admin/user/user.role') }}</option>
                @foreach ($roles as $role)
                <option {{ $data->hasRole($role->name) ? 'selected' : null }} value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="text" name="password" class="form-control" value=""
                placeholder="{{ __('user.password') }}">
        </div>
        
        <div class="custom-control custom-switch mb-3">
            <input type="checkbox" class="custom-control-input" id="inputActive" name="active" value="1"
                {{ $user->active ? 'checked' : null }}>
            <label class="custom-control-label" for="inputActive">{{ __('el.enable') }}</label>
        </div> --}}
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#userForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>