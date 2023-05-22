<div class="modal fade" {{ $attributes }}>
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">{{ $title }}</h6>
            </div>
            @if ($type == 'form')    
            <div class="modal-body"></div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
                <button type="button" id="buttonSave" class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
            </div>
            @else
            <div class="modal-body">
                <p class="text-danger">{{ __('el.confirm_delete') }}</p>
                <form action="post" id="deleteForm" action="">
                        @csrf
                        @method('delete')
                </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
                        <input type="submit" value="{{ __('el.button_delete') }}" class="btn btn-sm btn-danger">
                    </div>
            @endif
        </div>
    </div>
</div>