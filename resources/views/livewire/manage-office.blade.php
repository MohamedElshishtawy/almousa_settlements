<div class="container mt-5" dir="rtl">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- First row: Office Name and Start Date -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="name" class="form-label">اسم المقر</label>
                <input type="text" id="name" class="form-control" wire:model="name" placeholder="أكتب هنا">
                @error('office.name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="living_id" class="form-label">المعايش</label>
                <select id="living_id" class="form-select" wire:model.defer="living_id">
                    <option value="">اختر المسكن</option>
                    @foreach ($livings as $living)
                        <option value="{{ $living->id }}">{{ $living->title }}</option>
                    @endforeach
                </select>
                @error('office.living_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="mission_id" class="form-label">المهمة</label>
                <select id="mission_id" class="form-select" wire:model.defer="mission_id">
                    <option value="">اختر المهمة</option>
                    @foreach ($missions as $mission)
                        <option value="{{ $mission->id }}">{{ $mission->title }}</option>
                    @endforeach
                </select>
                @error('office.mission_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="start_date" class="form-label">تاريخ البدء</label>
                <input type="date" id="start_date" class="form-control" wire:model.defer="start_date" placeholder="أكتب هنا">
                @error('office.start_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="end_date" class="form-label">تاريخ الانتهاء</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="end_date" placeholder="أكتب هنا">
                @error('office.end_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Submit button -->
        <div class="row">
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary w-100">
                    {{ $office->exists ? 'تحديث المقر' : 'إضافة المقر' }}
                </button>
            </div>
        </div>
    </form>
</div>
