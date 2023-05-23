<div class="modal fade" {{ $attributes }}>
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">{{ $title }}</h6>
            </div>
            <div class="modal-body">
                <p class="text-danger">{{ __('el.confirm_delete') }}</p>
                <form action="post" id="deleteForm" action="">
                    @csrf
                    @method('delete')
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default"
                    data-dismiss="modal">{{ __('el.button_cancel') }}</button>
                <button type="submit" class="btn btn-sm btn-danger"
                    form="deleteForm">{{ __('el.button_delete') }}</button>
            </div>
        </div>
    </div>
</div>
