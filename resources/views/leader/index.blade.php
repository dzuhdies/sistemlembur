<!DOCTYPE html>
<html>

<head>
    <title>Pengajuan Lembur - Leader</title>
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
            font-size: 1rem;
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
            max-width: 1000px;
            margin: 2rem auto;
            background: #ffffff;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .top-bar h2 {
            margin: 0;
            font-size: 1.1rem;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        th,
        td {
            padding: 0.6rem 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background: #dcfce7;
            color: #166534;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
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
                Hai Leader <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <div class="container">
        <div class="top-bar">
            <h2>Daftar Pengajuan Lembur Staff</h2>

            <a href="{{ route('leader.overtimes.create') }}" class="btn-primary">
                + Ajukan Lembur
            </a>
        </div>

        @if (session('success'))
        <div style="margin-top: 10px; padding: 8px 10px; background:#ecfdf5; color:#166534; border-radius:4px; font-size:0.85rem;">
            {{ session('success') }}
        </div>
        @endif

        @if ($overtimes->isEmpty())
        <div class="empty">
            Belum ada pengajuan lembur yang Anda buat.
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Staff</th>
                    <th>Jam</th>
                    <th>Total Jam</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Manager</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($overtimes as $overtime)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $overtime->staff->name ?? '-' }}</td>
                    <td>{{ substr($overtime->mulai_jam, 0, 5) }} - {{ substr($overtime->selesai_jam, 0, 5) }}</td>
                    <td> 
                            @php
                                $jam = floor($overtime->total_jam / 60);
                                $menit = $overtime->total_jam % 60;
                            @endphp

                            {{ $jam }} jam {{ $menit }} menit
                    </td>
                    <td>{{ $overtime->alasan }}</td>
                    <td>
                        @php
                        $status = $overtime->status;
                        $badgeClass = match($status) {
                        'approved' => 'badge-approved',
                        'rejected' => 'badge-rejected',
                        default => 'badge-pending',
                        };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td>{{ $overtime->manager->name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</body>

</html>