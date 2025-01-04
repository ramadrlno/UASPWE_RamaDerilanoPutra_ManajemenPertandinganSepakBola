<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <title>Laporan Pertandingan</title>
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

        /* Table Styling */
        .table {
            background-color: #2c3e50;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
            color: #ecf0f1;
        }

        .table th, .table td {
            padding: 12px;
            text-align: center;
        }

        .table th {
            background-color: #34495e;
        }

        .table tbody tr:hover {
            background-color: #1f2a35;
        }

        /* Export Button */
        .btn-export {
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-align: center;
            display: inline-block;
        }

        .btn-export:hover {
            background-color: #2980b9;
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
    <!-- Header -->
    <div class="header">
        <h1>Laporan Pertandingan</h1>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tim 1</th>
                    <th>Tim 2</th>
                    <th>Gol Tim 1</th>
                    <th>Gol Tim 2</th>
                    <th>Pencetak Gol Tim 1</th>
                    <th>Pencetak Gol Tim 2</th>
                    <th>Tanggal Pertandingan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pertandingans as $key => $pertandingan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $pertandingan->tim_1 }}</td>
                    <td>{{ $pertandingan->tim_2 }}</td>
                    <td>{{ $pertandingan->gol_tim_1 }}</td>
                    <td>{{ $pertandingan->gol_tim_2 }}</td>
                    <td>{{ $pertandingan->pencetak_gol_tim_1 }}</td>
                    <td>{{ $pertandingan->pencetak_gol_tim_2 }}</td>
                    <td>{{ $pertandingan->tanggal_pertandingan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Export Button -->
    <a href="{{ url(Auth::user()->role . '/report') }}" class="btn-export">Export to PDF</a>
    <a href="{{ url(Auth::user()->role . '/export') }}" class="btn-export" style="background-color: #27ae60;">Export to CSV</a>
</div>

</body>
</html>
