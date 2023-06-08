@extends('admin')

@section('content')
<x-admin.page-header :heading="$title"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <form action="{{ route('ticket.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label></label>
                                <input type="text" placeholder="fdsfds" name="test" id="test" class="form-control form-control-border">
                            </div>
                            <div class="form-group">
                                <label>dsadsa</label>
                                <x-admin.ckeditor :id="'bodyEditor'" :name="'body'"></x-admin.ckeditor>
                            </div>
                            <div class="pull-right">
                                <input type="submit" value="send">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form action="" method="post" name="file" files="true" enctype="multipart/form-data" class="dropzone" id="image-upload">
                    @csrf
                    <div>
                    <h3 class="text-center">Upload Multiple Images</h3>
                </div>    
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')



<script  type="module">
     Dropzone.options.imageUpload = {
            maxFilesize: 1,
            url: "http://dasdada.gr",
            acceptedFiles: ".jpeg,.jpg,.png,.gif"
        };
</script>
@endpush