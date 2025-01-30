<table class="table">

    <thead>
    <tr>
        <th>التسلسل</th>
        <th>الوحدة</th>
        <th>حذف</th>

    </tr>
    </thead>

    <tbody>
    @php($n = 0)
    @foreach($units as $unit)
        <tr wire:key="{{$unit->id}}">
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$n) }}</td>
            <td><input class="form-control" wire:model.live="titles.{{$unit->id}}"
                       wire:change="editTitle({{$unit->id}})" value="{{$unit->title}}"></td>
            <td>
                <button wire:click="delete({{ $unit->id }})" class="btn btn-danger" @if($unit->products()->count())
                    disabled
                        data-toggle="tooltip" data-placement="top" title="هناك بعض المنتجات تعتمد على تلك الوحدة"
                    @endif

                >حذف
                </button>
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2">
            <input type="text" wire:model="name" class="form-control" placeholder="أكتب هنا">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </td>
        <td>
            <button wire:click="save" class="btn btn-primary">إضافة</button>
        </td>
    </tr>
    </tbody>

</table>

