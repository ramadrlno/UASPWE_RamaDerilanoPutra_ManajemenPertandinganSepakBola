<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Tambah Pertandingan</title>
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

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
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
            <li><a href="{{ url(Auth::user()->role . '/laporan') }}"><i class="fas fa-chart-line"></i> Laporan</a></li>
            <li>
                <form action="{{ url('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Tambah Pertandingan</h1>
        </header>

        <div class="container">
        <form action="{{ url(Auth::user()->role . '/pertandingan/add') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="tim_1">Tim 1</label>
                    <input type="text" class="form-control" id="tim_1" name="tim_1" required>
                </div>
                <div class="form-group">
                    <label for="gol_tim_1">Gol Tim 1</label>
                    <input type="number" class="form-control" id="gol_tim_1" name="gol_tim_1" min="0" required>
                </div>
                <div class="form-group">
                    <label for="pencetak_gol_tim_1">Pencetak Gol Tim 1</label>
                    <input type="text" class="form-control" id="pencetak_gol_tim_1" name="pencetak_gol_tim_1" required>
                </div>
                <div class="form-group">
                    <label for="tim_2">Tim 2</label>
                    <input type="text" class="form-control" id="tim_2" name="tim_2" required>
                </div>
                <div class="form-group">
                    <label for="gol_tim_2">Gol Tim 2</label>
                    <input type="number" class="form-control" id="gol_tim_2" name="gol_tim_2" min="0" required>
                </div>
                <div class="form-group">
                    <label for="pencetak_gol_tim_2">Pencetak Gol Tim 2</label>
                    <input type="text" class="form-control" id="pencetak_gol_tim_2" name="pencetak_gol_tim_2" required>
                </div>
                <div class="form-group">
                    <label for="home_away">Home/Away</label>
                    <select class="form-control" id="home_away" name="home_away" required>
                        <option value="home">Home</option>
                        <option value="away">Away</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_pertandingan">Tanggal Pertandingan</label>
                    <input type="date" class="form-control" id="tanggal_pertandingan" name="tanggal_pertandingan" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Pertandingan</button>
            </form>
        </div>
    </div>
</body>
</html>
