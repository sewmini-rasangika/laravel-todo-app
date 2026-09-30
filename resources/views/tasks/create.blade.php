@extends('layouts.app')
@section('content')
<div class="glass">
    <h2>➕ Add new task</h2>
    <form action="{{ route('tasks.store') }}" method="POST">
        @include('tasks._form')
    </form>
</div>
@endsection