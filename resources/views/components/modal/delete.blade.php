<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
			    <i class="far fa-circle-xmark text-danger"></i>						
			</div>
            <div class="modal-body">
                <form action="post" id="deleteForm" action="">
                    @csrf
                    @method('delete')
                    <p class="text-center">{{ __('el.confirm_delete_text') }}</p>
                </form>
            </div>
            <div class="modal-footer justify-content-around">
                <button type="button" class="btn btn-sm btn-outline-danger px-3"
                    data-dismiss="modal"><i class="far fa-xmark"></i> {{ __('el.text_no') }}</button>
                <button type="submit" class="btn btn-sm btn-outline-success px-3"
                    form="deleteForm"><i class="far fa-check"></i> {{ __('el.text_yes') }}</button>
            </div>
        </div>
    </div>
</div>