<div class="report-page ">

    <div class="header ">
        <h1 class="text-center text-success">
            محضر توريد
            {{ $officeMission->mission->title }}
            {{ $officeMission->office->title }}
        </h1>

    </div>

    <div class="report-details ">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success">معلومات المحضر</h2>
            <div class="d-flex">
                @if($report)
                    <div>
                        <a href="{{route('managers.reports.import.print', [$office, $date])}}" class="mx-1 btn btn-secondary">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>
                    <span wire:loading>
                    <span class="spinner-border  text-success" role="status"></span>
                </span>
                    <div wire:loading.remove>
                        <button  class="btn btn-primary" wire:click="reportUpdate">تعديل</button>
                    </div>
                @else
                    <span wire:loading>
                    <span class="spinner-border  text-success" role="status"></span>
                </span>
                    <div wire:loading.remove>
                        <button  class="btn btn-success" wire:click="save">حفظ</button>
                    </div>
                @endif
            </div>
        </div>

        <table class="table table-borderless">
            <tbody>
            <tr>
                <th>اسم المقر</th>
                <td>
                    <a href="{{route('admin.offices')}}#{{$office->id}}">{{ $office->name }}</a>
                </td>
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
                <td><input type="text" wire:model.live.debounce.250ms="benefits" placeholder="0" class="form-control" autofocus></td>
            </tr>
            </tbody>
        </table>

    </div>

    <div class="products-details ">
        <table class="table">
            <thead>
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
            </thead>
            <tbody>
            @php $index = 0; @endphp
            @foreach($products as $product)
                @php
                //if there is a report, so you will use form the static product
                //but it there is no report you will use the normal product
                $benefits = $benefits && is_numeric($benefits) ? $benefits : 0;
                $benefitError = $benefitError ?: 0;
                if ($report) {
                    $productMissionData = $product;

                    $exactlyImported = isset($reallyImported[$product->id]) && is_numeric($reallyImported[$product->id]) ?
                        $reallyImported[$product->id] : 0;
                    $exactlyImported = number_format((float)$exactlyImported, 2, '.', '');

                    $dailyTotal = \App\Product\StaticProduct::howMealPerDay($product->id, \App\Models\Day::date2object($date)->id);
                    $dailyTotal = number_format((float)$dailyTotal, 2, '.', '');

                    $expectedSupply = $dailyTotal && $benefits && $product->daily_amount && is_numeric($benefits) ?
                    $product->daily_amount * $benefits : 0;
                    $expectedSupply = number_format((float)$expectedSupply, 2, '.', '');

                    if (!$dailyTotal)
                        $difference = 'غير مقرر';
                    else {
                        $difference = $exactlyImported ?
                         $expectedSupply - $exactlyImported
                         : ($benefitError ? $expectedSupply - ($benefitError * $product->daily_amount) : $expectedSupply ) ;
                        $difference = number_format((float)$difference, 2, '.', '');
                    }

                } else {
                    $exactlyImported = isset($reallyImported[$product->id]) && is_numeric($reallyImported[$product->id]) ?
                     $reallyImported[$product->id] : 0;
                    $exactlyImported = number_format((float)$exactlyImported, 2, '.', '');

                    $productMissionData = \App\Product\Product::getProductMissionData($product, $office, $officeMission);
                    $dailyTotal = \App\Product\ProductDayMeal::howMealPerDay($productMissionData->id, \App\Models\Day::date2object($date)->id);
                    $dailyTotal = number_format((float)$dailyTotal, 2, '.', '');

                    $expectedSupply = $dailyTotal && $benefits && $productMissionData->daily_amount && is_numeric($benefits) ?
                    $productMissionData->daily_amount * $benefits : 0;
                    $expectedSupply = number_format((float)$expectedSupply, 2, '.', '');

                    if (!$dailyTotal)
                        $difference = 'غير مقرر';
                    else {
                        $difference = $exactlyImported ?
                         $expectedSupply - $exactlyImported
                         : ($benefitError ? $expectedSupply - ($benefitError * $productMissionData->daily_amount) : $expectedSupply ) ;
                        $difference = number_format((float)$difference, 2, '.', '');
                    }
                }
                @endphp
                <tr>
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $productMissionData->daily_amount }}</td>
                    <td>{{ $product->foodUnit->title }}</td>
                    <td>{{ \App\Product\ProductController::getWeeklyUsedCount($productMissionData, true) }}</td>
                    <td>{{ $productMissionData->price }}</td>
                    <td>{{ $dailyTotal ?: 'غير مقرر' }}</td>
                    <td>{{ $expectedSupply }}</td>
                    <td>
                        <input type="text"
                               value="{{$report ? $exactlyImported : $expectedSupply }}"
                               wire:model.live="reallyImported.{{ $product->id }}"
                               wire:input="importedChanged({{ $product->id }}, $event.target.value)"
                               placeholder="0"
                               class="form-control" @if(!$dailyTotal) disabled @endif>
                    </td>
                    <td>{{ $difference }}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>

</div>
{{--<p class="p-3">--}}
{{--    يمكنك خلال تلك الصفحة حفظ بيانات التوريد اليومى من خلال إضافة العدد المستفيدين أولا ثم تعديل التوريدات الفعلية فى حالة الإختلاف--}}
{{--    <br>--}}
{{--    الأصناف التى تظهر أمامك الان هى حصيلة ما ضفته فى صفحة الأصناف--}}
{{--</p>--}}
