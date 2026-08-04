<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>About | Portfolio Admin</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f6f7fb;color:#172033;font-family:Inter,system-ui,sans-serif}a{text-decoration:none;color:inherit}button,input,textarea{font:inherit}
        .app{display:grid;grid-template-columns:270px minmax(0,1fr);min-height:100vh}.side{position:sticky;top:0;height:100vh;padding:26px 18px;background:radial-gradient(circle at 20% 0%,#312e81 0,transparent 32%),linear-gradient(180deg,#111827,#0f172a);color:#cbd5e1}.brand{display:flex;align-items:center;gap:12px;padding:0 10px 28px;color:#fff;font-weight:800}.brand img{width:46px;height:46px;border:2px solid #ffffff26;border-radius:15px;object-fit:cover}.label{padding:14px 12px 8px;color:#64748b;font-size:10px;font-weight:800;letter-spacing:.15em}.nav a{display:flex;gap:12px;align-items:center;margin:4px 0;padding:12px 13px;border-radius:12px}.nav a:hover,.nav a.active{color:#fff;background:#ffffff0d}.nav a.active{background:linear-gradient(135deg,#4f46e5,#6366f1)}.icon{width:24px;text-align:center}
        .top{position:sticky;top:0;z-index:5;display:flex;min-height:78px;align-items:center;justify-content:space-between;padding:0 34px;border-bottom:1px solid #e9ebf1;background:#fffffff0}.top small{display:block;color:#6b7280;font-size:11px;font-weight:700;text-transform:uppercase}.top strong{font-size:20px}.back{padding:10px 14px;border:1px solid #e5e7eb;border-radius:10px;color:#4f46e5;background:#fff;font-size:13px;font-weight:700}
        .content{max-width:1050px;margin:auto;padding:32px 34px 50px}.heading h1{margin:0;font-size:30px}.heading p{margin:8px 0 25px;color:#64748b}.notice,.errors{margin-bottom:20px;padding:14px 17px;border-radius:12px}.notice{border:1px solid #a7f3d0;color:#047857;background:#ecfdf5}.errors{border:1px solid #fecaca;color:#b91c1c;background:#fef2f2}
        .panel{overflow:hidden;border:1px solid #e8eaf0;border-radius:18px;background:#fff;box-shadow:0 8px 25px #1118270a}.panel-head{padding:20px 24px;border-bottom:1px solid #eef0f4}.panel-head h2{margin:0;font-size:17px}.form{display:grid;grid-template-columns:1fr 1fr;gap:19px;padding:25px}.wide{grid-column:1/-1}label{display:block;margin-bottom:7px;font-size:12px;font-weight:750}.input{width:100%;padding:12px 14px;border:1px solid #dce1e9;border-radius:10px;outline:none}.input:focus{border-color:#818cf8;box-shadow:0 0 0 4px #6366f119}textarea.input{min-height:150px;resize:vertical}.btn{grid-column:1/-1;width:fit-content;border:0;border-radius:10px;padding:12px 18px;color:#fff;background:#4f46e5;font-weight:750;cursor:pointer}
        @media(max-width:800px){.app{display:block}.side{position:static;height:auto}.nav{display:flex;overflow:auto}.label,.brand{display:none}.nav a{white-space:nowrap}.content{padding:22px 15px}.top{padding:0 16px}.form{grid-template-columns:1fr}.wide,.btn{grid-column:auto}}
    </style>
</head>
<body>
<div class="app">
    <aside class="side">
        <a class="brand" href="{{ route('admin.dashboard') }}"><img src="{{ asset('images/logo.png') }}" alt="">Portfolio Admin</a>
        <div class="label">MAIN MENU</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}"><span class="icon">⌂</span>Dashboard</a>
            <a class="active" href="{{ route('admin.profile.edit') }}"><span class="icon">◎</span>About</a>
            <a href="{{ route('admin.contacts.index') }}"><span class="icon">✉</span>Contact</a>
            <a href="{{ route('admin.content.index','projects') }}"><span class="icon">▧</span>Projects</a>
            <a href="{{ route('admin.content.index','services') }}"><span class="icon">◆</span>Services</a>
            <a href="{{ route('admin.content.index','skills') }}"><span class="icon">◇</span>Skills</a>
            <a href="{{ route('admin.content.index','educations') }}"><span class="icon">▤</span>Education</a>
            <a href="{{ route('admin.content.index','experiences') }}"><span class="icon">▣</span>Experience</a>
        </nav>
    </aside>
    <main>
        <header class="top"><div><small>Portfolio content</small><strong>About</strong></div><a class="back" href="{{ route('admin.dashboard') }}">← Dashboard</a></header>
        <div class="content">
            <div class="heading"><h1>Edit About Information</h1><p>Update the personal information exposed by the profile API.</p></div>
            @if(session('success'))<div class="notice">✓ {{ session('success') }}</div>@endif
            @if($errors->any())<div class="errors">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
            <section class="panel">
                <div class="panel-head"><h2>Profile details</h2></div>
                <form class="form" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div><label for="full_name">Full name *</label><input class="input" id="full_name" name="full_name" value="{{ old('full_name',$profile?->full_name) }}" required></div>
                    <div><label for="title">Professional title</label><input class="input" id="title" name="title" value="{{ old('title',$profile?->title) }}"></div>
                    <div class="wide"><label for="description">About description</label><textarea class="input" id="description" name="description">{{ old('description',$profile?->description) }}</textarea></div>
                    <div><label for="email">Email</label><input class="input" id="email" type="email" name="email" value="{{ old('email',$profile?->email) }}"></div>
                    <div><label for="phone">Phone</label><input class="input" id="phone" name="phone" value="{{ old('phone',$profile?->phone) }}"></div>
                    <div><label for="address">Address</label><input class="input" id="address" name="address" value="{{ old('address',$profile?->address) }}"></div>
                    <div>
                        <label for="profile_image_upload">Upload profile image</label>
                        <input class="input" id="profile_image_upload" type="file" name="profile_image_upload" accept="image/*">
                        @if($profile?->profile_image)<small>Current: {{ $profile->profile_image }}</small>@endif
                    </div>
                    <div>
                        <label for="profile_image_url">Or profile image URL</label>
                        <input class="input" id="profile_image_url" type="url" name="profile_image_url" value="{{ old('profile_image_url',str_starts_with($profile?->profile_image ?? '','http') ? $profile->profile_image : '') }}" placeholder="https://example.com/photo.jpg">
                    </div>
                    <div>
                        <label for="cv_upload">Upload CV</label>
                        <input class="input" id="cv_upload" type="file" name="cv_upload" accept=".pdf,.doc,.docx">
                        @if($profile?->cv_file)<small>Current: {{ $profile->cv_file }}</small>@endif
                    </div>
                    <div>
                        <label for="cv_url">Or CV URL</label>
                        <input class="input" id="cv_url" type="url" name="cv_url" value="{{ old('cv_url',str_starts_with($profile?->cv_file ?? '','http') ? $profile->cv_file : '') }}" placeholder="https://example.com/cv.pdf">
                    </div>
                    <button class="btn" type="submit">Save About Information</button>
                </form>
            </section>
        </div>
    </main>
</div>
<script src="{{ asset('js/admin-preferences.js') }}"></script>
</body>
</html>
