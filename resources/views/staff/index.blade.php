<!DOCTYPE html>
<html>

<head>
    <title>Riwayat Lembur - Staff</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        header {
            background: #1f2937;
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

        .container {
            max-width: 900px;
            margin: 2rem auto;
            background: #ffffff;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
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

        .top-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .top-info h2 {
            margin: 0;
            font-size: 1.1rem;
        }

        .user-name {
            font-size: 1.1rem;
            color: #ffffff;
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
    </style>
</head>

<body>

    <header>
        <div>
            <div class="user-name">
                Hai Staff <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <div class="container">
        <div class="top-info">
            <h2>Riwayat Lembur Saya</h2>
        </div>

        @if (session('success'))
            <div style="margin-top: 10px; padding: 8px 10px; background:#ecfdf5; color:#166534; border-radius:4px; font-size:0.85rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($overtimes->isEmpty())
            <div class="empty">
                Belum ada data lembur yang diajukan untuk Anda.
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jumlah Jam</th>
                        <th>Alasan</th>
                        <th>Leader</th>
                        <th>Status</th>
                        <th>Yang Bertanggung Jawab</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($overtimes as $overtime)
                        <tr>
                            {{-- kalau kolom di DB namanya "tanggal", ganti date -> tanggal --}}
                            <td>{{ \Carbon\Carbon::parse($overtime->tanggal)->format('d/m/Y') }}</td>

                            <td>{{ substr($overtime->mulai_jam, 0, 5) }} - {{ substr($overtime->selesai_jam, 0, 5) }}</td>

                            <td>
                                @php
                                    $jam = intdiv($overtime->total_jam, 60);
                                    $menit = $overtime->total_jam % 60;
                                @endphp

                                {{ $jam }} jam {{ $menit }} menit
                            </td>

                            <td>{{ $overtime->alasan }}</td>
                            <td>{{ $overtime->leader->name ?? '-' }}</td>

                            <td>
                                @php
                                    $status = $overtime->status;
                                    $badgeClass = match ($status) {
                                        'approved' => 'badge-approved',
                                        'rejected' => 'badge-rejected',
                                        default => 'badge-pending',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td>
                                @if(isset($overtime->manager))
                                    {{ $overtime->manager->name }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>
</html>
