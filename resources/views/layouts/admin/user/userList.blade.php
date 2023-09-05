@extends('admin')

@section('content')
    <x-admin.page-header :heading="__('sidebar.user_list')"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <x-modal.open-button :url="route('user.create')" target="#userModal"></x-modal.open-button>
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    {{ $dataTable->table() }}
                </div>
            </div>

        </div>
        <x-modal.open id="userModal" size="xl"></x-modal.open>
        <x-modal.delete size="sm"></x-modal.delete>
    </section>
@endsection

@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
