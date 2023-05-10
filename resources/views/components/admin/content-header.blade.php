<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $headingTitle }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach ($breadcrumbs as $breadcrumb)      
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['href'] }}">{{ $breadcrumb['name'] }}</a></li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>