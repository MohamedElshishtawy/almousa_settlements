<tr >
    <td>
        <span wire:loading.remove>
            {{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($index) }}
        </span>

        <div wire:loading>
            <div class="spinner-border spinner-border-sm text-success" role="status">
            </div>
        </div>
    </td>

    <!-- Editable input for product name -->
    <td>
        <input type="text" wire:model.live.debounce.250ms="name" class="form-control" placeholder="أكتب هنا...">
    </td>

    <!-- Editable dropdown for unit -->
    <td>
        <select wire:model.live="food_unit_id" class="form-select">
            <option value="">اختر الوحدة</option>
            @foreach($units as $unit)
                <option value="{{ $unit->id }}">{{ $unit->title }}</option>
            @endforeach
        </select>
    </td>


    <!-- Editable dropdown for type -->
    <td>
        <select wire:model.live="food_type_id" class="form-select">
            <option value="">اختر النوع</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->title }}</option>
            @endforeach
        </select>
    </td>

    <td>
        <input type="number" min="1" wire:model.live.debounce.250ms="packet_value" class="form-control" >
    </td>


    <td>
        <input type="number" min="1" wire:model.live.debounce.250ms="carton_value" class="form-control" >
    </td>


    <td>
        <button wire:click="deleteProduct({{$product->id}})" class="text-danger delete-btn">
            <i class="fa fa-trash"></i>
        </button>
    </td>

</tr>
