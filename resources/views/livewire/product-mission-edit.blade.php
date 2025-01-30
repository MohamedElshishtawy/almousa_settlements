<tr>
    <td>
        <span wire:loading.remove>
            {{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($index) }}
        </span>

        <div wire:loading>
            <div class="spinner-border  text-success spinner-border-sm m-0 p-0" role="status">
            </div>
        </div>
    </td>

    <!-- Editable input for product name -->
    <td>
        {{$product->name}}
    </td>

    <!-- Editable dropdown for unit -->
    <td>
        <input type="text" wire:model.live.debounce.450ms="daily_amount" placeholder="0"
               class="form-control number-input @if($daily_amount && $daily_amount > 0) is-valid @else is-invalid @endif">
    </td>
    <td>
        {{$product->foodUnit->title}}
    </td>

    <!-- Editable input for price -->
    <td>
        <input type="text" wire:model.live.debounce.450ms="price" placeholder="0.00"
               class="form-control number-input @if($price && $price > 0 ) is-valid @else is-invalid @endif">
    </td>

    <!-- Editable input for quantity -->
    <td>
        {{$times_per_week}}
    </td>

    <!-- Checkboxes for meals per day -->
    @foreach(\App\Models\Day::all() as $day)
        @foreach((new \App\Models\Meal())->getMeals($mission->title)->reverse() as $meal)
            <td>
                <input type="checkbox" wire:click="toggleDayMeal({{ $day->id }},{{ $meal->id }})"
                       class="form-check-input"
                       {{$productLivingMission->productsDayMeal()->where('day_id', $day->id)->where('meal_id', $meal->id)->first() ? 'checked' : ''}}
                       wire:loading.attr="disabled"
                >
            </td>
        @endforeach
    @endforeach


</tr>
