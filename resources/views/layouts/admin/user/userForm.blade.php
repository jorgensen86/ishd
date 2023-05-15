<form action="{{ $action }}" method="{{ $method }}">
    @csrf
    <div class="form-group mb-3 text-right">
        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
            <input type="checkbox" name="active" class="custom-control-input" id="input-active" value="1" {{ $user->active ? 'checked' : null }}>
            <label class="custom-control-label" for="input-active"></label>
        </div>
        <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>
<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-person"></i></span>
        </div>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" placeholder="{{ __('user.fullname') }}">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" placeholder="{{ __('user.email') }}">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
        </div>
        <input type="text" name="username" class="form-control" value="{{ $user->username }}" placeholder="{{ __('user.username') }}">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
        </div>
        <input type="text" name="password" class="form-control" value="" placeholder="{{ __('user.password') }}">
    </div>
</form>