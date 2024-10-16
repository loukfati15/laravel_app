@extends('layouts.app')

@section('content')
<div class="container">
    

    <h1>Pending User Approvals</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($superusers as $superuser)
            <tr>
                <td>{{ $superuser->name }}</td>
                <td>{{ $superuser->email }}</td>
                <td>
                    <form action="{{ url('/admin/approve/' . $superuser->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Approve</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
