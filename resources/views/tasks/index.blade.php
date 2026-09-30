@extends('layouts.app')
@section('content')

<div class="stats">
    <div class="stat">
        <span class="num">{{ $counts['all'] }}</span>
        <span class="lbl">Total</span>
    </div>
    <div class="stat pending">
        <span class="num">{{ $counts['pending'] }}</span>
        <span class="lbl">Pending</span>
    </div>
    <div class="stat done">
        <span class="num">{{ $counts['done'] }}</span>
        <span class="lbl">Done</span>
    </div>
</div>
<div class="top">
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">➕ New Task</a>
</div>


            <form action="{{ route('tasks.index') }}" method="GET" class="glass filter-box">
    <div class="filter-top">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="🔍 Find task and note...">
        <button class="btn btn-primary">Search</button>
    </div>

    <div class="filter-selects">
        <select name="priority" onchange="this.form.submit()">
            <option value="">All priorities</option>
            <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>🔴 High</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
            <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>🟢 Low</option>
        </select>

        <select name="when" onchange="this.form.submit()">
            <option value="">Any date</option>
            <option value="today"    {{ request('when') === 'today'    ? 'selected' : '' }}>📅 Today</option>
            <option value="overdue"  {{ request('when') === 'overdue'  ? 'selected' : '' }}>⚠️ Overdue</option>
            <option value="upcoming" {{ request('when') === 'upcoming' ? 'selected' : '' }}>🔜 Upcoming</option>
        </select>

        <select name="sort" onchange="this.form.submit()">
            <option value="">Smart order</option>
            <option value="date_asc"  {{ request('sort') === 'date_asc'  ? 'selected' : '' }}>Date: earliest first</option>
            <option value="date_desc" {{ request('sort') === 'date_desc' ? 'selected' : '' }}>Date: latest first</option>
            <option value="newest"    {{ request('sort') === 'newest'    ? 'selected' : '' }}>Newly added</option>
        </select>

        @if(request()->hasAny(['search', 'priority', 'when', 'sort']))
            <a href="{{ route('tasks.index', array_filter(['status' => request('status')])) }}"
               class="btn btn-edit">✖ Clear</a>
        @endif
    </div>

    @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
</form>

<div class="tabs">
    <a href="{{ request()->fullUrlWithQuery(['page' => null,'status' => null]) }}"
       class="tab {{ !request('status') ? 'active' : '' }}">All</a>
    <a href="{{ request()->fullUrlWithQuery(['page' => null,'status' => 'pending']) }}"
       class="tab {{ request('status') === 'pending' ? 'active' : '' }}">⏳ Pending</a>
    <a href="{{ request()->fullUrlWithQuery(['status' => 'done', 'page' => null]) }}"
       class="tab {{ request('status') === 'done' ? 'active' : '' }}">✅ Done</a>
</div>
@forelse($tasks as $task)
    <div class="glass task-item {{ $task->is_done ? 'done' : '' }}">

        
          <div class="task-row" onclick="toggleDetails(event, this)">


            <div class="grow">
                <div class="title">{{ $task->task }}</div>
                <div class="meta">
                    <span class="badge">📅 {{ $task->date->format('Y-m-d') }}</span>
                    <span class="badge">⏰ {{ substr($task->time, 0, 5) }}</span>
                    <span class="badge p-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                </div>
            </div>

            <div class="actions" >
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-view">View</a>
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-edit">Edit</a>
                <button type="button" class="btn btn-del"
                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-action="{{ route('tasks.destroy', $task) }}"
                    data-name="{{ $task->task }}">Delete</button>
            </div>

            <span class="arrow">▾</span>
        </div>

       
        <div class="task-details">
            @if($task->note)
                <div class="note">{!! $task->note !!}</div>
            @else
                <p class="no-note">This task no note.</p>
            @endif
            <a href="{{ route('tasks.show', $task) }}" class="more-link">View full details →</a>
        </div>
    </div>



    @empty
    <div class="glass empty">
        @if(request()->hasAny(['search', 'priority', 'when', 'status']))
            no matching tasks found 🔎<br>changing the filter.
        @else
            no tasks yet. 🌱<br>Add one using the button above!
        @endif
    </div>
@endforelse


@if($tasks->hasPages())
    <div class="glass pager">
        {{ $tasks->onEachSide(1)->links() }}
    </div>
@endif
<script src="{{ asset('js/app.js') }}"></script>

@endsection