@extends('admin')

@section('content')
    <x-admin.page-header :heading="__('sidebar.user_list')"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <button data-url="{{ route('user.create') }}" data-target="#userModal"
                            class="btn btn-sm btn-info btnOpenModal">{{ __('el.button_add') }}</button>
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    {{ $dataTable->table() }}
                </div>
            </div>

        </div>
        <x-admin.form-modal id="userModal" size="md" :title="__('user.edit_user')"></x-admin.form-modal>
        <x-admin.delete-modal id="deleteModal" size="sm" :title="__('user.delete')"></x-admin.delete-modal>
    </section>
@endsection

@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
