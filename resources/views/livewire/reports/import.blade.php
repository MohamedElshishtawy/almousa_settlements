<div class="report-page">
    <div class="header">
        <h1 class="text-center text-success">
            محضر توريد
            {{ $officeMission->mission->title }}
            {{ $officeMission->office->living->title }}
        </h1>
    </div>

    <x-message/>

    <div class="report-details" style="position: relative">
        <x-calc-loading/>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success">معلومات المحضر</h2>
            <div class="d-flex">
                @if($report)
                    @can('import_delete')
                        <button wire:click="delete" class="btn btn-danger btn-sm mx-1" wire:loading.attr="disabled"
                                wire:confirm="هل انت متأكد">
                            <i class="fa-solid fa-trash fa-lg fa-fw"></i>
                        </button>
                    @endcan

                    @can('import_edit')
                        <button wire:click="reportUpdate" class="btn btn-primary btn-sm mx-1"
                                wire:loading.attr="disabled" wire:confirm="هل انت متأكد">
                            <i class="fa-solid fa-pen-to-square fa-lg fa-fw"></i>
                        </button>
                    @endcan
                @else
                    @can('import_create')
                        <button wire:click="save" class="btn btn-success btn-sm mx-1" wire:loading.attr="disabled">حفظ
                        </button>
                    @endcan
                @endif
            </div>
        </div>
        <div wire:loading wire:target="delete, reportUpdate, save" class="text-center">
            <x-calc-loading/>
        </div>

        <div>
            <table class="table table-borderless">
                <tbody>
                @if($report && $report->import)
                    @can('import_print')
                        <tr>
                            <th>المحضر</th>
                            <td><a href="{{ route('managers.reports.import.print', [$office, $date]) }}">
                                    <i class="fa-solid fa-print"></i> طباعة
                                </a></td>
                        </tr>
                    @endcan
                    @can('import_writing_print')
                        <tr>
                            <th>المحضر الكتابى</th>
                            <td><a href="{{ route('managers.reports.import.print-writing', [$office, $date]) }}">
                                    <i class="fa-solid fa-feather-pointed"></i> طباعة
                                </a></td>
                        </tr>
                    @endcan

                    @canany(['employment_create', 'employment_edit', 'employment_delete', 'employment_print'])
                        <tr>
                            <th>تقييم العمالة</th>
                            <td><a href="{{ route('managers.employment', ['import' => $report->import]) }}">
                                    @if($report->import->formEmployment)
                                        <span><i class="fa-regular fa-circle-check fa-sm "></i></span>
                                        عرض وطباعة
                                    @else
                                        عمل التقييم
                                    @endif

                                </a>

                            </td>
                        </tr>
                    @endcan
                @endif
                <tr>
                    <th>اسم المقر</th>
                    <td><a href="{{ route('admin.offices') }}#{{ $office->id }}">{{ $office->name }}</a></td>
                </tr>
                <tr>
                    <th>التاريخ</th>
                    <td>
                        <select wire:model.live="date" class="form-select" wire:change="dateChanged()">
                            @foreach(\App\Office\OfficeMission::dateRange($officeMission) as $officeDate)
                                <option value="{{ $officeDate }}" @if($officeDate == $date) selected @endif>
                                    {{ \App\Models\Day::DateToHijri($officeDate) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class="text-success">عدد المستفيدين</th>
                    <td>
                        <input type="text" wire:model.live.debounce.450ms="benefits"
                               wire:input.debounce.450ms="benefitChanged($event.target.value)"
                               placeholder="اكتب هنا.."
                               class="form-control @error('benefits') is-invalid @enderror"
                               autofocus>
                        @error('benefits')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="products-details">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ت</th>
                <th>الصنف</th>
                <th>المقرر اليومى</th>
                <th>الوحدة</th>
                <th>الصرف بالاسبوع</th>
                @if (auth()->user()->isAdmin())
                    <th>السعر</th>
                @endif
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
                    $benefitError = $benefitError ? $benefitError : 0;

                    // Determine if using report or product data
                    $productMissionData = $report ? $product : \App\Product\Product::getProductMissionData($product, $office, $officeMission);
                    $dayMissionTimes = $product->getHowManyPerDay($day, !$report?$productMissionData:null);

                    $dailyTotal = $report ? \App\Product\StaticProduct::howMealPerDay($product->id, \App\Models\Day::date2object($date)->id) :
                                             \App\Product\ProductDayMeal::howMealPerDay($productMissionData->id, \App\Models\Day::date2object($date)->id);
                    $expectedSupply = $dailyTotal && $benefits && is_numeric($benefits) ? $productMissionData->daily_amount * $benefits : 0;
                    $exactlyImported = isset($reallyImported[$product->id]) && is_numeric($reallyImported[$product->id]) ? $reallyImported[$product->id] : $expectedSupply;
                    $difference = $dailyTotal ? $expectedSupply - $exactlyImported : 0;

                    // Format numbers
                    $exactlyImported = round($exactlyImported, 4);
                    $expectedSupply = round($expectedSupply, 4);
                    $difference =  round($difference, 4);
                    $difference =  $difference >= 0 && $difference != -0 ? $difference : 0;
                @endphp
                <tr>
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($productMissionData->daily_amount, 4) }}</td>
                    <td>{{ $product->foodUnit->title }}</td>
                    <td>{{ $product->getHowManyDayPerWeekUsed(!$report?$productMissionData:null); }}</td>
                    @if (auth()->user()->role->hasPermissionTo('import_show_price'))
                        <td>{{ number_format($productMissionData->price, 4) . ' ر.س.' }}</td>
                    @endif
                    <td>{{ (int)$dailyTotal ? $dayMissionTimes : 'غير مقرر' }}</td>
                    <td>{{ (int)$expectedSupply? $expectedSupply : 'غير مقرر' }}</td>
                    <td>
                        <input type="text"
                               wire:model="reallyImported.{{ $product->id }}"
                               wire:input.debounce.450ms="importedChanged({{ $product->id }}, $event.target.value)"
                               placeholder="0"
                               class="form-control" @if(!(int)$dailyTotal) disabled @endif>
                    </td>
                    <td>{{ $dailyTotal ? $difference : 'غير مقرر' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
