<div class="container mt-5" dir="rtl">
    <x-message/>

    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                       wire:model="phone">
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="location" class="form-label">المقر</label>
                <select class="form-select @error('office_id') is-invalid @enderror" id="location"
                        wire:model="office_id">
                    <option value="">اختر المقر</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                    @endforeach
                </select>
                @error('office_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="beneficiaries" class="form-label">عدد المستفيدين</label>
                <input type="number" class="form-control @error('benefits') is-invalid @enderror" id="beneficiaries"
                       wire:model="benefits">
                @error('benefits') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="type" class="form-label">نوع الصرف</label>
                <select class="form-select @error('food_type_id') is-invalid @enderror" id="type"
                        wire:model="food_type_id">
                    <option value="">اختر نوع الصرف</option>
                    @foreach ($foodTypes as $foodType)
                        <option value="{{ $foodType->id }}">{{ $foodType->title }}</option>
                    @endforeach
                </select>
                @error('food_type_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="organization" class="form-label">الجهة</label>
                <input type="text" class="form-control @error('institution') is-invalid @enderror" id="organization"
                       wire:model="institution">
                @error('institution') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="position" class="form-label">الرتبة</label>
                <input type="text" class="form-control @error('rank') is-invalid @enderror" id="position"
                       wire:model="rank">
                @error('rank') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="number" class="form-label">الرقم بالكشف</label>
                <input type="number" min="0" class="form-control @error('number') is-invalid @enderror" id="number"
                       wire:model="number">
                @error('number') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">حفظ المندوب</button>
            <button type="button" class="btn btn-secondary" wire:click="returnBack">العودة</button>
        </div>
    </form>
</div>
