@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <div class="card-tools">
                        <button data-url="{{ route('subject.create') }}" data-target="#subjectModal"
                            class="btn btn-sm btn-info btnOpenModal">{{ __('el.button_add') }}</button>
                    </div>
                </div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
        <x-admin.form-modal id="subjectModal" size="sm" :title="__('user.edit_user')"></x-admin.form-modal>
        <x-admin.delete-modal id="deleteModal" size="sm" :title="__('role.delete_title')"></x-admin.delete-modal>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
