@extends('layouts.app')
@section('content')
<div class="glass">
    <h2>✏️ edit task</h2>
    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @method('PUT')
        @include('tasks._form')
    </form>
</div>
@endsection