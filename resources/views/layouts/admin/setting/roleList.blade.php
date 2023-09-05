@extends('admin')

@section('content')
<x-admin.page-header :heading="$title"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <x-modal.open-button :url="route('role.create')" target="#roleModal"></x-modal.open-button>
                </div>
            </div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>

    </div>
    <x-modal.open id="roleModal" size="md"></x-modal.open>
    <x-modal.delete size="sm"></x-modal.delete>
</section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush