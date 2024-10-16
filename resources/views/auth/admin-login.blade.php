@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>
                        <i class="fas fa-user-shield"></i> {{ __('Admin Login') }}
                    </h4>
                </div>

                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email">
                                <i class="fas fa-envelope"></i> {{ __('E-Mail Address') }}
                            </label>
                            <div class="input-group">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">
                                <i class="fas fa-lock"></i> {{ __('Password') }}
                            </label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">{{ __('Login') }}</button>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-3 text-center">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
