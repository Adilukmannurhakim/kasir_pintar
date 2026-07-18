<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kasir Maju Jaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            background: #f8fafc;
            display: flex; justify-content: center; align-items: center;
            height: 100vh; color: #1e293b;
        }
        .login-card {
            background: #ffffff; padding: 40px; border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            width: 100%; max-width: 400px;
        }
        .brand {
            text-align: center; margin-bottom: 24px;
        }
        .brand h2 {
            color: #4f46e5; font-size: 24px; font-weight: 700;
        }
        .brand p {
            color: #64748b; font-size: 14px; margin-top: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block; font-size: 14px; font-weight: 500; margin-bottom: 6px; color: #475569;
        }
        .form-group input {
            width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 8px;
            font-size: 14px; outline: none; transition: 0.2s;
        }
        .form-group input:focus {
            border-color: #4f46e5; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        .btn-login {
            width: 100%; background: #4f46e5; color: white; border: none; padding: 12px;
            border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: 0.2s;
        }
        .btn-login:hover { background: #4338ca; }
        .alert-error {
            background: #fef2f2; color: #b91c1c; padding: 12px; border-radius: 8px;
            font-size: 13px; margin-bottom: 20px; border: 1px solid #fca5a5;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand">
        <h2>MAJU JAYA</h2>
        <p>Silakan masuk ke akun kasir Anda</p>
    </div>

    <!-- Alert Error Jika Login Gagal -->
    @if($errors->has('loginError'))
        <div class="alert-error">
            {{ $errors->first('loginError') }}
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>
        <button type="submit" class="btn-login">Login</button>
    </form>
</div>

</body>
</html>