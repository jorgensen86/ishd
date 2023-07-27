<div class="form-group">
    <label>{{ $label }}</label>
    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control"></textarea>
</div>
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/ckeditor/css/ckeditor.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/plugins/ckeditor/js/ckeditor.js') }}"></script>
    <script>
        ClassicEditor.create( document.querySelector('#{{ $id }}'));
    </script>
@endpush