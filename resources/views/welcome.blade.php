<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- FontAwesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Custom Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

      <style>
        /* General Styles */
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa; /* Light grey background for content contrast */
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-green {
            background-color: #28a745; /* Keep the original green */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Slight shadow for elevation */
        }

        .navbar-green .navbar-brand,
        .navbar-green .nav-link {
            color: #fff;
            font-weight: 600;
        }

        .navbar-green .nav-link:hover {
            color: #e8f5e9; /* Lighter green for hover */
            transition: color 0.3s ease; /* Smooth transition */
        }

        /* Main Hero Section */
        .main-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 40px 20px; /* Larger margin for better spacing */
            background: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
            border-radius: 12px; /* Smooth rounded corners */
            padding: 20px; /* Add padding inside the section */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }

        .text-content h1 {
            color: #ffcc00; /* Bright yellow for eye-catching heading */
            font-size: 3rem; /* Large heading */
            text-transform: uppercase;
        }

        .text-content p {
            color: #ffffff;
            line-height: 1.8;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 12px; /* Rounded image */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Image shadow */
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 40px 0; /* Increased padding for more space */
            text-align: center;
            font-size: 0.9rem;
            margin-top: auto; /* Ensure footer is at the bottom */
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1;
            margin: 0 20px;
        }

        .footer-section h2,
        .footer-section h3 {
            margin-top: 0;
            font-weight: bold;
            color: #ffcc00;
        }

        .footer-section a {
            color: #fff;
            text-decoration: none;
        }

        .footer-section a:hover {
            text-decoration: underline;
            color: #ffcc00;
            transition: color 0.3s ease;
        }

        .footer-bottom p {
            margin: 20px 0 0;
            font-size: 0.8rem;
            color: #ddd;
        }

        /* Buttons */
        .nav-link.btn {
            border-radius: 50px;
            padding: 10px 25px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link.btn:hover {
            background-color: #fff;
            color: #28a745;
        }

        /* Footer Links */
        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                text-align: center;
            }

            .image-container img {
                width: 80%; /* Smaller width for smaller screens */
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-section {
                margin-bottom: 20px;
            }
        }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    
        <!-- Navbar -->
        <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
            <nav class="navbar navbar-expand-lg navbar-green navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="http://127.0.0.1:8000/image/LOGO.PNG" alt="Logo" style="max-height: 45px;">
                    </a>
                    <a class="navbar-brand" href="#">RevoFeed</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            @if (Route::has('login'))
                                @auth
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-outline-light" href="{{ url('/dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard
                                        </a>
                                    </li>
                                @else
                                    <!-- Superuser Login and Register -->
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-outline-warning" href="{{ route('login') }}">
                                            <i class="fas fa-user"></i> Superuser Login
                                        </a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-outline-warning" href="{{ route('register') }}">
                                                <i class="fas fa-user-plus"></i> Superuser Register
                                            </a>
                                        </li>
                                    @endif
                                    <!-- Admin Login -->
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-outline-warning" href="{{ route('admin.login') }}">
                                            <i class="fas fa-user-shield"></i> Admin Login
                                        </a>
                                    </li>
                                @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            <div class="main-container">
                <div class="text-content">
                    <h1><strong>Welcome to RevoFeed</strong></h1>
                    <p>At RevoFeed, we are pioneers in biotechnological innovation, dedicated to revolutionizing sustainable agriculture and animal nutrition. Established in 2019, our mission is to provide high-quality, eco-friendly solutions through insect-based protein and biofertilizers. With a commitment to reducing food waste and enhancing global food security, we operate locally and globally, striving to make a positive impact on agriculture, animal feed, and waste recycling. Join us in shaping a more sustainable future.</p>
                </div>
                <div class="image-container">
                    <img src="{{ asset('image/b.webp') }}" alt="RevoFeed Image 2">
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-5">
            <div class="footer-content">
                <div class="footer-section about">
                    <h2 class="color">RevoFeed</h2>
                    <p>RevoFeed is a pioneering Moroccan biotechnology company established in 2019.</p>
                </div>
                <div class="footer-section links">
                    <h3 class="color">Quick Links</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Solutions</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section contact">
                    <h3>Contact Us</h3>
                    <p>Email: contact@revofeed.com</p>
                    <p>Phone: (123) 456-7890</p>
                </div>
                <div class="footer-section social-media">
                    <h3 class="color">Follow Us</h3>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i> Instagram</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 RevoFeed. All rights reserved.</p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
