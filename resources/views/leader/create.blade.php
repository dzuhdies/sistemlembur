<!DOCTYPE html>
<html>

<head>
    <title>Ajukan Lembur - Leader</title>
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
            font-size: 1,5rem;
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
            max-width: 700px;
            margin: 2rem auto;
            background: #ffffff;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        label {
            display: block;
            margin-top: 0.75rem;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.5rem 0.6rem;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
        }

        textarea {
            min-height: 80px;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
            padding: 0.55rem 1.2rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
            padding: 0.55rem 1.2rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .error {
            color: #b91c1c;
            font-size: 0.8rem;
            margin-top: 2px;
        }

        .field-group {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>

    <header>
        <div>
            <h1>Pengajuan Lembur Staff</h1>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <div class="container">
        <h2>Form Pengajuan Lembur Staff</h2>

        @if ($errors->any())
        <div style="padding: 8px 10px; background:#fef2f2; color:#991b1b; border-radius:4px; font-size:0.85rem; margin-bottom:10px;">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 5px 0 0 18px; padding: 0;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('leader.overtimes.store') }}" method="POST">
            @csrf

            <select name="staff_id" id="staff_id" required>
                <option value="">-- Pilih Staff --</option>
                @foreach($staffs as $staff)
                <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                    {{ $staff->name }}
                </option>
                @endforeach
            </select>
            @error('staff_id')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="date">Tanggal Lembur</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}" required>
            @error('date')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="start_time">Mulai Jam</label>
            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
            @error('start_time')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="end_time">Selesai Jam</label>
            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
            @error('end_time')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="reason">Alasan Lembur</label>
            <textarea id="reason" name="reason" required>{{ old('reason') }}</textarea>
            @error('reason')
            <div class="error">{{ $message }}</div>
            @enderror


            <button type="submit" class="btn-primary">Simpan Pengajuan</button>
            <a href="{{ route('leader.overtimes.index') }}" class="btn-secondary">Kembali</a>
        </form>
    </div>

</body>

</html>