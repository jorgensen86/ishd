@extends('admin')

@section('content')
<x-admin.page-header :heading="$title"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ route('permission.create') }}" data-target="#permissionModal"
                        class="btn btn-sm btn-default btnOpenModal">{{ __('el.button_add') }} <i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>

    </div>
    <x-modal.open id="permissionModal" size="md"></x-modal.open>
    <x-modal.delete size="sm"></x-modal.delete>
</section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush