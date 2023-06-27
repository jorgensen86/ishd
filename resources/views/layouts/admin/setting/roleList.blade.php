@extends('admin')

@section('content')
<x-admin.page-header :heading="$title"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ route('role.create') }}" data-target="#roleModal"
                        class="btn btn-sm btn-info btnOpenModal">{{ __('el.button_add') }}</button>
                </div>
            </div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>

    </div>
    <x-admin.form-modal id="roleModal" size="sm" :title="__('client.edit_title')"></x-admin.form-modal>
    <x-admin.delete-modal id="deleteModal" size="sm" :title="__('role.delete_title')"></x-admin.delete-modal>
</section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush