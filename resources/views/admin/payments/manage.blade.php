@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Payments</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Invoice Date</th>
                <th>Module GWT ID</th>
                <th>Pay State</th>
                <th>Payment Date</th>
                <th>Commentaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->invoice_date }}</td>
                    <td>{{ $payment->module_gwt_id }}</td>
                    <td>
                        <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                            @csrf
                            <input type="text" name="pay_state" value="{{ $payment->pay_state }}">
                    </td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>
                        <textarea name="commentaire">{{ $payment->commentaire }}</textarea>
                    </td>
                    <td>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Create New Payment</h2>
    <form action="{{ route('admin.payments.create') }}" method="POST">
        @csrf
        <!-- Add input fields for all payment attributes -->
        <div class="form-group">
            <label for="invoice_date">Invoice Date</label>
            <input type="datetime-local" name="invoice_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="module_gwt_id">Module GWT ID</label>
            <input type="text" name="module_gwt_id" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pay_state">Pay State</label>
            <input type="text" name="pay_state" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="payment_date">Payment Date</label>
            <input type="datetime-local" name="payment_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="payment_type">Payment Type</label>
            <input type="text" name="payment_type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="card_type">Card Type</label>
            <input type="text" name="card_type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="no_pay_mounth">No Pay Month</label>
            <input type="text" name="no_pay_mounth" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="delay">Delay</label>
            <input type="text" name="delay" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" name="year" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Create Payment</button>
    </form>
</div>
@endsection
