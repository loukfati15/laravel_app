@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.users.index') }}">
        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" name="user_id" class="form-control" placeholder="Search by User ID" value="{{ request('user_id') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="main_user" class="form-control" placeholder="Search by Main User ID" value="{{ request('main_user') }}">
            </div>
            <div class="col-md-3">
                <select name="enable" class="form-control">
                    <option value="">-- Search by Enable Status --</option>
                    <option value="1" {{ request('enable') == '1' ? 'selected' : '' }}>Enabled (1)</option>
                    <option value="0" {{ request('enable') == '0' ? 'selected' : '' }}>Disabled (0)</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <!-- User Table -->
    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Enable</th>
                <th>Main User</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <!-- Enable Dropdown -->
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        <select name="enable" class="form-control" onchange="this.form.submit()">
                            <option value="1" {{ $user->enable == '1' ? 'selected' : '' }}>Enabled (1)</option>
                            <option value="0" {{ $user->enable == '0' ? 'selected' : '' }}>Disabled (0)</option>
                        </select>
                    </form>
                </td>
                <td>{{ $user->main_user }}</td>
                <td>
                    <!-- Any additional actions can go here -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $users->links() }}
</div>
@endsection
