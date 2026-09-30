@extends('layouts.app')

@section('content')
<div class="top" style="justify-content:flex-start">
    <a href="{{ route('tasks.index') }}" class="btn btn-edit">← Back to list</a>
</div>

<div class="glass detail {{ $task->is_done ? 'done' : '' }}">

    <div class="detail-head">
        <h2 class="detail-title">{{ $task->task }}</h2>
        <span class="status {{ $task->is_done ? 'st-done' : 'st-pending' }}">
            {{ $task->is_done ? '✅ Done' : '⏳ Pending' }}
        </span>
    </div>

    <div class="info-grid">
        <div class="info">
            <span class="k">📅 Date</span>
            <span class="v">{{ $task->date->format('D, d M Y') }}</span>
        </div>
        <div class="info">
            <span class="k">⏰ Time</span>
            <span class="v">{{ substr($task->time, 0, 5) }}</span>
        </div>
        <div class="info">
            <span class="k">🚩 Priority</span>
            <span class="v"><span class="badge p-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span></span>
        </div>
        <div class="info">
            <span class="k">🕒 Created</span>
            <span class="v">{{ $task->created_at->format('Y-m-d H:i') }}</span>
        </div>
    </div>

    <h3 class="section-title">📝 Note</h3>
    <div class="note big">
        {!! $task->note ?: '<p class="no-note">This task no note.</p>' !!}
    </div>

    <div class="detail-actions">
       <button type="button" class="btn btn-del"
        data-bs-toggle="modal" data-bs-target="#deleteModal"
        data-action="{{ route('tasks.destroy', $task) }}"
        data-name="{{ $task->task }}">🗑️ Delete</button>

        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-edit">✏️ Edit</a>

        
    </div>
</div>
@endsection