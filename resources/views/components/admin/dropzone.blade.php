<div class="dropzone" id="mediaUploader"></div>

@push('scripts')
<script type="module">
    Dropzone.options.mediaUploader = {
        url: "{{ $action }}",
        // dictDefaultMessage : '',
        paramName: "file",
        autoProcessQueue: true,
        addRemoveLinks: true,
        params: {
            _token: "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $('#{{ $formId }}').append(`<input type="hidden" name="media[]" value="${response}" >`)
        }
    }

</script>
@endpush