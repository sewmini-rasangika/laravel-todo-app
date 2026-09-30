<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private const ALLOWED = '<p><br><b><strong><i><em><u><ul><ol><li><h1><h2><h3><a>';

    private function rules(): array
    {
        return [
            'task' => 'required|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'priority' => 'required|in:high,medium,low',
            'note' => 'nullable|string',
        ];
    }
    public function index(Request $request)
{
  
    $counts = [
        'all'     => Task::count(),
        'pending' => Task::where('is_done', false)->count(),
        'done'    => Task::where('is_done', true)->count(),
    ];

    $query = Task::query();

    if ($request->filled('search')) {
        $s = $request->search;
        $query->where(function ($q) use ($s) {
            $q->where('task', 'like', "%{$s}%")
              ->orWhere('note', 'like', "%{$s}%");
        });
    }

   
    if ($request->status === 'done') {
        $query->where('is_done', true);
    } elseif ($request->status === 'pending') {
        $query->where('is_done', false);
    }

    
    if (in_array($request->priority, ['high', 'medium', 'low'])) {
        $query->where('priority', $request->priority);
    }

    
    if ($request->when === 'today') {
        $query->whereDate('date', today());
    } elseif ($request->when === 'overdue') {
        $query->where('is_done', false)->whereDate('date', '<', today());
    } elseif ($request->when === 'upcoming') {
        $query->whereDate('date', '>', today());
    }

    
    switch ($request->sort) {
        case 'date_asc':
            $query->orderBy('date')->orderBy('time');
            break;
        case 'date_desc':
            $query->orderByDesc('date')->orderByDesc('time');
            break;
        case 'newest':
            $query->orderByDesc('created_at');
            break;
        default: 
            $query->orderBy('is_done')
                  ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                  ->orderBy('date')->orderBy('time');
    }

    $tasks = $query->paginate(10)->withQueryString();

    return view('tasks.index', compact('tasks', 'counts'));
}

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['note'] = strip_tags($data['note'] ?? '', self::ALLOWED);
        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task added! 🎉');
    }

    public function show(Task $task)
{
    return view('tasks.show', compact('task'));
}

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate($this->rules());
        $data['note'] = strip_tags($data['note'] ?? '', self::ALLOWED);
        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully! ✏️');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Deleted the Task 🗑️');
    }

    public function toggle(Task $task)
    {
        $task->update(['is_done' => !$task->is_done]);
        return back();
    }
}