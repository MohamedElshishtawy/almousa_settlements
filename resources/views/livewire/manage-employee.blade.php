<div class="container mt-5" dir="rtl">
    <x-message/>
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Form -->
    <form wire:submit.prevent="save">
        <!-- First row: Name and Phone -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" id="name" class="form-control" wire:model="name" placeholder="أكتب هنا">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror <!-- Updated error key -->
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="phone" class="form-label">الهاتف</label>
                <input type="text" id="phone" class="form-control" wire:model="phone" placeholder="أكتب هنا">
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror <!-- Updated error key -->
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">الباسورد</label>
                <input type="password" id="password" class="form-control" wire:model="password"
                       placeholder="{{ $user->exists ? 'اكتب الباسورد الجديد' : 'أكتب هنا' }}">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror <!-- Updated error key -->
            </div>
        </div>

        <!-- Second row: Role and Office -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="role" class="form-label">الرتبة</label>
                <select id="role" class="form-select" wire:model="role"> <!-- Added wire:model for role -->
                    <option value="">إختر الرتبة</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ __('roles_permissions.'.$role->name) }}</option>
                    @endforeach
                </select>
                @error('role') <span class="text-danger">{{ $message }}</span> @enderror <!-- Updated error key -->
            </div>

            <div class="col-md-6">
                <label for="office_id" class="form-label">المقر</label>
                <select id="office_id" class="form-select" wire:model="office_id">
                    <option value="">لا يوجد مقر محدد</option>
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
                    {{ $user->exists ? 'تحديث الموظف' : 'إضافة الموظف' }} <!-- Updated variable to $user -->
                </button>
            </div>
        </div>
    </form>
</div>
