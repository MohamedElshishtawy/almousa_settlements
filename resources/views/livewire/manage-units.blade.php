<div class="card">
    <div class="card-header d-flex justify-content-right align-items-center gap-2">
        <h2>إدارة الوحدات</h2>
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
                <th>الوحدة</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach($units as $unit)
                <tr wire:key="{{$unit->id}}">
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration)}}</td>
                    <td><input class="form-control" wire:model.live="titles.{{$unit->id}}"
                               wire:keyup.debounce.240="editTitle({{$unit->id}})" value="{{$unit->title}}"></td>
                    <td>
                        <button wire:click="delete({{ $unit->id }})" class="btn btn-danger"
                                @if($unit->products()->count())
                                    disabled
                                data-toggle="tooltip" data-placement="top"
                                title="هناك بعض المنتجات تعتمد على تلك الوحدة"
                            @endif
                        >حذف
                        </button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>#</td>
                <td colspan="1">
                    <input type="text" wire:model="name" class="form-control" placeholder="أكتب هنا">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <button wire:click="save" class="btn btn-primary">إضافة</button>
                </td>
            </tr>
            </tbody>

        </table>
    </div>
</div>


