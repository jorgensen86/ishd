@extends('admin')

@section('content')
<x-admin.content-header :headingTitle="$heading_title" :breadcrumbs="[]"></x-admin.content-header>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        {{-- <th>Status</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                           
                                        <tr>
                                            <td>{{ $user->user_id }}</td>
                                            <td>{{ $user->clientInfo->invoice }}</td>
                                           
                                            <td><span class="tag tag-success">Approved</span></td>
                                            {{-- <td>
                                                <a href="{{ route('user.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection