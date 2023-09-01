@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('setting.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <input type="submit">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-sm-3">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general"
                                        role="tab" aria-controls="general"
                                        aria-selected="true">{{ __('setting.tab_general') }}</a>
                                    <a class="nav-link" id="ticket-tab" data-toggle="pill" href="#ticket" role="tab"
                                        aria-controls="ticket" aria-selected="true">{{ __('setting.tab_ticket') }}</a>
                                    <a class="nav-link" id="file-tab" data-toggle="pill" href="#file" role="tab"
                                        aria-controls="file" aria-selected="true">{{ __('setting.tab_file') }}</a>
                                </div>
                            </div>
                            <div class="col-7 col-sm-9">
                                <div class="tab-content p-2" id="vert-tabs-tabContent">
                                    <div class="tab-pane text-left fade active show" id="general" role="tabpanel"
                                        aria-labelledby="general-tab">
                                        <x-admin.form.text name="site_name" id="inputSiteName" :placeholder="__('setting.app_name')"
                                            :value="$data->site_name"></x-admin.form.text>
                                        <x-admin.form.text name="results_per_page" id="inputResults"
                                            placeholder="Τίτλος Σελίδας" :value="$data->results_per_page"></x-admin.form.text>
                                    </div>
                                    <div class="tab-pane fade" id="ticket" role="tabpanel" aria-labelledby="ticket-tab">
                                    </div>
                                    <div class="tab-pane fade" id="file" role="tabpanel" aria-labelledby="file-tab">
                                        <x-admin.form.text name="accepted_files" id="inputAcceptedFiles"
                                            :placeholder="__('setting.accepted_files')" :value="$data->accepted_files ?? null"></x-admin.form.text>
                                        <x-admin.form.text name="max_filesize" id="inputMaxFilesize"
                                            :placeholder="__('setting.max_filesize')" :value="$data->max_filesize ?? null"></x-admin.form.text>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
