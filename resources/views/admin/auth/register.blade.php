<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Create Admin Account | Portfolio</title>
    <style>
        *{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,sans-serif;background:#f4f7fb;color:#172033}
        .page{min-height:100vh;display:grid;grid-template-columns:1fr 1fr}.brand{display:flex;flex-direction:column;justify-content:center;padding:8vw;background:linear-gradient(145deg,#172554,#1d4ed8);color:#fff}
        .brand h1{font-size:clamp(2.5rem,5vw,4.5rem);line-height:1.05;margin:0 0 24px}.brand p{max-width:560px;font-size:1.1rem;line-height:1.8;color:#dbeafe}
        .form-side{display:flex;align-items:center;justify-content:center;padding:32px}.card{width:100%;max-width:460px;background:#fff;padding:38px 42px;border-radius:24px;box-shadow:0 20px 60px #1e3a8a1a}
        .logo{display:block;width:56px;height:56px;border-radius:50%;border:1px solid #e2e8f0;object-fit:cover;box-shadow:0 4px 14px #1e3a8a1f}.card h2{font-size:30px;margin:20px 0 7px}.muted{color:#64748b;margin:0 0 22px}
        label{display:block;font-size:14px;font-weight:700;margin:15px 0 7px}.input{width:100%;padding:13px 16px;border:1px solid #dbe2ea;border-radius:11px;font:inherit;outline:none}.input:focus{border-color:#2563eb;box-shadow:0 0 0 4px #2563eb18}
        .error{color:#b91c1c;font-size:12px;margin:6px 0 0}.errors{padding:12px 14px;background:#fef2f2;color:#b91c1c;border-radius:10px;font-size:13px;margin-bottom:16px}
        button{width:100%;border:0;border-radius:11px;padding:14px;margin-top:22px;background:#2563eb;color:#fff;font:inherit;font-weight:700;cursor:pointer}button:hover{background:#1d4ed8}
        .switch{text-align:center;margin:20px 0 0;color:#64748b;font-size:14px}.switch a{color:#2563eb;font-weight:700;text-decoration:none}
        @media(max-width:850px){.page{grid-template-columns:1fr}.brand{display:none}.form-side{min-height:100vh}.card{padding:30px}}
    </style>
</head>
<body>
<main class="page">
    <section class="brand">
        <h1>Build and manage your digital presence.</h1>
        <p>Create an admin account to manage portfolio projects, skills, education and visitor messages.</p>
    </section>
    <section class="form-side">
        <form class="card" method="POST" action="{{ route('admin.register.submit') }}">
            @csrf
            <img class="logo" src="{{ asset('images/logo.png') }}" alt="Portfolio logo">
            <h2>Create account</h2>
            <p class="muted">Register for the portfolio dashboard</p>
            @if($errors->any())
                <div class="errors">Please check the information below.</div>
            @endif
            <label for="name">Full name</label>
            <input class="input" id="name" name="name" value="{{ old('name') }}" maxlength="100" autocomplete="name" required autofocus>
            @error('name') <p class="error">{{ $message }}</p> @enderror
            <label for="email">Email address</label>
            <input class="input" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
            @error('email') <p class="error">{{ $message }}</p> @enderror
            <label for="password">Password</label>
            <input class="input" id="password" name="password" type="password" minlength="8" autocomplete="new-password" required>
            @error('password') <p class="error">{{ $message }}</p> @enderror
            <label for="password_confirmation">Confirm password</label>
            <input class="input" id="password_confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" required>
            <button type="submit">Create account</button>
            <p class="switch">Already registered? <a href="{{ route('admin.login') }}">Sign in</a></p>
        </form>
    </section>
</main>
</body>
</html>
