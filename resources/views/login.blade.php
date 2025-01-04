<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            color: white;
        }

        /* Background video styling */
        video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1; /* Puts the video behind other elements */
        }

        .login-container {
            background-color: rgba(44, 62, 80, 0.8); /* Semi-transparent background */
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .login-container img {
            width: 300px;
            height: auto;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 3px solid #3498db;
            padding: 5px;
            transition: transform 0.3s ease;
        }

        .login-container img:hover {
            transform: scale(1.1);
        }

        .login-container h2 {
            color: #3498db;
            margin-bottom: 20px;
            font-size: 30px;
            font-weight: 600;
        }

        .form-control {
            background-color: #1c1c1c;
            color: white;
            border: none;
        }

        .form-control:focus {
            background-color: #21262d;
            border-color: #3498db;
            color: white;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            font-weight: 600;
            font-size: 16px;
            padding: 10px 0;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #217dbb;
            transform: translateY(-2px);
        }

        .text-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <!-- Background Video -->
    <video autoplay muted loop>
        <source src="{{ asset('videos/messi.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="login-container">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo">

        <!-- Form Title -->
        <h2>Login</h2>

        <!-- Login Form -->
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <!-- Error Message -->
        <p class="text-center mt-3">
            <small style="color: #e74c3c;">{{ session('error') }}</small>
        </p>

        <!-- Register Link -->
        <p class="footer-text">
            Don't have an account? <a href="{{ url('/register') }}" class="text-link">Register</a>
        </p>
    </div>
</body>
</html>
