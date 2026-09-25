@extends('layouts.app')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand" href="/">
            <span class="brand-mark"><span></span><span></span><span></span></span>
            
        </a>
        <div class="sidebar-label">Workspace</div>
        <nav class="sidebar-nav">
            <a class="nav-link active" href="/"><span class="nav-icon">▦</span> My tasks <span class="nav-count">{{ $stats['total'] }}</span></a>
        </nav>
        <div class="sidebar-bottom">
            <div class="quote">“Great things are done by a series of small things brought together.”</div>
            <div class="profile"><div class="avatar">JS</div><div><strong>Jasmine</strong><small>Personal workspace</small></div><span class="profile-more">•••</span></div>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div><p class="eyebrow">{{ now()->format('l, F j, Y') }}</p><h1>Good morning, Jasmine <span>✦</span></h1></div>
            <button class="circle-button" type="button" aria-label="Notifications">♧<i></i></button>
        </header>

        @if (session('success'))
            <div class="flash">{{ session('success') }} <button onclick="this.parentElement.remove()" aria-label="Dismiss">×</button></div>
        @endif
        @if ($errors->any())
            <div class="flash error">{{ $errors->first() }} <button onclick="this.parentElement.remove()" aria-label="Dismiss">×</button></div>
        @endif

        <section class="welcome-panel">
            <div><p class="eyebrow light">YOUR FOCUS TODAY</p><h2>Do all the task<br><em>you love.</em></h2><p class="panel-copy">Small steps add up. Keep your momentum going.</p></div>
            <div class="panel-orbit"><div class="orbit-dot"></div><strong>{{ $stats['completed'] }}</strong><span>completed<br>tasks</span></div>
        </section>

        <section class="stats-grid" aria-label="Task summary">
            <div class="stat-card"><span class="stat-icon teal">⌁</span><div><strong>{{ $stats['total'] }}</strong><span>Total tasks</span></div></div>
            <div class="stat-card"><span class="stat-icon pink">◷</span><div><strong>{{ $stats['pending'] }}</strong><span>In progress</span></div></div>
            <div class="stat-card"><span class="stat-icon blue">✓</span><div><strong>{{ $stats['completed'] }}</strong><span>Completed</span></div></div>
        </section>

        <div class="content-grid">
            <section class="tasks-section">
                <div class="section-heading"><div><h2>Your tasks</h2><p>Stay on top of the things that matter.</p></div><button class="primary-button" type="button" onclick="openModal('create-modal')"><span>+</span> New task</button></div>
                <div class="task-list">
                    @forelse ($tasks as $task)
                        <article class="task-row {{ $task->status === 'completed' ? 'is-complete' : '' }}">
                            <form method="POST" action="/tasks/{{ $task->id }}/toggle">@csrf @method('PATCH')<button class="check-button" type="submit" aria-label="Mark task {{ $task->status === 'completed' ? 'pending' : 'completed' }}"></button></form>
                            <div class="task-body"><h3>{{ $task->title }}</h3>@if($task->description)<p>{{ $task->description }}</p>@endif<div class="task-meta"><span class="status {{ $task->status }}">{{ ucfirst($task->status) }}</span>@if($task->due_date)<span>Due {{ $task->due_date->format('M j, Y') }}</span>@endif</div></div>
                            <div class="task-actions"><button type="button" class="icon-button" onclick='openEdit(@json($task))' aria-label="Edit task">✎</button><form method="POST" action="/tasks/{{ $task->id }}" onsubmit="return confirm('Delete this task?')">@csrf @method('DELETE')<button class="icon-button danger" type="submit" aria-label="Delete task">⌫</button></form></div>
                        </article>
                    @empty
                        <div class="empty-state"><div class="empty-icon">✦</div><h3>Your list is clear</h3><p>Add your first task and make today count.</p><button class="primary-button" type="button" onclick="openModal('create-modal')">Add a task</button></div>
                    @endforelse
                </div>
            </section>

            <aside class="quick-add"><div class="quick-header"><h2>Quick add</h2><span>✧</span></div><p>Capture it before it slips away.</p><form method="POST" action="/tasks">@csrf<input name="title" placeholder="What needs doing?" required maxlength="120"><input type="hidden" name="status" value="pending"><button class="quick-submit" type="submit">Add task <span>→</span></button></form><div class="tip"><strong>Tip of the day</strong><p>Break bigger tasks into smaller, achievable steps.</p></div></aside>
        </div>
    </main>
</div>

<div class="modal-backdrop" id="create-modal"><div class="modal"><button class="modal-close" type="button" onclick="closeModal('create-modal')">×</button><p class="eyebrow">NEW TASK</p><h2>What will you accomplish?</h2><form method="POST" action="/tasks">@csrf @include('tasks.form', ['task' => null])<button class="primary-button full" type="submit">Create task</button></form></div></div>
<div class="modal-backdrop" id="edit-modal"><div class="modal"><button class="modal-close" type="button" onclick="closeModal('edit-modal')">×</button><p class="eyebrow">EDIT TASK</p><h2>Keep it moving.</h2><form id="edit-form" method="POST">@csrf @method('PUT') @include('tasks.form', ['task' => null])<button class="primary-button full" type="submit">Save changes</button></form></div></div>
<script>function openModal(id){document.getElementById(id).classList.add('open')}function closeModal(id){document.getElementById(id).classList.remove('open')}function openEdit(task){const form=document.getElementById('edit-form');form.action='/tasks/'+task.id;form.querySelector('[name=title]').value=task.title;form.querySelector('[name=description]').value=task.description||'';form.querySelector('[name=status]').value=task.status;form.querySelector('[name=due_date]').value=task.due_date||'';openModal('edit-modal')}document.querySelectorAll('.modal-backdrop').forEach(m=>m.addEventListener('click',e=>{if(e.target===m)closeModal(m.id)}));@if ($errors->any())
openModal('create-modal')@endif</script>
@endsection