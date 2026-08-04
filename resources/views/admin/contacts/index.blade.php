<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"><title>Contact Messages | Portfolio Admin</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f6f7fb;color:#172033;font-family:Inter,system-ui,sans-serif}a{text-decoration:none;color:inherit}button,select{font:inherit}.app{display:grid;grid-template-columns:270px minmax(0,1fr);min-height:100vh}.side{position:sticky;top:0;height:100vh;padding:26px 18px;background:radial-gradient(circle at 20% 0%,#312e81 0,transparent 32%),linear-gradient(180deg,#111827,#0f172a);color:#cbd5e1}.brand{display:flex;align-items:center;gap:12px;padding:0 10px 28px;color:#fff;font-weight:800}.brand img{width:46px;height:46px;border-radius:15px;object-fit:cover}.label{padding:14px 12px 8px;color:#64748b;font-size:10px;font-weight:800;letter-spacing:.15em}.nav a{display:flex;gap:12px;align-items:center;margin:4px 0;padding:12px 13px;border-radius:12px}.nav a:hover,.nav a.active{color:#fff;background:#ffffff0d}.nav a.active{background:linear-gradient(135deg,#4f46e5,#6366f1)}.icon{width:24px;text-align:center}
        .top{display:flex;min-height:78px;align-items:center;justify-content:space-between;padding:0 34px;border-bottom:1px solid #e9ebf1;background:#fff}.top small{display:block;color:#6b7280;font-size:11px;font-weight:700;text-transform:uppercase}.top strong{font-size:20px}.content{max-width:1450px;margin:auto;padding:32px 34px}.heading{display:flex;justify-content:space-between;align-items:end;margin-bottom:24px}.heading h1{margin:0;font-size:30px}.heading p{margin:7px 0 0;color:#64748b}.count{padding:9px 13px;border-radius:10px;color:#4338ca;background:#eef2ff;font-weight:700}.notice{margin-bottom:20px;padding:14px;border:1px solid #a7f3d0;border-radius:12px;color:#047857;background:#ecfdf5}.panel{overflow:hidden;border:1px solid #e8eaf0;border-radius:18px;background:#fff;box-shadow:0 8px 25px #1118270a}.messages{display:grid;gap:0}.message{display:grid;grid-template-columns:190px minmax(250px,1fr) 210px;gap:22px;padding:22px;border-bottom:1px solid #eef0f4}.message:last-child{border:0}.sender strong,.sender a{display:block}.sender a{margin-top:5px;color:#4f46e5;font-size:12px}.body h2{margin:0 0 7px;font-size:15px}.body p{margin:0;color:#64748b;line-height:1.6;white-space:pre-wrap}.meta time{display:block;margin-bottom:12px;color:#94a3b8;font-size:11px}.actions{display:flex;gap:7px}.select{max-width:120px;padding:8px;border:1px solid #dce1e9;border-radius:8px}.save,.delete{border:0;border-radius:8px;padding:8px 10px;font-size:11px;font-weight:700;cursor:pointer}.save{color:#4338ca;background:#eef2ff}.delete{color:#dc2626;background:#fef2f2}.empty{padding:50px;text-align:center;color:#94a3b8}.pagination{padding:20px}.pagination svg{width:18px}.pagination nav>div:first-child{display:none}
        @media(max-width:950px){.message{grid-template-columns:1fr}.app{grid-template-columns:86px 1fr}.brand{font-size:0}.nav a{justify-content:center;font-size:0}.label{display:none}}@media(max-width:650px){.app{display:block}.side{position:static;height:auto}.brand,.label{display:none}.nav{display:flex;overflow:auto}.nav a{white-space:nowrap}.content{padding:20px 14px}.top{padding:0 16px}}
    </style>
</head>
<body><div class="app">
    <aside class="side"><a class="brand" href="{{ route('admin.dashboard') }}"><img src="{{ asset('images/logo.png') }}" alt="">Portfolio Admin</a><div class="label">MAIN MENU</div><nav class="nav">
        <a href="{{ route('admin.dashboard') }}"><span class="icon">⌂</span>Dashboard</a>
        <a href="{{ route('admin.profile.edit') }}"><span class="icon">◎</span>About</a>
        <a class="active" href="{{ route('admin.contacts.index') }}"><span class="icon">✉</span>Contact</a>
        <a href="{{ route('admin.content.index','projects') }}"><span class="icon">▧</span>Projects</a>
        <a href="{{ route('admin.content.index','services') }}"><span class="icon">◆</span>Services</a>
        <a href="{{ route('admin.content.index','skills') }}"><span class="icon">◇</span>Skills</a>
        <a href="{{ route('admin.content.index','educations') }}"><span class="icon">▤</span>Education</a>
        <a href="{{ route('admin.content.index','experiences') }}"><span class="icon">▣</span>Experience</a>
    </nav></aside>
    <main><header class="top"><div><small>Inbox</small><strong>Contact Messages</strong></div></header><div class="content">
        <div class="heading"><div><h1>Contact Messages</h1><p>Messages submitted from the portfolio contact form.</p></div><span class="count">{{ $contacts->total() }} messages</span></div>
        @if(session('success'))<div class="notice">✓ {{ session('success') }}</div>@endif
        <section class="panel"><div class="messages">
            @forelse($contacts as $contact)
                <article class="message">
                    <div class="sender"><strong>{{ $contact->name }}</strong><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></div>
                    <div class="body"><h2>{{ $contact->subject ?: 'No subject' }}</h2><p>{{ $contact->message }}</p></div>
                    <div class="meta"><time>{{ $contact->created_at->format('M d, Y · H:i') }}</time><div class="actions">
                        <form method="POST" action="{{ route('admin.contacts.update',$contact) }}">@csrf @method('PATCH')<select class="select" name="status"><option value="new" @selected($contact->status==='new')>New</option><option value="read" @selected($contact->status==='read')>Read</option><option value="replied" @selected($contact->status==='replied')>Replied</option></select><button class="save">Save</button></form>
                        <form method="POST" action="{{ route('admin.contacts.destroy',$contact) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')<button class="delete">Delete</button></form>
                    </div></div>
                </article>
            @empty <div class="empty">No contact messages yet.</div>
            @endforelse
        </div><div class="pagination">{{ $contacts->links() }}</div></section>
    </div></main>
</div><script src="{{ asset('js/admin-preferences.js') }}"></script></body></html>
