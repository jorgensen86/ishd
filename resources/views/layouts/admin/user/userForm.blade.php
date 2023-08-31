<div class="modal-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">{{ $title }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">{{ $title }}</button>
        </li>
    </ul>
    <form action="{{ $action }}" method="{{ $method }}" id="userForm" autocomplete="false">
        @csrf
        <div class="tab-content p-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <x-form.text name="name" id="inputName" placeholder="{{ __('admin/user/user.fullname') }}"
                    :value="$data->name"></x-form.text>
                <x-form.text name="email" id="inputEmail" placeholder="{{ __('admin/user/user.email') }}"
                    :value="$data->email"></x-form.text>
                <x-form.text name="username" id="inputUsername" placeholder="{{ __('admin/user/user.username') }}"
                    :value="$data->username"></x-form.text>
                <x-form.text name="password" id="inputPassword" placeholder="{{ __('admin/user/user.password') }}"
                    value=""></x-form.text>
                <x-form.select label="{{ __('admin/user/user.role') }}" :selected="$data->roles->count() ? $data->roles->first()->id : 0" name="role"
                    :options="$roles"></x-form.select>
                <x-form.checkbox :active="$data->active"></x-form.checkbox>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="permissions[]" type="checkbox"
                                    id="{{ $permission->id }}" value="{{ $permission->name }}" {{ $data->hasPermissionTo($permission->name) ? 'checked' : null }}>
                                <label for="{{ $permission->id }}"
                                    class="custom-control-label">{{ $permission->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#userForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
