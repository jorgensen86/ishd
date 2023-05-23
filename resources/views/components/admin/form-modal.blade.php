<div class="modal fade" {{ $attributes }}>
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">{{ $title }}</h6>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
                <button type="button" id="buttonSave" class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
            </div>
        </div>
    </div>
</div>