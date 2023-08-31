<div class="dropzone" id="mediaUploader"></div>
@push('scripts')
<script type="module">
    Dropzone.options.mediaUploader = {
        url: "{{ $action }}",
        dictDefaultMessage: '{{ __("el.text_upload") }}',
        dictRemoveFile : 'Διαγραφή',
        paramName: "file",
        autoProcessQueue: true,
        addRemoveLinks: true,
        acceptedFiles: 'image/*, .pdf, .doc, .docx, .xls, .xlsx, .csv, .txt',
        params: {
            _token: "{{ csrf_token() }}"
        },
        accept: function (file, done) {
            const thumbnail = $('.dropzone .dz-preview.dz-file-preview .dz-image:last');

            if(file.type === 'application/pdf') {
                thumbnail.css('background', 'url(/image/admin/pdf.jpg');
            } else if (file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                thumbnail.css('background', 'url(/image/admin/doc.png');
            } else if (file.type === 'application/vnd.ms-excel' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                thumbnail.css('background', 'url(/image/admin/xls.jpg');
            } else if (file.type === 'text/csv') {
                thumbnail.css('background', 'url(/image/admin/csv.jpg');
            }
            done();
        },
        removedfile: function(file) {
            $(`#${file.upload.uuid}`).remove();
            file.previewElement.remove();
        },
        success: function (file, response) {
            $('#{{ $formId }}').append(`<input id="${file.upload.uuid}" type="hidden" name="media[${file.upload.uuid}][src]" value="${response}" ><input type="hidden" name="media[${file.upload.uuid}][type]" value="${file.type}" >`)
        }
    }

</script>
@endpush