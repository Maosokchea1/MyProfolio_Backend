<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Dashboard | Portfolio Admin</title>
    <script>
        document.documentElement.dataset.theme = localStorage.getItem('admin-theme') || 'dark';
        document.documentElement.lang = localStorage.getItem('admin-language') || 'en';
    </script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --page: #f6f7fb;
            --surface: #ffffff;
            --text: #172033;
            --muted: #6b7280;
            --line: #e8eaf0;
            --sidebar: #111827;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--text);
            background: var(--page);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        a { color: inherit; text-decoration: none; }
        button { font: inherit; }

        .app {
            display: grid;
            grid-template-columns: 270px minmax(0, 1fr);
            min-height: 100vh;
        }

        .sidebar {
            position: sticky;
            top: 0;
            display: flex;
            height: 100vh;
            flex-direction: column;
            padding: 26px 18px 20px;
            overflow-y: auto;
            color: #cbd5e1;
            background:
                radial-gradient(circle at 20% 0%, #312e81 0, transparent 32%),
                linear-gradient(180deg, #111827 0%, #0f172a 100%);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 28px;
            color: #fff;
            font-size: 18px;
            font-weight: 800;
        }

        .brand img {
            width: 46px;
            height: 46px;
            border: 2px solid #ffffff26;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 10px 24px #0004;
        }

        .nav-label {
            padding: 14px 12px 8px;
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .15em;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 0;
            padding: 12px 13px;
            border: 1px solid transparent;
            border-radius: 12px;
            transition: .2s ease;
        }

        .nav a:hover {
            color: #fff;
            background: #ffffff0d;
            transform: translateX(2px);
        }

        .nav a.active {
            color: #fff;
            border-color: #ffffff12;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            box-shadow: 0 10px 25px #312e8166;
        }

        .nav-icon {
            display: grid;
            width: 24px;
            height: 24px;
            place-items: center;
            font-size: 17px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 18px 12px 4px;
            border-top: 1px solid #ffffff12;
            color: #64748b;
            font-size: 12px;
            line-height: 1.6;
        }

        .main { min-width: 0; }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            display: flex;
            min-height: 78px;
            align-items: center;
            justify-content: space-between;
            padding: 0 34px;
            border-bottom: 1px solid #e9ebf1cc;
            background: #fffffff0;
            backdrop-filter: blur(16px);
        }

        .topbar-title small {
            display: block;
            margin-bottom: 3px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .topbar-title strong { font-size: 20px; }

        .account {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            border-radius: 13px;
            color: #fff;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            font-weight: 800;
            box-shadow: 0 8px 20px #4f46e533;
        }

        .account-copy strong, .account-copy span { display: block; }
        .account-copy strong { font-size: 13px; }
        .account-copy span { margin-top: 2px; color: var(--muted); font-size: 11px; }

        .logout {
            margin-left: 8px;
            padding: 9px 12px;
            border: 1px solid var(--line);
            border-radius: 10px;
            color: #64748b;
            background: #fff;
            cursor: pointer;
        }

        .logout:hover { color: #dc2626; border-color: #fecaca; background: #fef2f2; }

        .content {
            width: min(1500px, 100%);
            margin: 0 auto;
            padding: 32px 34px 44px;
        }

        .notice {
            margin-bottom: 22px;
            padding: 14px 17px;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            color: #047857;
            background: #ecfdf5;
        }

        .hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 28px 30px;
            overflow: hidden;
            border-radius: 22px;
            color: #fff;
            background:
                radial-gradient(circle at 85% 10%, #ffffff2b 0 4%, transparent 4.5%),
                radial-gradient(circle at 92% 75%, #ffffff1c 0 11%, transparent 11.5%),
                linear-gradient(125deg, #312e81 0%, #4f46e5 55%, #7c3aed 100%);
            box-shadow: 0 20px 45px #4338ca26;
        }

        .hero::after {
            position: absolute;
            right: 14%;
            width: 170px;
            height: 170px;
            border: 30px solid #ffffff0f;
            border-radius: 50%;
            content: "";
        }

        .hero-copy { position: relative; z-index: 1; }
        .hero h1 { margin: 0; font-size: clamp(25px, 3vw, 34px); }
        .hero p { margin: 9px 0 0; color: #e0e7ff; line-height: 1.6; }

        .portfolio-link {
            position: relative;
            z-index: 1;
            flex: 0 0 auto;
            padding: 12px 17px;
            border: 1px solid #ffffff38;
            border-radius: 12px;
            color: #fff;
            background: #ffffff18;
            font-size: 13px;
            font-weight: 700;
            backdrop-filter: blur(8px);
        }

        .portfolio-link:hover { background: #ffffff26; }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
            margin-top: 22px;
        }

        .stat {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 13px;
            padding: 19px;
            border: 1px solid var(--line);
            border-radius: 17px;
            background: var(--surface);
            box-shadow: 0 7px 22px #11182708;
            transition: transform .2s, box-shadow .2s;
        }

        .stat:hover { transform: translateY(-3px); box-shadow: 0 14px 28px #11182712; }

        .stat-icon {
            display: grid;
            width: 46px;
            height: 46px;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 14px;
            font-size: 21px;
        }

        .blue { color: #2563eb; background: #dbeafe; }
        .violet { color: #7c3aed; background: #ede9fe; }
        .amber { color: #d97706; background: #fef3c7; }
        .emerald { color: #059669; background: #d1fae5; }

        .stat p {
            margin: 0;
            overflow: hidden;
            color: var(--muted);
            font-size: 12px;
            text-overflow: ellipsis;
        }

        .stat strong { display: block; margin-top: 2px; font-size: 25px; }

        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(300px, .65fr);
            gap: 20px;
            margin-top: 22px;
        }

        .panel {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: 0 7px 22px #11182708;
        }

        .panel-head {
            display: flex;
            min-height: 64px;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 0 22px;
            border-bottom: 1px solid #eef0f4;
        }

        .panel-head h2 { margin: 0; font-size: 16px; }
        .panel-head span, .panel-head a { color: var(--muted); font-size: 12px; }

        table { width: 100%; border-collapse: collapse; }

        th, td {
            padding: 15px 21px;
            border-bottom: 1px solid #f0f2f6;
            text-align: left;
            font-size: 13px;
        }

        tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #fafaff; }

        th {
            color: #94a3b8;
            background: #fbfcfe;
            font-size: 10px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .project-name strong { display: block; margin-bottom: 4px; }

        .project-name small {
            display: block;
            max-width: 320px;
            overflow: hidden;
            color: var(--muted);
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 99px;
            color: #047857;
            background: #ecfdf5;
            font-size: 11px;
            font-weight: 700;
        }

        .badge::before {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            content: "";
        }

        .messages { padding: 5px 20px; }

        .message {
            display: grid;
            grid-template-columns: 38px minmax(0, 1fr);
            gap: 12px;
            padding: 15px 0;
            border-bottom: 1px solid #eff1f5;
        }

        .message:last-child { border-bottom: 0; }

        .message-avatar {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 12px;
            color: #4f46e5;
            background: #eef2ff;
            font-size: 13px;
            font-weight: 800;
        }

        .message-top { display: flex; justify-content: space-between; gap: 10px; }
        .message-top strong { overflow: hidden; font-size: 13px; text-overflow: ellipsis; white-space: nowrap; }
        .message time { flex: 0 0 auto; color: #94a3b8; font-size: 10px; }

        .message p {
            margin: 5px 0 0;
            overflow: hidden;
            color: var(--muted);
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .empty { padding: 40px 20px; color: #94a3b8; text-align: center; }

        @media (max-width: 1200px) {
            .stats { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 950px) {
            .app { grid-template-columns: 86px minmax(0, 1fr); }
            .sidebar { padding-inline: 12px; }
            .brand { justify-content: center; padding-inline: 0; font-size: 0; }
            .nav-label, .sidebar-footer { display: none; }
            .nav a { justify-content: center; padding: 12px; font-size: 0; }
            .nav-icon { font-size: 18px; }
            .dashboard-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 700px) {
            .app { display: block; }
            .sidebar { position: static; display: block; width: 100%; height: auto; padding: 12px; }
            .brand { display: none; }
            .nav { display: flex; overflow-x: auto; }
            .nav a { flex: 0 0 auto; margin: 0 3px; }
            .topbar { min-height: 68px; padding: 0 16px; }
            .account-copy, .logout { display: none; }
            .content { padding: 20px 14px 34px; }
            .hero { align-items: flex-start; padding: 23px; }
            .portfolio-link { display: none; }
            .stats { grid-template-columns: repeat(2, 1fr); }
            .stat { padding: 15px; }
            .stat-icon { width: 41px; height: 41px; }
            .table-wrap { overflow-x: auto; }
            table { min-width: 600px; }
        }

        /* Match the public portfolio's slate and indigo visual system. */
        :root {
            --page: #020617;
            --surface: #0f172a;
            --text: #f8fafc;
            --muted: #94a3b8;
            --line: #1e293b;
        }

        body { background: var(--page); }
        .sidebar {
            border-right: 1px solid #1e293b;
            background: radial-gradient(circle at 20% 0%, #312e8155 0, transparent 32%), #020617;
        }
        .topbar {
            border-color: #1e293bcc;
            background: #020617e6;
        }
        .logout {
            border-color: #334155;
            color: #cbd5e1;
            background: #0f172a;
        }
        .hero {
            border: 1px solid #312e81;
            background: radial-gradient(circle at 85% 20%, #6366f126, transparent 30%), linear-gradient(125deg, #0f172a, #1e1b4b);
            box-shadow: 0 20px 45px #0005;
        }
        .stat, .panel { box-shadow: 0 12px 30px #0003; }
        .stat:hover { border-color: #4f46e5; box-shadow: 0 18px 35px #312e8138; }
        .panel-head, th, td, .message { border-color: #1e293b; }
        th { color: #94a3b8; background: #111c30; }
        tbody tr:hover { background: #1e293b80; }
        .message-avatar { color: #a5b4fc; background: #312e8155; }
        .badge { color: #6ee7b7; background: #064e3b55; }
        .notice { border-color: #065f46; color: #6ee7b7; background: #064e3b55; }

        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .preference-button {
            min-width: 42px;
            height: 40px;
            padding: 0 11px;
            border: 1px solid #334155;
            border-radius: 11px;
            color: #cbd5e1;
            background: #0f172a;
            cursor: pointer;
            font-size: 12px;
            font-weight: 800;
        }
        .preference-button:hover { color: #fff; border-color: #4f46e5; }
        .language-picker { display: flex; padding: 3px; border: 1px solid #334155; border-radius: 11px; background: #0f172a; }
        .language-option { height: 32px; padding: 0 9px; border: 0; border-radius: 8px; color: #94a3b8; background: transparent; cursor: pointer; font-weight: 800; }
        .language-option.active { color: #fff; background: #4f46e5; }

        html[data-theme="light"] {
            --page: #f6f7fb;
            --surface: #fff;
            --text: #172033;
            --muted: #64748b;
            --line: #e2e8f0;
            color-scheme: light;
        }
        html[data-theme="light"] .sidebar {
            color: #475569;
            border-color: #e2e8f0;
            background: #fff;
        }
        html[data-theme="light"] .brand { color: #172033; }
        html[data-theme="light"] .nav a:hover { color: #172033; background: #f1f5f9; }
        html[data-theme="light"] .nav a.active { color: #fff; }
        html[data-theme="light"] .topbar { border-color: #e2e8f0; background: #ffffffed; }
        html[data-theme="light"] .preference-button,
        html[data-theme="light"] .logout { color: #475569; border-color: #e2e8f0; background: #fff; }
        html[data-theme="light"] .language-picker { border-color: #e2e8f0; background: #fff; }
        html[data-theme="light"] .language-option.active { color: #fff; background: #4f46e5; }
        html[data-theme="light"] .hero {
            border-color: #c7d2fe;
            background: linear-gradient(125deg, #312e81, #4f46e5 60%, #7c3aed);
        }
        html[data-theme="light"] th { background: #f8fafc; }
        html[data-theme="light"] tbody tr:hover { background: #f8fafc; }

        @media (max-width: 700px) {
            .topbar-actions { gap: 5px; }
            .preference-button { min-width: 38px; padding: 0 8px; }
        }
    </style>
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Portfolio logo">
            <span data-i18n="brand">Portfolio Admin</span>
        </a>

        <div class="nav-label" data-i18n="mainMenu">MAIN MENU</div>
        <nav class="nav">
            <a class="active" href="{{ route('admin.dashboard') }}">
                <span class="nav-icon">⌂</span><span data-i18n="dashboard">Dashboard</span>
            </a>
            <a href="{{ route('admin.profile.edit') }}">
                <span class="nav-icon">◎</span><span data-i18n="about">About</span>
            </a>
            <a href="{{ route('admin.contacts.index') }}">
                <span class="nav-icon">✉</span><span data-i18n="contact">Contact</span>
            </a>
            <a href="{{ route('admin.content.index', 'projects') }}">
                <span class="nav-icon">▧</span><span data-i18n="projects">Projects</span>
            </a>
            <a href="{{ route('admin.content.index', 'skills') }}">
                <span class="nav-icon">◇</span><span data-i18n="skills">Skills</span>
            </a>
            <a href="{{ route('admin.content.index', 'services') }}">
                <span class="nav-icon">◆</span><span data-i18n="services">Services</span>
            </a>
            <a href="{{ route('admin.content.index', 'educations') }}">
                <span class="nav-icon">▤</span><span data-i18n="education">Education</span>
            </a>
            <a href="{{ route('admin.content.index', 'experiences') }}">
                <span class="nav-icon">▣</span><span data-i18n="experience">Experience</span>
            </a>
            <a href="http://localhost:5173" target="_blank" rel="noreferrer">
                <span class="nav-icon">↗</span><span data-i18n="viewPortfolio">View Portfolio</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            Portfolio Management<br>
            <strong>Laravel {{ app()->version() }}</strong>
        </div>
    </aside>

    <section class="main">
        <header class="topbar">
            <div class="topbar-title">
                <small data-i18n="workspace">Admin workspace</small>
                <strong data-i18n="overview">Dashboard Overview</strong>
            </div>

            <div class="account">
                <div class="topbar-actions">
                    <button class="preference-button" id="theme-toggle" type="button" aria-label="Toggle theme">☀️</button>
                    <div class="language-picker" aria-label="Select language">
                        <button class="language-option" id="language-en" type="button">EN</button>
                        <button class="language-option" id="language-km" type="button">ខ្មែរ</button>
                    </div>
                </div>
                <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div class="account-copy">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span data-i18n="administrator">Administrator</span>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="logout" type="submit" data-i18n="logout">Logout</button>
                </form>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="notice">{{ session('success') }}</div>
            @endif

            <section class="hero">
                <div class="hero-copy">
                    <h1>
                        Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }},
                        {{ explode(' ', auth()->user()->name)[0] }} 
                    </h1>
                    <p data-i18n="heroText">Manage your portfolio content and follow the latest activity from one place.</p>
                </div>
                <a class="portfolio-link" href="http://localhost:5173" target="_blank" rel="noreferrer">
                    Open Portfolio ↗
                </a>
            </section>

            <section class="stats">
                @foreach($stats as $stat)
                    <article class="stat">
                        <span class="stat-icon {{ $stat['color'] }}">{{ strtoupper(substr($stat['label'], 0, 1)) }}</span>
                        <div>
                            <p data-stat="{{ strtolower($stat['label']) }}">{{ $stat['label'] }}</p>
                            <strong>{{ $stat['value'] }}</strong>
                        </div>
                    </article>
                @endforeach
            </section>

            <section class="dashboard-grid">
                <article class="panel">
                    <header class="panel-head">
                        <h2 data-i18n="recentProjects">Recent Projects</h2>
                        <span>{{ $recentProjects->count() }} latest projects</span>
                    </header>

                    @if($recentProjects->isEmpty())
                        <div class="empty">No projects have been added yet.</div>
                    @else
                        <div class="table-wrap">
                            <table>
                                <thead>
                                <tr>
                                    <th data-i18n="project">Project</th>
                                    <th data-i18n="status">Status</th>
                                    <th data-i18n="updated">Updated</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentProjects as $project)
                                    <tr>
                                        <td class="project-name">
                                            <strong>{{ $project->title }}</strong>
                                            <small>{{ $project->technology ?: 'No technology specified' }}</small>
                                        </td>
                                        <td><span class="badge">{{ ucfirst($project->status) }}</span></td>
                                        <td>{{ $project->updated_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </article>

                <article class="panel">
                    <header class="panel-head">
                        <h2 data-i18n="recentMessages">Recent Messages</h2>
                        <span>{{ $recentContacts->count() }} latest</span>
                    </header>

                    <div class="messages">
                        @forelse($recentContacts as $contact)
                            <div class="message">
                                <span class="message-avatar">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                                <div>
                                    <div class="message-top">
                                        <strong>{{ $contact->name }}</strong>
                                        <time>{{ $contact->created_at->diffForHumans() }}</time>
                                    </div>
                                    <p>{{ $contact->subject ?: $contact->message }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="empty">No visitor messages yet.</div>
                        @endforelse
                    </div>
                </article>
            </section>
        </main>
    </section>
</div>
<script>
    const dashboardTranslations = {
        en: {
            brand: 'Portfolio Admin', mainMenu: 'MAIN MENU', dashboard: 'Dashboard', about: 'About',
            contact: 'Contact', projects: 'Projects', skills: 'Skills', services: 'Services',
            education: 'Education', experience: 'Experience', viewPortfolio: 'View Portfolio',
            workspace: 'Admin workspace', overview: 'Dashboard Overview', administrator: 'Administrator',
            logout: 'Logout', heroText: 'Manage your portfolio content and follow the latest activity from one place.',
            recentProjects: 'Recent Projects', project: 'Project', status: 'Status', updated: 'Updated',
            recentMessages: 'Recent Messages', messages: 'Messages'
        },
        km: {
            brand: 'អ្នកគ្រប់គ្រង Portfolio', mainMenu: 'ម៉ឺនុយចម្បង', dashboard: 'ផ្ទាំងគ្រប់គ្រង', about: 'អំពីខ្ញុំ',
            contact: 'ទំនាក់ទំនង', projects: 'គម្រោង', skills: 'ជំនាញ', services: 'សេវាកម្ម',
            education: 'ការអប់រំ', experience: 'បទពិសោធន៍', viewPortfolio: 'មើល Portfolio',
            workspace: 'កន្លែងគ្រប់គ្រង', overview: 'ទិដ្ឋភាពទូទៅ', administrator: 'អ្នកគ្រប់គ្រង',
            logout: 'ចាកចេញ', heroText: 'គ្រប់គ្រងមាតិកា Portfolio និងមើលសកម្មភាពថ្មីៗនៅកន្លែងតែមួយ។',
            recentProjects: 'គម្រោងថ្មីៗ', project: 'គម្រោង', status: 'ស្ថានភាព', updated: 'បានកែប្រែ',
            recentMessages: 'សារថ្មីៗ', messages: 'សារ'
        }
    };

    const themeButton = document.getElementById('theme-toggle');
    const englishButton = document.getElementById('language-en');
    const khmerButton = document.getElementById('language-km');

    function renderPreferences() {
        const theme = document.documentElement.dataset.theme || 'dark';
        const language = document.documentElement.lang === 'km' ? 'km' : 'en';
        const words = dashboardTranslations[language];

        document.querySelectorAll('[data-i18n]').forEach((element) => {
            element.textContent = words[element.dataset.i18n] || element.textContent;
        });
        document.querySelectorAll('[data-stat]').forEach((element) => {
            element.textContent = words[element.dataset.stat] || element.textContent;
        });
        themeButton.textContent = theme === 'dark' ? '☀️' : '🌙';
        englishButton.classList.toggle('active', language === 'en');
        khmerButton.classList.toggle('active', language === 'km');
    }

    themeButton.addEventListener('click', () => {
        const theme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.dataset.theme = theme;
        localStorage.setItem('admin-theme', theme);
        renderPreferences();
    });

    function setLanguage(language) {
        document.documentElement.lang = language;
        localStorage.setItem('admin-language', language);
        renderPreferences();
    }

    englishButton.addEventListener('click', () => setLanguage('en'));
    khmerButton.addEventListener('click', () => setLanguage('km'));

    renderPreferences();
</script>
</body>
</html>
