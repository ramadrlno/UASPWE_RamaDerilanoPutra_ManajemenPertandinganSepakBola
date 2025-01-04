<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Dashboard Pertandingan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Basic Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #141414;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            background: linear-gradient(135deg, #0d1117, #161b22);
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
            background: transparent;
            border: none;
            cursor: pointer;
            outline: none;
            width: 100%;
        }

        .logout-btn:hover {
            background: #21262d;
            border-radius: 8px;
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        /* Header Styling */
        .header {
            background-color: #1c1c1c;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 36px;
            font-weight: bold;
            color: #3498db;
        }

        /* Match Grid */
        .match-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .match-card {
            background-color: #2c3e50;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .match-card h3 {
            font-size: 20px;
            color: #ecf0f1;
            margin-bottom: 10px;
        }

        .match-card p {
            font-size: 16px;
            color: #bdc3c7;
        }

        .match-card .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Blue Lock">
        <ul>
            <li><a href="{{ url(Auth::user()->role . '/home') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ url(Auth::user()->role . '/player') }}"><i class="fas fa-users"></i> Pemain</a></li>
            <li><a href="{{ url(Auth::user()->role . '/pertandingan') }}"><i class="fas fa-futbol"></i> Pertandingan</a></li>
            <li><a href="{{ url(Auth::user()->role . '/laporan') }}"><i class="fas fa-file-alt"></i> Laporan</a></li>
            <li>
                <form action="{{ url('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
    <div class="header">
        <h1>Daftar Pertandingan</h1>
        @if(Auth::user()->role == 'admin') 
            <a href="{{ url(Auth::user()->role . '/pertandingan/add') }}" class="btn btn-primary">Tambah Pertandigan</a>
        @endif
    </div>
        <div class="match-grid">
            @foreach ($pertandingans as $match)
            <div class="match-card">
                <h3>{{ $match->tim_1 }} vs {{ $match->tim_2 }}</h3>
                <p><strong>Skor:</strong> {{ $match->gol_tim_1 }} - {{ $match->gol_tim_2 }}</p>
                <p><strong>Tanggal:</strong> {{ $match->tanggal_pertandingan }}</p>
                <p><strong>Lokasi:</strong> {{ $match->home_away == 'home' ? 'Home' : 'Away' }}</p>
                           @if(Auth::user()->role == 'admin')
    <a href="{{ url(Auth::user()->role . '/pertandingan/edit/' . $match->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ url(Auth::user()->role . '/pertandingan/delete/' . $match->id) }}" method="POST" style="display: inline;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
@elseif(Auth::user()->role == 'user')
    <a href="{{ url(Auth::user()->role . '/pertandingan/edit/' . $match->id) }}" class="btn btn-warning">Edit</a>
@endif
        </div>
        @endforeach
        </div>
    </div>
</body>
</html>
