@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>

    <!-- Search/Filter Form -->
    <form method="GET" action="{{ route('admin.users.manage') }}" class="mb-4">
        <div class="form-row">
            <div class="col">
                <select name="enable" class="form-control">
                    <option value="">Select Enable</option>
                    <option value="1" {{ request('enable') == '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ request('enable') == '0' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="col">
                <input type="text" name="user_type" class="form-control" placeholder="User Type" value="{{ request('user_type') }}">
            </div>
            <div class="col">
                <input type="text" name="main_user" class="form-control" placeholder="Main User" value="{{ request('main_user') }}">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <!-- Users Table -->
    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>User Type</th>
                <th>Main User</th>
                <th>Enable</th>
                <th>Created At</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->n_telephone }}</td>
                <td>{{ $user->user_type }}</td>
                <td>
                    <!-- Main User Dropdown -->
                    <form method="POST" action="{{ route('admin.users.updateMainUser', ['id' => $user->user_id]) }}">
                        @csrf
                        @method('PATCH')
                        <select name="main_user" class="form-control" onchange="this.form.submit()">
                            <option value="">Select Main User</option>
                            @foreach($mainUsers as $mainUser)
                                <option value="{{ $mainUser->user_id }}" {{ $user->main_user == $mainUser->user_id ? 'selected' : '' }}>
                                    {{ $mainUser->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td>
                    <!-- Enable Field Form -->
                    <form method="POST" action="{{ route('admin.users.update', ['id' => $user->user_id]) }}">
                        @csrf
                        @method('PATCH')
                        <select name="enable" class="form-control" onchange="this.form.submit()">
                            <option value="1" {{ $user->enable == 1 ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $user->enable == 0 ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </form>
                </td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <!-- Additional actions (if any) -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $users->links() }}
</div>
@endsection
