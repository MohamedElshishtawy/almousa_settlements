<div class="card">
    <div class="card-header d-flex justify-content-right align-items-center">
        <h2>إدارة العمالة</h2>
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
                <th>الإعاشة</th>
                <th colspan="100">
                    <select wire:model.live="livingId" class="form-control @error('living_id') is-invalid @enderror">
                        <option value="">اختر الإعاشة</option>
                        @foreach($livings as $living)
                            <option value="{{ $living->id }}"
                                    @if(isset($livingId) && $livingId == $living->id) selected @endif>
                                {{ $living->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('living_id') <span class="text-danger">{{ $message }}</span> @enderror
                </th>
            </tr>
            <tr>
                <th class="td-15">التسلسل</th>
                <th>العنوان</th>
                <th>المستفيدين</th>
                <th>العدد</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($livingId) && $livingId)
                @foreach($employments as $employment)
                    <tr wire:key="employment-{{ $employment->id }}">
                        <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration) }}</td>
                        <td>
                            <input type="text"
                                   class="form-control @error('titles.{{ $employment->id }}') is-invalid @enderror"
                                   wire:model.live="titles.{{ $employment->id }}"
                                   wire:keyup.debounce.420="editField({{ $employment->id }}, 'title', $event.target.value)">
                            @error('titles.{{ $employment->id }}') <span
                                class="text-danger">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <input type="number" min="0"
                                   class="form-control @error('benefitses.{{ $employment->id }}') is-invalid @enderror"
                                   wire:model.live="benefitses.{{ $employment->id }}"
                                   wire:keyup.debounce.420="editField({{ $employment->id }}, 'benefits', $event.target.value)">
                            @error('benefitses.{{ $employment->id }}') <span
                                class="text-danger">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <input type="number" min="0"
                                   class="form-control @error('counts.{{ $employment->id }}') is-invalid @enderror"
                                   wire:model.live="counts.{{ $employment->id }}"
                                   wire:keyup.debounce.420="editField({{ $employment->id }}, 'count', $event.target.value)">
                            @error('counts.{{ $employment->id }}') <span
                                class="text-danger">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <button class="btn btn-danger" wire:click="delete({{ $employment->id }})">
                                حذف
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="td-15">#</td>
                    <td>
                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="أكتب العنوان هنا">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <input type="text" wire:model="benefits"
                               class="form-control @error('benefits') is-invalid @enderror"
                               placeholder="أكتب العنوان هنا">
                        @error('benefits') <span class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <input type="number" min="0" wire:model="count"
                               class="form-control @error('count') is-invalid @enderror" placeholder="أكتب العدد هنا">
                        @error('count') <span class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <button class="btn btn-primary" wire:click="save">إضافة</button>
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="100" class="text-center">الرجاء اختيار الإعاشة المناسبة</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
