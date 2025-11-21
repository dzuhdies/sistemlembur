<!DOCTYPE html>
<html>
<head>
    <title>Tambah Akun - Manager</title>
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
        .user-name {
            font-size: 0.9rem;
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
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
        }
        h2 {
            margin-top: 0;
            font-size: 1.1rem;
        }
        label {
            display: block;
            margin-top: 0.75rem;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        input, select {
            width: 100%;
            padding: 0.5rem 0.6rem;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
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
        .alert {
            padding: 8px 10px;
            background:#ecfdf5;
            color:#166534;
            border-radius:4px;
            font-size:0.85rem;
            margin-bottom:10px;
        }
    </style>
</head>
<body>

<header>
    <div>
        <div class="user-name">
            Login sebagai: <strong>{{ auth()->user()->name }}</strong> (Manager)
        </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</header>

<div class="container">
    <h2>Tambah Akun User Baru</h2>

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

    <form action="{{ route('manager.users.store') }}" method="POST">
        @csrf

        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <label for="role">Role</label>
        <select id="role" name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
            <option value="leader" {{ old('role') === 'leader' ? 'selected' : '' }}>Leader</option>
            <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
        </select>
        @error('role')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="division_id">Divisi</label>
        <select id="division_id" name="division_id">
            <option value="">-- Pilih Divisi (opsional) --</option>
            @foreach($divisis as $divisi)
                <option value="{{ $divisi->id }}" {{ old('division_id') == $divisi->id ? 'selected' : '' }}>
                    {{ $divisi->name }}
                </option>
            @endforeach
        </select>
        @error('division_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn-primary">Simpan Akun</button>
        <a href="{{ route('manager.overtimes.index') }}" class="btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
