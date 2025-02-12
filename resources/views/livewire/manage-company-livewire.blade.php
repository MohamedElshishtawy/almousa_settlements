<div class="card">
    <div class="card-header d-flex justify-content-right align-items-center">
        <h2>إدارة شركة الموسم</h2>
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
                <th>مفعل</th>
                <th>اسم الشركة</th>
                <th>اسم المندوب</th>
                <th>رتبة المندوب</th>
                <th>رقم المندوب</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr wire:key="company-{{ $company->id }}">
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration) }}</td>
                    <td>
                        <input type="radio" name="is_active" value="{{ $company->id }}"
                               wire:change="editField({{ $company->id }}, 'is_active', $event.target.value)"
                               {{ $company->is_active ? 'checked' : '' }}
                               class="form-check-input">
                    </td>
                    <td>
                        <input type="text" class="form-control @error('names.{{ $company->id }}') is-invalid @enderror"
                               wire:model.live="names.{{ $company->id }}"
                               wire:keyup.debounce.420="editField({{ $company->id }}, 'names', $event.target.value)">
                        @error('names.{{ $company->id }}') <span class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <input type="text"
                               class="form-control @error('delegate_names.{{ $company->id }}') is-invalid @enderror"
                               wire:model.live="delegate_names.{{ $company->id }}"
                               wire:keyup.debounce.420="editField({{ $company->id }}, 'delegate_name', $event.target.value)">
                        @error('delegate_names.{{ $company->id }}') <span
                            class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <input type="text"
                               class="form-control @error('delegate_ranks.{{ $company->id }}') is-invalid @enderror"
                               wire:model.live="delegate_ranks.{{ $company->id }}"
                               wire:keyup.debounce.420="editField({{ $company->id }}, 'delegate_rank', $event.target.value)">
                        @error('delegate_ranks.{{ $company->id }}') <span
                            class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <input type="text"
                               class="form-control @error('delegate_phones.{{ $company->id }}') is-invalid @enderror"
                               wire:model.live="delegate_phones.{{ $company->id }}"
                               wire:keyup.debounce.420="editField({{ $company->id }}, 'delegate_phone', $event.target.value)">
                        @error('delegate_phones.{{ $company->id }}') <span
                            class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <button class="btn btn-danger" wire:click="delete({{ $company->id }})"
                                @if($company->obligations()->count()) disabled @endif>
                            حذف
                        </button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>#</td>
                <td></td>
                <td>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="أكتب هنا">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <input type="text" wire:model="delegate_name"
                           class="form-control @error('delegate_name') is-invalid @enderror" placeholder="أكتب هنا">
                    @error('delegate_name') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <input type="text" wire:model="delegate_rank"
                           class="form-control @error('delegate_rank') is-invalid @enderror" placeholder="أكتب هنا">
                    @error('delegate_rank') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <input type="text" wire:model="delegate_phone"
                           class="form-control @error('delegate_phone') is-invalid @enderror" placeholder="أكتب هنا">
                    @error('delegate_phone') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <button class="btn btn-primary" wire:click="save">إضافة</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


