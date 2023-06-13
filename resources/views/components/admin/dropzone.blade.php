<div>
    <form action="{{ $action }}" method="post" name="file" files="true" enctype="multipart/form-data" class="dropzone" id="image-upload">
        @csrf
        <div>
        <h3 class="text-center">Upload Multiple Images</h3>
    </div>    
    </form>
</div>
@push('scripts')
<script type="module">
    Dropzone.options.imageUpload = {
           maxFilesize: 1,
           url: $('#image-upload').attr('action'),
           acceptedFiles: ".jpeg,.jpg,.png,.gif"
       };
</script>
@endpush