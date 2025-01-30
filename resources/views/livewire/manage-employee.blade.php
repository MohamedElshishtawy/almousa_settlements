<div class="container mt-5" dir="rtl">

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- First row: Name and Phone -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" id="name" class="form-control" wire:model="name" placeholder="أكتب هنا">
                @error('employee.name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="phone" class="form-label">الهاتف</label>
                <input type="text" id="phone" class="form-control" wire:model="phone" placeholder="أكتب هنا">
                @error('employee.phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">الباسورد</label>
                <input type="text" id="password" class="form-control" wire:model="password"
                       placeholder="{{$employee->exists() ? 'اكتب الباسورد الجديد' : 'أكتب هنا'}}">
                @error('employee.password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Second row: Rank and Office -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="rank" class="form-label">الرتبة</label>
                <input type="text" id="rank" class="form-control" wire:model="rank" placeholder="أكتب هنا">
                @error('employee.rank') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="office_id" class="form-label">المقر</label>
                <select id="office_id" class="form-select" wire:model="office_id">
                    <option value="">اختر المقر</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                    @endforeach
                </select>
                @error('office_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Submit button -->
        <div class="row mt-5">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary w-100">
                    {{ $employee->exists ? 'تحديث الموظف' : 'إضافة الموظف' }}
                </button>
            </div>
        </div>
    </form>
</div>
