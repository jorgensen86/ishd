<div class="modal fade" {{ $attributes }}>
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            @if ($type == 'form')    
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
                <button type="button" id="buttonSave" class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
            </div>
            @else
                <div class="modal-header">
                    <h4 class="modal-title">{{ $title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">ddd</div>
            @endif
        </div>
    </div>
</div>