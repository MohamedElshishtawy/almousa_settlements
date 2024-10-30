<div class="report-page ">
    <div class="header ">
        <h1 class="text-center text-success">
            محضر توريد
            {{ $office->mission->title }}
            {{ $office->living->title }}
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
                        <button  class="btn btn-primary" wire:click="save">تعديل</button>
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
                    {{ $office->name }}
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
                        @foreach(\App\Office\Office::dateRange($office) as $officeDate)
                            <option value="{{ $officeDate }}" @if($officeDate == $date) selected @endif>
                                {{ $officeDate }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th class="text-success">عدد المستفيدين</th>
                <td><input type="text" wire:model.live.debounce.250ms="benefits" placeholder="0" class="form-control"></td>
            </tr>
            <tr>
                <th class="text-success">العدد غير المورد</th>
                <td><input type="text" wire:model.live.debounce.250ms="benefitError" placeholder="0" class="form-control"></td>
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
            <th>التوريد المتوقع</th>
            <th>الكمية الموردة</th>
            <th>الفرق</th>
            </thead>
            <tbody>
            @php $index = 0; @endphp
            @foreach($products as $product)
                @php
                // if there is a report, so you will use form the static product
                // ,but it there is no report you will use the normal product
                    if ($report) {
                        $dailyTotal = \App\Product\StaticProduct::howMealPerDay($product->id, \App\Models\Day::date2object($date)->id) ;
                    } else {
                        $dailyTotal = \App\Product\Product::howMealPerDay($product->id, \App\Models\Day::date2object($date)->id);
                    }
                    // check if digit (int or any thing)
                    // $daily_amoutn * $benefits
                    dd($product->daily_amount * $benefits);
                    $expectedSupply = $dailyTotal && $benefits && $product->daily_amount && is_numeric($benefits) ?
                                      $product->daily_amount * $benefits : 0;
                    $error = isset($realyImported[$product->id]) && is_numeric($realyImported[$product->id]) ? $realyImported[$product->id] : 0;
                    $benefitError = $benefitError ?: 0;

                    $difference = $dailyTotal ? ( $error ? $expectedSupply - $error : ($benefitError ? $expectedSupply - ($benefitError * $product->daily_amount) : $expectedSupply ) ) : 'غير مقرر';
                @endphp
                <tr>
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->daily_amount }}</td>
                    <td>{{ $product->foodUnit->title }}</td>
                    <td>{{ \App\Product\ProductController::getWeeklyUsedCount($product) }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $dailyTotal }}</td>
                    <td>{{ $expectedSupply }}</td>
                    <td>
                        <input type="text" wire:model.live="realyImported.{{ $product->id }}" placeholder="0" class="form-control">
                    </td>
                    <td>{{ $difference }}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>

</div>
