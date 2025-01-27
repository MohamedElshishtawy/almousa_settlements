<div class="card">
    <div class="card-header d-flex justify-content-right align-items-center">
        <h2>إدارة غياب الوفد</h2>
        <span wire:loading>
            <span class="spinner-border spinner-border-sm text-success" role="status"></span>
        </span>
    </div>

    <div class="card-body table-responsive">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th>التسلسل</th>
                <th>اسم المندوب</th>
                <th>تاريخ الغياب</th>
                <th>الوجبة</th>
                <th>عدد الوجبات</th>
                <th>طباعة</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach($delegateAbsences as $absence)
                <tr wire:key="absence-{{ $absence->id }}">
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration) }}</td>
                    <td>{{ $absence->delegate->name }}</td>
                    <td>{{ $absence->for_date }}</td>
                    <td>{{ $absence->meal->name }}</td>
                    <td>{{ $absence->delegate->benefits }}</td>
                    <td>
                        <a href="{{ route('delegate-absence.print', $absence->id) }}" class="btn btn-secondary">طباعة</a>
                    </td>
                    <td>
                        <button class="btn btn-danger" wire:click="delete({{ $absence->id }})">حذف</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>#</td>
                <td>
                    <select wire:model="delegate_id" class="form-select @error('delegate_id') is-invalid @enderror">
                        <option value="">اختر المندوب</option>
                        @foreach($delegates as $delegate)
                            <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                        @endforeach
                    </select>
                    @error('delegate_id') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <input type="date" wire:model="for_date" class="form-control @error('for_date') is-invalid @enderror">
                    @error('for_date') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <select wire:model="meal_id" class="form-select @error('meal_id') is-invalid @enderror">
                        <option value="">اختر الوجبة</option>
                        @foreach($meals as $meal)
                            <option value="{{ $meal->id }}">{{ $meal->name }}</option>
                        @endforeach
                    </select>
                    @error('meal_id') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td colspan="3">
                    <button class="btn btn-primary" wire:click="save">إضافة</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
