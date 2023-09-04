<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <div class="card card-default collapsed-card">
        <div class="card-header">
            <h3 class="card-title">{{ $text_add }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ $action}}" method="post" id="notificationForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name='model_id' value="{{ $model_id }}">
                <input type="hidden" name='relation' value="{{ $relation }}">
                <input type="hidden" name="author_id" value="{{ auth()->user()->user_id }}">
                <textarea name="body" rows="5" class="form-control" placeholder="{{ __('el.button_cancel') }}"></textarea>
            </form>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-sm btn-default float-left" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
            <button type="button" id="btnSave" data-form="#notificationForm" class="btn btn-sm btn-success float-right">{{ __('el.button_save') }}</button>
        </div>
    </div>
    <div class="notifications">
        @foreach ($notifications as $notification)
        <div class="card">
            <div class="card-header">
                <div class="user-block">
                    <span class="username text-success">{{ $notification->user->name }}</span>
                    <span class="description">{{ $notification->created_at }}
                        ({{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i:s') }})
                    </span>
                </div>
            </div>
            <div class="card-body">{!! nl2br(e($notification->body)) !!}</div>
        </div>
        @endforeach
    </div>
</div>
