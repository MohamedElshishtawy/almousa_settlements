<table class="table">
    <thead>
    <tr>
        <th>التسلسل</th>
        <th>اسم الشركة</th>
        <th>العام</th>
        <th>حذف</th>
    </tr>
    </thead>
    <tbody>
    @foreach($companies as $company)
        <tr wire:key="{{$company->id}}">
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration) }}</td>
            <td>
                <input class="form-control @error('names.{{$company->id}}') is-invalid @enderror @if(!empty($company->name)) @endif"
                       wire:model.live="names.{{$company->id}}" wire:change="editName({{$company->id}})" value="{{$company->name}}">
                @error('names.{{$company->id}}') <span class="text-danger">{{ $message }}</span> @enderror
            </td>
            <td>
                <input class="form-control @error('dates.{{$company->id}}') is-invalid @enderror @if(!empty($company->date))  @endif"
                       wire:model.live="dates.{{$company->id}}" wire:change="editDate({{$company->id}})" value="{{$company->date}}">
                @error('dates.{{$company->id}}') <span class="text-danger">{{ $message }}</span> @enderror
            </td>
            <td>
                <button wire:click="delete({{ $company->id }})" class="btn btn-danger"
                        @if($company->obligations()->count())
                            disabled
                    @endif
                >حذف</button>
            </td>
        </tr>
    @endforeach
    <tr>
        <td>#</td>
        <td>
            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror @if(!empty($name)) is-valid @endif" placeholder="أكتب هنا">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </td>
        <td>
            <input type="number" wire:model="date" class="form-control @error('date') is-invalid @enderror @if(!empty($date)) is-valid @endif" placeholder="أكتب هنا" min="2024" max="{{ now()->addYear(5)->format('Y') }}">
            @error('date') <span class="text-danger">{{ $message }}</span> @enderror
        </td>
        <td>
            <button wire:click="save" class="btn btn-primary">إضافة</button>
        </td>
    </tr>
    </tbody>
</table>
