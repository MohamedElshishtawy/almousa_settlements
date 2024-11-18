<div class="container mt-5" dir="rtl">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- First row: Office Name -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="name" class="form-label">اسم المقر</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="أكتب هنا">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Living and Mission -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="living_id" class="form-label">نوع الإعاشة</label>
                <select id="living_id" class="form-select @error('living_id') is-invalid @enderror" wire:model="living_id">
                    <option value="">اختر نوع الإعاشة</option>
                    @foreach ($livings as $living)
                        <option value="{{ $living->id }}">{{ $living->title }}</option>
                    @endforeach
                </select>
                @error('living_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="mission_id" class="form-label">المهمة</label>
                <select id="mission_id" class="form-select @error('mission_id') is-invalid @enderror" wire:model="mission_id">
                    <option value="">اختر المهمة</option>
                    @foreach ($missions as $mission)
                        <option value="{{ $mission->id }}">{{ $mission->title }}</option>
                    @endforeach
                </select>
                @error('mission_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Preparation Dates -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="getting_ready_start_date" class="form-label">تاريخ بدء التجهيز</label>
                <input type="date" id="getting_ready_start_date" class="form-control @error('getting_ready_start_date') is-invalid @enderror" wire:model="getting_ready_start_date" placeholder="أكتب هنا">
                @error('getting_ready_start_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="getting_ready_end_date" class="form-label">تاريخ إنتهاء التجهيز</label>
                <input type="date" id="getting_ready_end_date" class="form-control @error('getting_ready_end_date') is-invalid @enderror" wire:model.defer="getting_ready_end_date" placeholder="أكتب هنا">
                @error('getting_ready_end_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Mission Dates -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="start_date" class="form-label">تاريخ بدء المهمة</label>
                <input type="date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" wire:model.defer="start_date" placeholder="أكتب هنا">
                @error('start_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="end_date" class="form-label">تاريخ إنتهاء المهمة</label>
                <input type="date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" wire:model.defer="end_date" placeholder="أكتب هنا">
                @error('end_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
