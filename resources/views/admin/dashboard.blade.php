@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>
                <a href="{{ route('admin.createAdmin') }}" class="btn btn-primary">Add New Admin</a>

                <div class="card-body">
                    <h5>Pending Superuser Approvals</h5>
                    <table class="table">
                        <thead>
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
                                        <form method="POST" action="{{ route('admin.approve', $superuser->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </form>
                                        <a href="{{ route('admin.editRegions', $superuser->id) }}" class="btn btn-warning">Edit Regions</a>
                                        <form method="POST" action="{{ route('admin.destroy', $superuser->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this superuser?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
