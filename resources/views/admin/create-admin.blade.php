@extends('layouts.app')

@section('content')
<style>
    /* Améliorer les boutons */
    .btn-success {
        background-color: #1e7e34;
        border-color: #1e7e34;
        font-size: 1.1rem;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #28a745;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* Améliorer les champs de texte */
    .form-control {
        border: 2px solid #28a745;
        padding: 10px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #1e7e34;
        box-shadow: none;
    }

    /* Centrer le texte et icône de l'en-tête */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Effet ombré sur la carte */
    .card {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #28a745;
    }

    /* Améliorer l'espacement des champs */
    .form-group {
        margin-bottom: 2rem;
    }

    /* Illustration de meilleure qualité */
    .card-header i {
        font-size: 1.5rem;
        margin-left: auto;
    }
</style>
<div class="container" style="background-color: #f0f4f7; padding: 20px; border-radius: 10px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border-color: #218838; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <div class="card-header d-flex align-items-center" style="background-color: #218838; color: white; font-weight: bold;">
                    <i class="fas fa-user-shield mr-2" style="font-size: 1.2rem;"></i>
                    {{ __('Add New Admin') }}
                    <!-- Utilisation d'une icône FontAwesome au lieu d'une image -->
                    <i class="fas fa-user-tie ml-auto" style="font-size: 1.5rem;"></i>
                </div>

                <div class="card-body" style="padding: 30px;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.storeAdmin') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold" style="color: #218838;">
                                <i class="fas fa-user"></i> {{ __('Name') }}
                            </label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                                style="border-color: #218838;">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="font-weight-bold" style="color: #218838;">
                                <i class="fas fa-envelope"></i> {{ __('Email Address') }}
                            </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" 
                                style="border-color: #218838;">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="font-weight-bold" style="color: #218838;">
                                <i class="fas fa-lock"></i> {{ __('Password') }}
                            </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password" style="border-color: #218838;">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password-confirm" class="font-weight-bold" style="color: #218838;">
                                <i class="fas fa-lock"></i> {{ __('Confirm Password') }}
                            </label>
                            <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required autocomplete="new-password" 
                                style="border-color: #218838;">
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-success btn-block" 
                                style="background-color: #218838; border-color: #218838; padding: 10px 20px; font-size: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <i class="fas fa-user-plus"></i> {{ __('Add Admin') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
