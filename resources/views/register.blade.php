<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            color: white;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Background video styling */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1; /* Pindahkan ke belakang konten */
        }

        .register-container {
            background-color: rgba(44, 62, 80, 0.9); /* Transparansi untuk menonjolkan konten */
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            text-align: center;
            z-index: 1; /* Pastikan kontainer di atas video */
        }

        .register-container h2 {
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

        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <video class="video-background" autoplay muted loop>
        <source src="{{ asset('videos/ronaldo.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="register-container">
        <!-- Form Title -->
        <h2>Register</h2>

        <!-- Register Form -->
        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

        <!-- Login Link -->
        <p class="footer-text">
            Already have an account? <a href="{{ url('/login') }}" class="text-link">Login</a>
        </p>
    </div>
</body>
</html>
