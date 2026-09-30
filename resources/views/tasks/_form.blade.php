@csrf
<label>Task</label>
<input  type="text" name="task" value="{{ old('task', $task->task ?? '') }}" placeholder="Ex : Complete the assignment." required>
@error('task')<div class="error">{{ $message }}</div>@enderror

<div class="form-row">
    <div>
        <label>Date</label>
        <input type="date" name="date" value="{{ old('date', isset($task) ? $task->date->format('Y-m-d') : '') }}">
        @error('date')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div>
        <label>Time</label>
        <input type="time" name="time" value="{{ old('time', isset($task) ? substr($task->time, 0, 5) : '') }}">
        @error('time')<div class="error">{{ $message }}</div>@enderror
    </div>
</div>

<label>Priority</label>
<select name="priority">
    @foreach(['high' => '🔴 High', 'medium' => '🟡 Medium', 'low' => '🟢 Low'] as $value => $label)
        <option value="{{ $value }}"
            {{ old('priority', $task->priority ?? 'medium') === $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
@error('priority')<div class="error">{{ $message }}</div>@enderror

<label>Note</label>
<div id="editor"></div>
<input type="hidden" name="note" id="note">

<br>
<button type="submit" class="btn btn-primary">💾 Save</button>
<a href="{{ route('tasks.index') }}" class="btn btn-edit">Cancel</a>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'write note here...',
        modules: { toolbar: [['bold','italic','underline'], [{list:'ordered'},{list:'bullet'}], ['link']] }
    });
    quill.root.innerHTML = @json(old('note', $task->note ?? ''));
    document.querySelector('form').addEventListener('submit', () => {
        document.getElementById('note').value = quill.root.innerHTML;
    });
</script>