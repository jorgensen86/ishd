@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Read Mail</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mailbox-read-info">
                        <h5>{{ $data->subject }}</h5>
                        <h6>From: {{ $data->sender }}
                            <span class="mailbox-read-time float-right">{{ $data->sent_at }}</span>
                        </h6>
                    </div>
                    <div class="mailbox-read-message">
                        {!! $data->body !!}
                    </div>

                </div>

                <div class="card-footer bg-white">
                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                        <li>
                            <span class="mailbox-attachment-icon"><i class="far fa-file"></i></span>
                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>
                                    Sep2014-report.pdf</a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                                    <span>1,245 KB</span>
                                    <a href="#" class="btn btn-default btn-sm float-right"><i
                                            class="fas fa-cloud-download-alt"></i></a>
                                </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>
                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> App
                                    Description.docx</a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                                    <span>1,245 KB</span>
                                    <a href="#" class="btn btn-default btn-sm float-right"><i
                                            class="fas fa-cloud-download-alt"></i></a>
                                </span>
                            </div>
                        </li>
                        @foreach ($data->getMedia() as $media)
                            @if (Str::of($media->mime_type)->startsWith('image/'))
                                <li>
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ $media->getFullUrl() }}"
                                            alt="{{ $media->file_name }}"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i>
                                            {{ $media->file_name }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($media->size / 1048576, 2) }} MB</span>
                                            <a href="#" class="btn btn-default btn-sm float-right"><i
                                                    class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="card-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                        <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
                    </div>
                    <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                    <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </div>

            </div>
        </div>
        <x-admin.form-modal id="notificationModal" size="lg" :title="__('client.edit_title')"></x-admin.form-modal>
    </section>
@endsection
