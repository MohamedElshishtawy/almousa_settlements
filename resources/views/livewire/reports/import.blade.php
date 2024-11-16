<div class="report-page">
    <div class="header">
        <h1 class="text-center text-success">
            محضر توريد
            {{ $officeMission->mission->title }}
            {{ $officeMission->office->living->title }}
        </h1>
    </div>

    <div class="report-details">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success">معلومات المحضر</h2>
            <div class="d-flex">
                @if($report)
                    <span wire:loading>
                        <span class="spinner-border text-success" role="status"></span>
                    </span>
                    <a href="{{ route('managers.reports.import.print', [$office, $date]) }}" class="mx-1 btn btn-secondary">
                        <i class="fa-solid fa-print"></i>
                    </a>
                    <button wire:click="delete" class="btn btn-danger mx-1">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                    <button wire:loading.remove class="btn btn-primary" wire:click="reportUpdate">تعديل</button>

                @else
                    <span wire:loading>
                        <span class="spinner-border text-success" role="status"></span>
                    </span>
                    <button wire:loading.remove class="btn btn-success mx-1" wire:click="save">حفظ</button>
                @endif
            </div>
        </div>

        <table class="table table-borderless">
            <tbody>
            <tr>
                <th>اسم المقر</th>
                <td><a href="{{ route('admin.offices') }}#{{ $office->id }}">{{ $office->name }}</a></td>
            </tr>
            <tr>
                <th>اليوم</th>
                <td>{{ \App\Models\Day::convertDate2ArName($date) }}</td>
            </tr>
            <tr>
                <th>التاريخ</th>
                <td>
                    <select wire:model.live="date" class="form-select" wire:change="dateChanged()">
                        @foreach(\App\Office\OfficeMission::dateRange($officeMission) as $officeDate)
                            <option value="{{ $officeDate }}" @if($officeDate == $date) selected @endif>
                                {{ $officeDate }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th class="text-success">عدد المستفيدين</th>
                <td><input type="text" wire:model.live.debounce.450ms="benefits" wire:input.debounce.450ms="benefitChanged($event.target.value)" placeholder="0" class="form-control" autofocus></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="products-details">
        <table class="table">
            <thead>
            <tr>
                <th>ت</th>
                <th>الصنف</th>
                <th>المقرر اليومى</th>
                <th>الوحدة</th>
                <th>الصرف بالاسبوع</th>
                <th>السعر</th>
                <th>مرات الصرف باليوم</th>
                <th>الكمية المقررة</th>
                <th>الكمية الموردة</th>
                <th>الفرق</th>
            </tr>
            </thead>
            <tbody>
            @php
            $index = 0;
            $day = \App\Models\Day::date2object($date);
            @endphp
            @foreach($products as $product)
                @php
                $benefits = is_numeric($benefits) ? $benefits : 0;
                $benefitError = $benefitError ?: 0;

                // Determine if using report or product data
                $productMissionData = $report ? $product : \App\Product\Product::getProductMissionData($product, $office, $officeMission);
                $dayMissionTimes = $product->getHowManyPerDay($day, !$report?$productMissionData:null);

                $dailyTotal = $report ? \App\Product\StaticProduct::howMealPerDay($product->id, \App\Models\Day::date2object($date)->id) :
                                         \App\Product\ProductDayMeal::howMealPerDay($productMissionData->id, \App\Models\Day::date2object($date)->id);
                $expectedSupply = $dailyTotal && $benefits && is_numeric($benefits) ? $productMissionData->daily_amount * $benefits : 0;
                $exactlyImported = isset($reallyImported[$product->id]) && is_numeric($reallyImported[$product->id]) ? $reallyImported[$product->id] : $expectedSupply;
                $difference = $dailyTotal ? $expectedSupply - $exactlyImported : 'غير مقرر';

                // Format numbers
                $exactlyImported = round($exactlyImported, 4);

                $expectedSupply = round($expectedSupply, 4);
                $difference = is_numeric($difference) ? round($difference, 4) : $difference;
                @endphp
                <tr>
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ round($productMissionData->daily_amount, 4) }}</td>
                    <td>{{ $product->foodUnit->title }}</td>
                    <td>{{ $product->getHowManyDayPerWeekUsed(!$report?$productMissionData:null); }}</td>
                    <td>{{ number_format($productMissionData->price, 2) . ' ر.س.' }}</td>
                    <td>{{ (int)$dailyTotal ? $dayMissionTimes : 'غير مقرر' }}</td>
                    <td>{{ (int)$expectedSupply? $expectedSupply : 'غير مقرر' }}</td>
                    <td>
                        <input type="text"
                               wire:model="reallyImported.{{ $product->id }}"
                               wire:input.debounce.450ms="importedChanged({{ $product->id }}, $event.target.value)"
                               placeholder="0"
                               class="form-control" @if(!(int)$dailyTotal) disabled @endif>
                    </td>
                    <td>{{ $difference }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
