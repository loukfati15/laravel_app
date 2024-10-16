@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Section des options admin -->
            <section class="card shadow-sm border-0 mb-5">
                <header class="card-header bg-dark text-white">
                    <h5 class="mb-0">Admin Options</h5>
                </header>
                <div class="card-body">
                    <a href="{{ route('admin.users.manage') }}" class="btn btn-outline-primary me-3">Manage Users</a>
                    <a href="{{ route('admin.payments.manage') }}" class="btn btn-outline-primary me-3">Manage Payments</a>
                    <a href="{{ route('admin.createAdmin') }}" class="btn btn-outline-primary">Add New Admin</a>
                </div>
            </section>

            <!-- Section des superusers en attente -->
            <section class="card shadow-sm border-0">
                <header class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Pending Superuser Approvals') }}</h5>
                </header>
                <div class="card-body p-4">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Region Numbers</th>
                                <th>Poste</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($superusers as $superuser)
                                <tr>
                                    <td>{{ $superuser->name }}</td>
                                    <td>{{ $superuser->email }}</td>
                                    <td>{{ $superuser->N_telephone }}</td>
                                    <td>
                                        @foreach($superuser->regions as $region)
                                            {{ $region->region_name }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $superuser->poste }}</td>
                                    <td>
                                        <!-- Actions buttons -->
                                        <form method="POST" action="{{ route('admin.approve', $superuser->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm mb-2">Approve</button>
                                        </form>

                                        <a href="{{ route('admin.editRegions', $superuser->id) }}" class="btn btn-warning btn-sm mb-2">Edit Regions</a>

                                        <form method="POST" action="{{ route('admin.destroy', $superuser->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this superuser?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
