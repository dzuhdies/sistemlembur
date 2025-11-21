<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            width: 320px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background: #2563eb;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #1e40af;
        }
    </style>
</head>
<body>

<div class="box">

    <h2 style="text-align:center; margin-bottom:1rem;">LOGIN</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" required value="{{ old('name') }}">

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Masuk</button>
    </form>

</div>

</body>
</html>
