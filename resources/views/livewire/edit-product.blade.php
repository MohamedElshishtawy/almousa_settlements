<tr >
    <td>
        <span wire:loading.remove>
            {{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($index) }}
        </span>

        <div wire:loading>
            <div class="spinner-border  text-success" role="status">
            </div>
        </div>
    </td>

    <!-- Editable input for product name -->
    <td>
        <input type="text" wire:model.live.debounce.250ms="name" class="form-control product-name" placeholder="أكتب هنا...">
    </td>

    <!-- Editable input for daily amount -->
    <td>
        <input type="text" wire:model.live.debounce.250ms="daily_amount" class="form-control number-input" placeholder="0">
    </td>

    <!-- Editable dropdown for unit -->
    <td>
        <select wire:model.live="food_unit_id" class="form-control">
            <option value="">اختر الوحدة</option>
            @foreach($units as $unit)
                <option value="{{ $unit->id }}">{{ $unit->title }}</option>
            @endforeach
        </select>
    </td>

    <!-- Editable input for price -->
    <td>
        <input type="text" wire:model.live.debounce.250ms="price" class="form-control number-input" placeholder="0.00">
    </td>

    <!-- Editable dropdown for type -->
    <td>
        <select wire:model.live="food_type_id" class="form-control">
            <option value="">اختر النوع</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->title }}</option>
            @endforeach
        </select>
    </td>

    <!-- Editable input for times per day -->
    <td>
        {{$times_per_week}}
    </td>

    <!-- Checkboxes for meals per day -->
    @foreach(\App\Models\Day::all() as $day)
        @foreach((new \App\Models\Meal())->getMeals($mission->title)->reverse() as $meal)
            <td>
                <input type="checkbox" wire:click="toggleDayMeal({{ $day->id }},{{ $meal->id }})"
                       class="form-check-input"
                       {{$product->pdoductsDayMeal()->where('day_id', $day->id)->where('meal_id', $meal->id)->first() ? 'checked' : ''}}
                >
            </td>
        @endforeach
    @endforeach
</tr>
