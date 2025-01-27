<div class="card">
    <div class="card-header">
        <h2>إدارة المهام</h2>
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
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
                <tr wire:key="task-{{ $task->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <input type="text" class="form-control"
                               wire:model.live="titles.{{ $task->id }}"
                               wire:keyup.debounce.240="editField({{ $task->id }}, 'title', $event.target.value)">
                    </td>
                    <td>
                        <select class="form-select "
                                wire:model.live="states.{{ $task->id }}"
                                wire:change="editField({{ $task->id }}, 'state', $event.target.value)">
                            <option value="">اختر الحالة</option>
                            @foreach($tasksStates as $state)
                                <option value="{{ $state }}" @if($state == $task->$state) selected @endif>{{ $state }}</option>
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
                        <select class="form-select"
                                wire:model.live="office_ids.{{ $task->id }}"
                                wire:change="editField({{ $task->id }}, 'office_id', $event.target.value)">
                            <option value="">اختر المقر</option>
                            @foreach ($officesOptions as $office)
                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger" wire:click="deleteTask({{ $task->id }})">حذف</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>#</td>
                <td>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" placeholder="عنوان جديد">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <select class="form-select @error('state') is-invalid @enderror" wire:model="state">
                        <option value="">اختر الحالة</option>
                        @foreach($tasksStates as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                    @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control @error('notes') is-invalid @enderror" wire:model="notes" placeholder="ملاحظات">
                    @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <select class="form-select @error('office_id') is-invalid @enderror" wire:model="office_id">
                        <option value="">اختر المقر</option>
                        @foreach ($officesOptions as $office)
                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                        @endforeach
                    </select>
                    @error('office_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <button class="btn btn-primary" wire:click="saveTask">إضافة</button>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</div>
