<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Description of the page for better SEO">
    <meta name="keywords" content="Laravel, YourApp, Keywords, SEO">
    <meta name="author" content="Your Name or Company">

    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="/path-to-your-favicon/favicon.ico" type="image/x-icon" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" as="style" />

    <!-- Bootstrap CSS (Version 4.5.2) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Vite - Application Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Background and Header Styles */
        body {
            background: linear-gradient(to right, #ece9e6, #ffffff); /* Soft gradient background */
            animation: fadeIn 1s; /* Animation for the background */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .header-custom {
            background: linear-gradient(to right, #ff6f61, #de5e9a); /* Bright gradient for header */
            color: white; /* Header text color */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Header shadow */
            padding: 20px; /* Internal padding */
            border-radius: 8px; /* Rounded corners for header */
            transition: background-color 0.3s; /* Transition for background color change */
        }

        .header-custom:hover {
            background: linear-gradient(to right, #de5e9a, #ff6f61); /* Reverse gradient on hover */
        }

        .header-custom h1 {
            font-size: 1.5rem; /* Header font size */
            font-weight: bold; /* Bold font weight */
        }

        /* Container adjustments */
        .container {
            padding: 20px; /* Internal padding */
            border-radius: 10px; /* Rounded corners for container */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Container shadow */
            background-color: white; /* White background for container */
            animation: slideIn 0.5s; /* Slide-in animation */
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Button styles */
        .btn-custom {
            background-color: #ff6f61; /* Button background color */
            border-color: #ff6f61; /* Button border color */
            font-size: 1.1rem; /* Button font size */
            padding: 10px 20px; /* Button padding */
            border-radius: 5px; /* Rounded corners for button */
            transition: background-color 0.3s, transform 0.3s; /* Transition for button hover effect */
        }

        .btn-custom:hover {
            background-color: #de5e9a; /* Button hover background color */
            transform: translateY(-2px); /* Slight lift effect on hover */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Shadow on hover */
        }

        /* Form input styles */
        .form-control {
            border: 2px solid #ff6f61; /* Border color for inputs */
            padding: 10px; /* Padding for inputs */
            transition: border-color 0.3s; /* Transition for border color */
        }

        .form-control:focus {
            border-color: #de5e9a; /* Border color on focus */
            box-shadow: none; /* No shadow on focus */
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="header-custom">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts at the end of body for better page load performance -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</body>
</html>
