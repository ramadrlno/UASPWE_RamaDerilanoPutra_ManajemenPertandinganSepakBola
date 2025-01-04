<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Edit Pemain</title>
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            background: linear-gradient(135deg, #0d1117, #161b22); /* Gradient */
            color: white;
            width: 250px;
            height: 100vh;
            position: fixed;
            padding-top: 30px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
        }

        .sidebar img {
            width: 160px;
            height: auto;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .sidebar img:hover {
            transform: scale(1.1);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .sidebar ul li {
            margin: 10px 0;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar ul li:hover {
            background: #21262d;
            border-radius: 8px;
        }

        .sidebar ul li a,
        .logout-btn {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar ul li i {
            margin-right: 10px;
            font-size: 20px;
        }

        .logout-btn {
            background-color: #ff4d4d; /* Red background for logout */
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            width: 100%;
            text-align: center;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #ff3333; /* Darker red on hover */
        }

        /* Active menu item */
        .sidebar ul li.active {
            background: #1d2126;
        }

        .sidebar ul li.active a {
            font-weight: bold;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 270px; /* Space to prevent overlap with sidebar */
            padding: 20px;
        }

        header h1 {
            color: #161b22;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Form Styling */
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: 600;
            color: #333;
        }

        .form-group input {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
        }

        .form-group input:focus {
            border-color: #0d1117;
            box-shadow: 0 0 5px rgba(13, 17, 23, 0.5);
        }

        .form-group input[type="file"] {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-group input[type="file"]:focus {
            outline: none;
            border-color: #0d1117;
            box-shadow: 0 0 5px rgba(13, 17, 23, 0.5);
        }

        button[type="submit"] {
            background-color: #0d1117;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #161b22;
        }

        button[type="submit"]:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Blue Lock">
        <ul>
        <li><a href="{{ url(Auth::user()->role . '/home') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ url(Auth::user()->role . '/player') }}"><i class="fas fa-users"></i> Pemain</a></li>
            <li><a href="{{ url(Auth::user()->role . '/pertandingan') }}"><i class="fas fa-futbol"></i> Pertandingan</a></li>
            <li><a href="{{ url(Auth::user()->role . '/laporan') }}"><i class="fas fa-chart-line"></i> Laporan</a></li>
            <li>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Edit Pemain</h1>
        </header>
        <div class="container">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ url(Auth::user()->role . '/player/edit/' . $editPlayer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Pemain</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $editPlayer->name }}" required>
                </div>
                <div class="form-group">
                    <label for="position">Posisi</label>
                    <input type="text" class="form-control" id="position" name="position" value="{{ $editPlayer->position }}" required>
                </div>
                <div class="form-group">
                    <label for="team">Tim</label>
                    <input type="text" class="form-control" id="team" name="team" value="{{ $editPlayer->team }}" required>
                </div>
                <div class="form-group">
                    <label for="age">Usia</label>
                    <input type="number" class="form-control" id="age" name="age" value="{{ $editPlayer->age }}" required>
                </div>
                <div class="form-group">
                    <label for="jersey_number">Nomor Jersey</label>
                    <input type="number" class="form-control" id="jersey_number" name="jersey_number" value="{{ $editPlayer->jersey_number }}" required>
                </div>
                <div class="form-group">
                    <label for="image">Gambar Pemain</label><br>
                    <img src="{{ asset('storage/public/images/' . $editPlayer->image) }}" alt="Current Player Image" width="150" style="margin-bottom: 10px;">
                    <label for="image">Gambar Pemain Saat Ini</label><br>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn">Update Pemain</button>
            </form>
        </div>
    </div>
</body>
</html>
