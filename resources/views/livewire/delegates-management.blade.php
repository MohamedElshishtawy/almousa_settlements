<div class="row justify-content-center">
    <div>
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h2>إدارة المناديب</h2>
                <span class="mx-1">
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm text-success" role="status"></span>
                    </span>
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
                        <th scope="col">الرقم بالكشف</th>
                        <th scope="col">الاسم</th>
                        <th scope="col">الجهة</th>
                        <th scope="col">الرتبة</th>
                        <th scope="col">عدد المستفيدين</th>
                        <th scope="col">نوع الصرف</th>
                        <th scope="col">المقر</th>
                        <th scope="col">التلفون</th>
                        <th scope="col">حدث</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($delegates as $delegate)
                        <tr>
                            <td>
                                <input type="number" min="0" wire:model="delegatesNumbers.{{ $delegate->id }}"
                                       wire:change="changeNumber({{ $delegate->id }}, $event.target.value)"
                                       class="form-control">
                                @error('delegatesNumbers.' . $delegate->id)
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="text" wire:model="delegatesNames.{{ $delegate->id }}"
                                       wire:change="changeName({{ $delegate->id }}, $event.target.value)"
                                       class="form-control">
                                @error('delegatesNames.' . $delegate->id)
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="text" wire:model="delegatesInstitutions.{{ $delegate->id }}"
                                       wire:change="changeInstitution({{ $delegate->id }}, $event.target.value)"
                                       class="form-control">
                                @error('delegatesInstitutions.' . $delegate->id)
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="text" wire:model="delegatesRanks.{{ $delegate->id }}"
                                       wire:change="changeRank({{ $delegate->id }}, $event.target.value)"
                                       class="form-control">
                                @error('delegatesRanks.' . $delegate->id)
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="number" min="0" wire:model="delegatesBenefits.{{ $delegate->id }}"
                                       wire:change="changeBenefits({{ $delegate->id }}, $event.target.value)"
                                       class="form-control">
                                @error('delegatesBenefits.' . $delegate->id)
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>

                            <td>
                                <select class="form-select" wire:model="delegatesFoodTypes.{{$delegate->id}}"
                                        wire:change="changeFoodType({{$delegate->id}}, $event.target.value)">
                                    <option value="">اختر نوع الصرف</option>
                                    @foreach($foodTypes as $foodType)
                                        <option
                                            value="{{ $foodType->id }}" {{ $delegate->food_type_id == $foodType->id ? 'selected' : '' }}>{{ $foodType->title }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <select class="form-select" wire:model="delegatesOffices.{{$delegate->id}}"
                                        wire:change="changeOffice({{$delegate->id}}, $event.target.value)">
                                    <option value="">اختر المقر</option>
                                    @foreach($offices as $officeDb)
                                        <option
                                            value="{{ $officeDb->id }}" {{ $delegate->office_id == $officeDb->id ? 'selected' : '' }}>{{ $officeDb->name }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" min="0" wire:model="delegatesPhones.{{ $delegate->id }}"
                                       wire:change="changePhone({{ $delegate->id }}, $event.target.value)"
                                       class="form-control">
                                @error('delegatesPhones.' . $delegate->id)
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>

                            <td>
                                <button wire:click="delete({{ $delegate->id }})" class="btn btn-danger btn-sm"><i
                                        class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td>
                            <input type="number" min="0" wire:model="number" class="form-control">
                            @error('number')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="text" wire:model="institution" class="form-control">
                            @error('institution')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="text" wire:model="rank" class="form-control">
                            @error('rank')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="number" min="0" wire:model="benefits" class="form-control">
                            @error('benefits')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>


                        <td>
                            <select class="form-select" wire:model="food_type_id">
                                <option value="">اختر نوع الصرف</option>
                                @foreach($foodTypes as $foodType)
                                    <option
                                        value="{{ $foodType->id }}">{{ $foodType->title }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <select class="form-select" wire:model="office_id">
                                <option value="">اختر المقر</option>
                                @foreach($offices as $officeDb)
                                    <option
                                        value="{{ $officeDb->id }}" {{ $delegate->office_id == $officeDb->id ? 'selected' : '' }}>{{ $officeDb->name }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="text" wire:model="phone" class="form-control">
                            @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>


                        <td>
                            <button wire:click="store" class="btn btn-success">إضافة</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
