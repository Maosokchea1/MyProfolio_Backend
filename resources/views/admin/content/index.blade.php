<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>{{ $config['title'] }} | Portfolio Admin</title>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --page: #f6f7fb;
            --surface: #fff;
            --text: #172033;
            --muted: #6b7280;
            --line: #e8eaf0;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--text);
            background: var(--page);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        a { color: inherit; text-decoration: none; }
        button, input, textarea { font: inherit; }

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

        .dashboard-link {
            padding: 10px 14px;
            border: 1px solid var(--line);
            border-radius: 10px;
            color: #4f46e5;
            background: #fff;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .dashboard-link:hover { border-color: #c7d2fe; background: #eef2ff; }

        .content {
            width: min(1580px, 100%);
            margin: 0 auto;
            padding: 30px 34px 44px;
        }

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .page-heading h1 { margin: 0; font-size: 29px; letter-spacing: -.02em; }
        .page-heading p { margin: 7px 0 0; color: var(--muted); }

        .counter {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 14px;
            border: 1px solid #e0e7ff;
            border-radius: 12px;
            color: #4338ca;
            background: #eef2ff;
            font-size: 13px;
            font-weight: 700;
        }

        .counter span {
            display: grid;
            width: 24px;
            height: 24px;
            place-items: center;
            border-radius: 8px;
            color: #fff;
            background: #4f46e5;
        }

        .notice, .errors {
            margin-bottom: 20px;
            padding: 14px 17px;
            border-radius: 12px;
            font-size: 13px;
        }

        .notice { border: 1px solid #a7f3d0; color: #047857; background: #ecfdf5; }
        .errors { border: 1px solid #fecaca; color: #b91c1c; background: #fef2f2; }
        .errors ul { margin: 8px 0 0; padding-left: 20px; }

        .workspace {
            display: grid;
            grid-template-columns: minmax(320px, 400px) minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .panel {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: 0 8px 25px #1118270a;
        }

        .editor { position: sticky; top: 102px; }

        .panel-head {
            display: flex;
            min-height: 65px;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 0 22px;
            border-bottom: 1px solid #eef0f4;
        }

        .panel-head h2 { margin: 0; font-size: 16px; }
        .panel-head p { margin: 4px 0 0; color: var(--muted); font-size: 11px; }

        .mode {
            padding: 6px 9px;
            border-radius: 99px;
            color: {{ $editing ? '#b45309' : '#047857' }};
            background: {{ $editing ? '#fef3c7' : '#ecfdf5' }};
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .form { display: grid; gap: 17px; padding: 22px; }
        .field label { display: block; margin-bottom: 7px; font-size: 12px; font-weight: 750; }

        .required { color: #ef4444; }

        .input {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #dce1e9;
            border-radius: 10px;
            color: var(--text);
            background: #fff;
            outline: none;
            transition: .2s;
        }

        .input::placeholder { color: #b1b8c4; }

        .input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 4px #6366f119;
        }

        textarea.input { min-height: 105px; resize: vertical; line-height: 1.55; }

        .check-card {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 13px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            color: #374151;
            background: #f9fafb;
            cursor: pointer;
        }

        .check-card input { width: 18px; height: 18px; accent-color: var(--primary); }

        .form-actions { display: flex; gap: 10px; padding-top: 3px; }

        .btn {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 16px;
            border: 0;
            border-radius: 10px;
            color: #fff;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            font-size: 13px;
            font-weight: 750;
            cursor: pointer;
            box-shadow: 0 8px 18px #4f46e528;
            transition: .2s;
        }

        .btn:hover { transform: translateY(-1px); box-shadow: 0 11px 22px #4f46e538; }
        .btn.secondary { color: #475569; background: #eef1f5; box-shadow: none; }
        .btn.secondary:hover { background: #e2e8f0; }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 690px; }

        th, td {
            padding: 15px 18px;
            border-bottom: 1px solid #f0f2f6;
            text-align: left;
            font-size: 13px;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: 0; }
        tbody tr { transition: .15s; }
        tbody tr:hover { background: #fafaff; }

        th {
            color: #94a3b8;
            background: #fbfcfe;
            font-size: 10px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        td:first-child { font-weight: 700; color: #293247; }

        .level {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .level-track {
            width: 65px;
            height: 6px;
            overflow: hidden;
            border-radius: 99px;
            background: #e5e7eb;
        }

        .level-fill { height: 100%; border-radius: inherit; background: linear-gradient(90deg, #4f46e5, #818cf8); }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 99px;
            color: #047857;
            background: #ecfdf5;
            font-size: 10px;
            font-weight: 800;
        }

        .row-actions { display: flex; gap: 7px; align-items: center; }

        .edit, .delete {
            display: inline-flex;
            min-height: 32px;
            align-items: center;
            padding: 0 10px;
            border: 0;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 750;
            cursor: pointer;
        }

        .edit { color: #4338ca; background: #eef2ff; }
        .edit:hover { background: #e0e7ff; }
        .delete { color: #dc2626; background: #fef2f2; }
        .delete:hover { background: #fee2e2; }

        .empty {
            padding: 60px 25px;
            color: #94a3b8;
            text-align: center;
        }

        .empty-icon { display: block; margin-bottom: 10px; font-size: 35px; opacity: .7; }

        .education-list { display: grid; gap: 16px; padding: 20px; }
        .education-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 20px;
            padding: 24px;
            border: 1px solid #1e293b;
            border-radius: 20px;
            color: #fff;
            background: #0f172aeF;
            box-shadow: 0 14px 35px #02061726;
            transition: .25s ease;
        }
        .education-card:hover { border-color: #4f46e5; transform: translateY(-2px); }
        .education-card h3 { margin: 0; font-size: 19px; }
        .education-school { margin: 5px 0 0; color: #818cf8; font-weight: 700; }
        .education-field { margin: 5px 0 0; color: #a5b4fc; font-size: 12px; text-transform: uppercase; letter-spacing: .08em; }
        .education-level { display: inline-flex; margin-top: 12px; padding: 6px 10px; border-radius: 999px; color: #c7d2fe; background: #4f46e533; font-size: 11px; font-weight: 800; }
        .education-description { margin: 15px 0 0; color: #cbd5e1; line-height: 1.7; }
        .education-side { display: flex; flex-direction: column; align-items: flex-end; gap: 16px; }
        .education-period { padding: 8px 11px; border: 1px solid #334155; border-radius: 11px; color: #cbd5e1; background: #1e293b80; font-size: 12px; white-space: nowrap; }

        @media (max-width: 650px) {
            .education-card { grid-template-columns: 1fr; }
            .education-side { align-items: flex-start; }
        }

        @media (max-width: 1120px) {
            .workspace { grid-template-columns: 1fr; }
            .editor { position: static; }
            .form { grid-template-columns: repeat(2, 1fr); }
            .field.wide, .form-actions { grid-column: 1 / -1; }
        }

        @media (max-width: 850px) {
            .app { grid-template-columns: 86px minmax(0, 1fr); }
            .sidebar { padding-inline: 12px; }
            .brand { justify-content: center; padding-inline: 0; font-size: 0; }
            .nav-label, .sidebar-footer { display: none; }
            .nav a { justify-content: center; padding: 12px; font-size: 0; }
            .nav-icon { font-size: 18px; }
        }

        @media (max-width: 650px) {
            .app { display: block; }
            .sidebar { position: static; display: block; width: 100%; height: auto; padding: 12px; }
            .brand { display: none; }
            .nav { display: flex; overflow-x: auto; }
            .nav a { flex: 0 0 auto; margin: 0 3px; }
            .topbar { min-height: 68px; padding: 0 16px; }
            .content { padding: 22px 14px 34px; }
            .page-heading { align-items: flex-start; flex-direction: column; }
            .form { grid-template-columns: 1fr; }
            .field.wide, .form-actions { grid-column: auto; }
            .dashboard-link { padding: 9px 11px; font-size: 11px; }
        }
    </style>
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Portfolio logo">
            <span>Portfolio Admin</span>
        </a>

        <div class="nav-label">MAIN MENU</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}">
                <span class="nav-icon">⌂</span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.profile.edit') }}">
                <span class="nav-icon">◎</span><span>About</span>
            </a>
            <a href="{{ route('admin.contacts.index') }}">
                <span class="nav-icon">✉</span><span>Contact</span>
            </a>
            <a class="{{ $type === 'projects' ? 'active' : '' }}" href="{{ route('admin.content.index', 'projects') }}">
                <span class="nav-icon">▧</span><span>Projects</span>
            </a>
            <a class="{{ $type === 'skills' ? 'active' : '' }}" href="{{ route('admin.content.index', 'skills') }}">
                <span class="nav-icon">◇</span><span>Skills</span>
            </a>
            <a class="{{ $type === 'services' ? 'active' : '' }}" href="{{ route('admin.content.index', 'services') }}">
                <span class="nav-icon">◆</span><span>Services</span>
            </a>
            <a class="{{ $type === 'educations' ? 'active' : '' }}" href="{{ route('admin.content.index', 'educations') }}">
                <span class="nav-icon">▤</span><span>Education</span>
            </a>
            <a class="{{ $type === 'experiences' ? 'active' : '' }}" href="{{ route('admin.content.index', 'experiences') }}">
                <span class="nav-icon">▣</span><span>Experience</span>
            </a>
            <a href="http://localhost:5173" target="_blank" rel="noreferrer">
                <span class="nav-icon">↗</span><span>View Portfolio</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            Portfolio Management<br>
            <strong>Content workspace</strong>
        </div>
    </aside>

    <section class="main">
        <header class="topbar">
            <div class="topbar-title">
                <small>Content management</small>
                <strong>{{ $config['title'] }}</strong>
            </div>
            <a class="dashboard-link" href="{{ route('admin.dashboard') }}">← Dashboard</a>
        </header>

        <main class="content">
            <header class="page-heading">
                <div>
                    <h1>Manage {{ $config['title'] }}</h1>
                    <p>Add, update and organize your portfolio {{ strtolower($config['title']) }}.</p>
                </div>
                <div class="counter"><span>{{ $items->count() }}</span> Total {{ $config['title'] }}</div>
            </header>

            @if(session('success'))
                <div class="notice">✓ {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="errors">
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="workspace">
                <section class="panel editor">
                    <header class="panel-head">
                        <div>
                            <h2>{{ $editing ? 'Edit '.$config['singular'] : 'Add New '.$config['singular'] }}</h2>
                            <p>{{ $editing ? 'Update the selected item' : 'Complete the information below' }}</p>
                        </div>
                        <span class="mode">{{ $editing ? 'Editing' : 'New item' }}</span>
                    </header>

                    <form class="form" method="POST" action="{{ $editing ? route('admin.content.update', [$type, $editing->id]) : route('admin.content.store', $type) }}">
                        @csrf
                        @if($editing) @method('PUT') @endif

                        @foreach($config['fields'] as $field)
                            @php
                                $fieldType = $field['type'] ?? 'text';
                                $rawValue = old($field['name'], $editing?->{$field['name']});
                                $value = $rawValue instanceof \Carbon\CarbonInterface ? $rawValue->format('Y-m-d') : $rawValue;
                            @endphp

                            <div class="field {{ ($field['wide'] ?? false) ? 'wide' : '' }}">
                                @if($fieldType === 'checkbox')
                                    <label class="check-card">
                                        <input type="checkbox" name="{{ $field['name'] }}" value="1" @checked(old($field['name'], $editing ? $editing->{$field['name']} : ($field['default'] ?? false)))>
                                        <span>{{ $field['label'] }}</span>
                                    </label>
                                @else
                                    <label for="{{ $field['name'] }}">
                                        {{ $field['label'] }}
                                        @if($field['required'] ?? false)<span class="required">*</span>@endif
                                    </label>

                                    @if($fieldType === 'textarea')
                                        <textarea class="input" id="{{ $field['name'] }}" name="{{ $field['name'] }}" placeholder="Enter {{ strtolower($field['label']) }}">{{ $value }}</textarea>
                                    @elseif($fieldType === 'select')
                                        <select class="input" id="{{ $field['name'] }}" name="{{ $field['name'] }}" @required($field['required'] ?? false)>
                                            @foreach($field['options'] as $optionValue => $optionLabel)
                                                <option value="{{ $optionValue }}" @selected($value === $optionValue)>{{ $optionLabel }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input
                                            class="input"
                                            id="{{ $field['name'] }}"
                                            name="{{ $field['name'] }}"
                                            type="{{ $fieldType }}"
                                            value="{{ $value }}"
                                            placeholder="Enter {{ strtolower($field['label']) }}"
                                            @required($field['required'] ?? false)
                                            @if(isset($field['min'])) min="{{ $field['min'] }}" @endif
                                            @if(isset($field['max'])) max="{{ $field['max'] }}" @endif
                                        >
                                    @endif
                                @endif
                            </div>
                        @endforeach

                        <div class="form-actions">
                            <button class="btn" type="submit">
                                {{ $editing ? '✓ Save Changes' : '+ Add '.$config['singular'] }}
                            </button>
                            @if($editing)
                                <a class="btn secondary" href="{{ route('admin.content.index', $type) }}">Cancel</a>
                            @endif
                        </div>
                    </form>
                </section>

                <section class="panel">
                    <header class="panel-head">
                        <div>
                            <h2>All {{ $config['title'] }}</h2>
                            <p>Your current portfolio content</p>
                        </div>
                    </header>

                    @if($items->isEmpty())
                        <div class="empty">
                            <span class="empty-icon">◇</span>
                            No {{ strtolower($config['title']) }} added yet.<br>
                            Use the form to add your first item.
                        </div>
                    @elseif($type === 'educations')
                        <div class="education-list">
                            @foreach($items as $item)
                                <article class="education-card">
                                    <div>
                                        <h3>{{ $item->degree ?: $item->field ?: 'Education' }}</h3>
                                        <p class="education-school">{{ $item->school_name }}</p>
                                        @if($item->field && $item->field !== $item->degree)
                                            <p class="education-field">{{ $item->field }}</p>
                                        @endif
                                        @if($item->level)
                                            <span class="education-level">{{ match($item->level) {
                                                'primary' => 'Primary School',
                                                'secondary' => 'Secondary School',
                                                'highschool' => 'High School',
                                                'university' => 'University',
                                                default => ucfirst($item->level),
                                            } }}</span>
                                        @endif
                                        @if($item->description)
                                            <p class="education-description">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                    <div class="education-side">
                                        <span class="education-period">
                                            {{ $item->start_year ?: '—' }} – {{ $item->end_year ?: 'Present' }}
                                        </span>
                                        <div class="row-actions">
                                            <a class="edit" href="{{ route('admin.content.index', [$type, 'edit' => $item->id]) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.content.destroy', [$type, $item->id]) }}" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="delete" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="table-wrap">
                            <table>
                                <thead>
                                <tr>
                                    @foreach($config['columns'] as $label)<th>{{ $label }}</th>@endforeach
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        @foreach($config['columns'] as $key => $label)
                                            <td>
                                                @if($type === 'projects' && $key === 'status')
                                                    <span class="badge">{{ ucfirst($item->status) }}</span>
                                                @elseif($type === 'projects' && $key === 'featured')
                                                    {{ $item->featured ? 'Yes' : 'No' }}
                                                @elseif($type === 'skills' && $key === 'percentage')
                                                    <div class="level">
                                                        <div class="level-track"><div class="level-fill" style="width: {{ $item->percentage }}%"></div></div>
                                                        <span>{{ $item->percentage }}%</span>
                                                    </div>
                                                @elseif($type === 'educations' && $key === 'start_year')
                                                    {{ $item->start_year ?: '—' }} – {{ $item->end_year ?: 'Present' }}
                                                @elseif($type === 'experiences' && $key === 'start_date')
                                                    {{ $item->start_date?->format('M Y') ?: '—' }} – {{ $item->currently_working ? 'Present' : ($item->end_date?->format('M Y') ?: '—') }}
                                                @elseif($type === 'experiences' && $key === 'currently_working')
                                                    <span class="badge">{{ $item->currently_working ? 'Current' : 'Completed' }}</span>
                                                @elseif($type === 'services' && $key === 'active')
                                                    <span class="badge">{{ $item->active ? 'Active' : 'Hidden' }}</span>
                                                @else
                                                    {{ $item->{$key} ?: '—' }}
                                                @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            <div class="row-actions">
                                                <a class="edit" href="{{ route('admin.content.index', [$type, 'edit' => $item->id]) }}">Edit</a>
                                                <form method="POST" action="{{ route('admin.content.destroy', [$type, $item->id]) }}" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="delete" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </section>
</div>
<script src="{{ asset('js/admin-preferences.js') }}"></script>
</body>
</html>
