<!DOCTYPE html>
<html>
<head>
    <title>Report Lembur Bulanan - Manager</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        header {
            background: #111827;
            color: #f9fafb;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            font-size: 1.25rem;
            margin: 0;
        }
        .user-name {
            font-size: 1.2rem;
            color: #e5e7eb;
        }
        .logout-btn {
            background: transparent;
            border: none;
            color: #f9fafb;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .logout-btn:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            background: #ffffff;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
        }
        h2 {
            margin-top: 0;
            font-size: 1.1rem;
        }
        form {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }
        label {
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }
        input[type="month"] {
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
        }
        .btn-primary {
            background: #2563eb;
            color: #ffffff;
            padding: 0.4rem 0.9rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            margin-left: 0.5rem;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
            padding: 0.4rem 0.9rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: none;
            margin-left: 0.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }
        th, td {
            padding: 0.6rem 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        th {
            background: #f9fafb;
        }
        .empty {
            text-align: center;
            padding: 1.5rem 0;
            color: #6b7280;
        }
    </style>
</head>
<body>

<header>
    <div>
        <div class="user-name">
            Hai Manager <strong>{{ auth()->user()->name }}</strong>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</header>

<div class="container">
    <h2>Report Lembur Bulanan</h2>

    <form method="GET" action="{{ route('manager.overtimes.report') }}">
        <label for="month">Pilih Bulan</label>
        <input type="month" id="month" name="month" value="{{ $month ?? '' }}">
        <button type="submit" class="btn-primary">Filter</button>
        <a href="{{ route('manager.overtimes.index') }}" class="btn-secondary">Kembali ke Daftar</a>
    </form>

    @if ($report->isEmpty())
        <div class="empty">
            Belum ada data lembur disetujui untuk bulan ini.
        </div>
    @else
        <table>
            <thead>
            <tr>
                <th>Staff</th>
                <th>Total Jam Lembur</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($report as $row)
                <tr>
                    <td>{{ $row->staff->name ?? '-' }}</td>
                    <td>
                        @php
                            $jam = floor($row->total_jam / 60);
                            $menit = $row->total_jam % 60;
                        @endphp
                        {{ $jam }} jam {{ $menit }} menit
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
