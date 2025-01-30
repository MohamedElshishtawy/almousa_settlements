<div class="card-body table-responsive ">
    <table class="table text-center border table-hover table-bordered" data-toggle="table" data-sticky-header="true">
        <thead>
        <tr>
            <th colspan="100%" class="main-title">
                <span>أصناف الإفطار</span>
                <span wire:loading>
                        <span class="spinner-border spinner-border-sm text-light" role="status"></span>
                    </span>
            </th>
        </tr>
        <tr>
            <th rowspan="2">ت</th>
            <th rowspan="2">اسم الصنف</th>
            <th rowspan="2">الكمية اليومية</th>
            <th rowspan="2">الوحدة</th>
        </tr>
        </thead>

        <tbody>
        @foreach($breakfastProducts as $breakfastProduct)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $breakfastProduct->product->name }}</td>
                <td><input type="number" min="1" wire:model="dailyAmounts.{{ $breakfastProduct->id }}"
                           step="0.1"
                           wire:keyup="updateDailyAmount({{$breakfastProduct->id}}, $event.target.value)"
                           wire:change="updateDailyAmount({{$breakfastProduct->id}}, $event.target.value)"
                           class="form-control"></td>
                <td>{{ $breakfastProduct->product->foodUnit->title }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
