<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Admin Login | Portfolio</title>
    <style>
        *{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,sans-serif;background:#f4f7fb;color:#172033}
        .page{min-height:100vh;display:grid;grid-template-columns:1fr 1fr}.brand{display:flex;flex-direction:column;justify-content:center;padding:8vw;background:linear-gradient(145deg,#172554,#1d4ed8);color:#fff}
        .brand h1{font-size:clamp(2.5rem,5vw,4.5rem);line-height:1.05;margin:0 0 24px}.brand p{max-width:560px;font-size:1.1rem;line-height:1.8;color:#dbeafe}
        .login-side{display:flex;align-items:center;justify-content:center;padding:32px}.card{width:100%;max-width:440px;background:#fff;padding:42px;border-radius:24px;box-shadow:0 20px 60px #1e3a8a1a}
        .logo{display:block;width:56px;height:56px;border-radius:50%;border:1px solid #e2e8f0;object-fit:cover;box-shadow:0 4px 14px #1e3a8a1f}.card h2{font-size:30px;margin:24px 0 8px}.muted{color:#64748b;margin:0 0 30px}
        label{display:block;font-size:14px;font-weight:700;margin:18px 0 8px}.input{width:100%;padding:14px 16px;border:1px solid #dbe2ea;border-radius:11px;font:inherit;outline:none}.input:focus{border-color:#2563eb;box-shadow:0 0 0 4px #2563eb18}
        .row{display:flex;align-items:center;gap:9px;margin:18px 0}.row input{width:17px;height:17px}.error{padding:12px 14px;background:#fef2f2;color:#b91c1c;border-radius:10px;font-size:14px;margin-top:16px}
        button{width:100%;border:0;border-radius:11px;padding:14px;background:#2563eb;color:#fff;font:inherit;font-weight:700;cursor:pointer}button:hover{background:#1d4ed8}
        .hint{margin-top:22px;padding:14px;background:#f8fafc;border-radius:10px;color:#64748b;font-size:13px;line-height:1.6}.switch{text-align:center;margin:22px 0 0;color:#64748b;font-size:14px}.switch a{color:#2563eb;font-weight:700;text-decoration:none}
        @media(max-width:850px){.page{grid-template-columns:1fr}.brand{display:none}.login-side{min-height:100vh}.card{padding:30px}}
    </style>
</head>
<body>
<main class="page">
    <section class="brand">
        <h1>Manage your portfolio with confidence.</h1>
        <p>Keep projects, skills, education and visitor messages organized from one simple dashboard.</p>
    </section>
    <section class="login-side">
        <form class="card" method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <img class="logo" src="{{ asset('images/logo.png') }}" alt="Portfolio logo">
            <h2>Welcome back</h2>
            <p class="muted">Sign in to your admin dashboard</p>
            <label for="email">Email address</label>
            <input class="input" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            <label for="password">Password</label>
            <input class="input" id="password" name="password" type="password" autocomplete="current-password" required>
            <label class="row"><input type="checkbox" name="remember" value="1"> Remember me</label>
            @error('email') <div class="error">{{ $message }}</div> @enderror
            <button type="submit">Sign in to dashboard</button>
            <p class="switch">No account yet? <a href="{{ route('admin.register') }}">Create an account</a></p>
            <div class="hint">Default login: <strong>admin@example.com</strong><br>Password: <strong>password</strong></div>
        </form>
    </section>
</main>
</body>
</html>
