<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="userForm" autocomplete="false">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-person"></i></span>
            </div>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                placeholder="{{ __('user.fullname') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                placeholder="{{ __('user.email') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}"
                placeholder="{{ __('user.username') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="text" name="password" class="form-control" value=""
                placeholder="{{ __('user.password') }}">
        </div>
        <div class="form-group">
            <select class="form-control" name="role">
                <option value="">Επιλέξτε Ρόλο</option>
                @foreach ($roles as $role)
                <option {{ $user->hasRole($role->name) ? 'selected' : null }} value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="custom-control custom-switch mb-3">
            <input type="checkbox" class="custom-control-input" id="inputActive" name="active" value="1"
                {{ $user->active ? 'checked' : null }}>
            <label class="custom-control-label" for="inputActive">{{ __('el.enable') }}</label>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#userForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>