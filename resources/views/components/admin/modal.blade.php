<div class="modal fade" {{ $attributes }}>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
                <button type="button" id="buttonSave" class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
            </div>
        </div>
    </div>
</div>