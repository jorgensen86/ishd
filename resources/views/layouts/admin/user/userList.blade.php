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
                    {{ $table->table() }}
                </div>
            </div>

        </div>
        <x-admin.form-modal id="userModal" size="md" :title="__('user.edit_user')"></x-admin.form-modal>
        <x-admin.delete-modal id="deleteModal" size="sm" :title="__('user.delete')"></x-admin.delete-modal>
    </section>
@endsection

@push('scripts')
<script type="module">    
    $(function () {
        var table = $('#dataTableBuilder').DataTable(
            $.extend(
                $.DTABLE_CONFIG,
                {   
                    pageLength:"{{ $results_per_page }}",
                    order: [[0, 'desc']],
                    ajax: "{{ route('user.index') }}",
                    columns: [
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'username' },
                        { data: 'active', className: 'text-center', orderable: false, searchable: false},
                        { data: 'action', className: 'text-right', orderable: false, searchable: false},

                    ]
                }
            )
        );
    });
</script>
@endpush
