<div class="card">
    <div class="card-header  d-flex justify-content-right align-items-center gap-2">
        <h2>مهام المكتب</h2>
        <span wire:loading>
            <span class="spinner-border spinner-border-sm text-success" role="status"></span>
        </span>
    </div>

    <div class="card-body table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>العنوان</th>
                <th>الحالة</th>
                <th>الملاحظات</th>
                <th>المقر</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
                <tr wire:key="task-{{ $task->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->title }}</td>
                    <td>
                        <select class="form-select"
                                wire:model.live="states.{{ $task->id }}"
                                wire:change="editField({{ $task->id }}, 'state', $event.target.value)">
                            <option value="">اختر الحالة</option>
                            @foreach($tasksStates as $state)
                                <option value="{{ $state }}"
                                        @if($state == $task->state) selected @endif>{{ $state }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               wire:model.live="notesArr.{{ $task->id }}"
                               wire:keyup.debounce.240="editField({{ $task->id }}, 'notes', $event.target.value)"
                               placeholder="-">
                    </td>
                    <td>
                        <select class="form-select" disabled>
                            <option>{{ $task->office->name }}</option>
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
