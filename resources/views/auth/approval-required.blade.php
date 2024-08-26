@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Approval Required') }}</div>

                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        {{ __('Your account has been created successfully. Please wait for the admin to approve your account before you can log in.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
