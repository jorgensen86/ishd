@extends('admin')

@section('content')
<x-admin.page-header :heading="$title"></x-admin.page-header>
<section class="content">
<div class="container-fluid">
    <div class="card card-outline card-info">
        <div class="card-header">
            <input type="checkbox" name="is_closed" id="test" value="1">
                <div class="float-right dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Dropdown button
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <form action="" class="p-2">
                            <div class="form-group">
                                <input type="text" class="form-control">
                            </div>
                            <select name="" id="">
                                <option value=""></option>
                            </select>
                        </form>
                    </div>
                  </div>

        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>
</section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="module">
        $("#test").on('change', function(){
            $('table').DataTable().draw();
    });
    </script>
@endpush