<div class="modal-header bg-light">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="true">{{ __('user.tab_profile') }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="permission-tab" data-toggle="tab" data-target="#permission" type="button"
                role="tab" aria-controls="permission" aria-selected="false">{{ __('user.tab_permission') }}</button>
        </li>
    </ul>
    <form action="{{ $action }}" method="{{ $method }}" id="userForm" autocomplete="false">
        @csrf
        <div class="tab-content p-2" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <x-form.text name="name" id="inputName" placeholder="{{ __('user.fullname') }}"
                    :value="$data->name"></x-form.text>
                <x-form.text name="email" id="inputEmail" placeholder="{{ __('user.email') }}"
                    :value="$data->email"></x-form.text>
                <x-form.text name="username" id="inputUsername" placeholder="{{ __('user.username') }}"
                    :value="$data->username"></x-form.text>
                <x-form.text name="password" id="inputPassword" placeholder="{{ __('user.password') }}"
                    value=""></x-form.text>
                <x-form.select label="{{ __('user.role') }}" :selected="$data->roles->count() ? $data->roles->first()->id : 0" name="role"
                    :options="$roles"></x-form.select>
                <x-form.checkbox :active="$data->active" label="{{ __('user.status') }}"></x-form.checkbox>
            </div>
            <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-control custom-checkbox float-right">
                            <input class="custom-control-input" type="checkbox" id="enable_all"
                                onclick="$('input[name*=\'permissions\']').prop('checked', this.checked);"
                                {{ $permissions->count() === $data->permissions->count() ? 'checked' : null }}>
                            <label for="enable_all" class="custom-control-label">{{ __('el.text_all') }}</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="permissions[]" type="checkbox"
                                    id="{{ $permission->id }}" value="{{ $permission->name }}"
                                    {{ $data->hasPermissionTo($permission->name) ? 'checked' : null }}>
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
    <x-modal.close-button></x-modal.close-button>
    <button type="button" id="btnSave" data-form="#userForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
