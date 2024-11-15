<div class="report-page ">

    <div class="header ">
        <h1 class="text-center text-success">
            محضر الوفر
            {{ $officeMission->mission->title }}
            {{ $officeMission->office->living->title }}
        </h1>

    </div>

    <div class="report-details ">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success">معلومات المحضر</h2>
            <div class="d-flex">
                @if($surplus)

                        <a href="{{route('managers.reports.surplus.print', [$officeMission, $date, $selectedMeal->id])}}"
                           class="mx-1 btn btn-secondary">
                            <i class="fa-solid fa-print"></i>
                        </a>

                        <button class="btn btn-danger mx-1" wire:click="delete">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button class="btn btn-primary" wire:click="reportUpdate">تعديل</button>

                @else
                    <span wire:loading>
                    <span class="spinner-border  text-success" role="status"></span>
                </span>
                    <div class="mx-1">
                        <button class="btn btn-success" wire:click="save">حفظ</button>
                    </div>
                @endif
            </div>
        </div>

        <table class="table table-borderless">
            <tbody>
            <tr>
                <th class="text-success">اسم المقر</th>
                <td>
                    <a href="{{route('admin.offices')}}#{{$office->id}}">{{ $office->name }}</a>
                </td>
            </tr>
            <tr>
                <th class="text-success">اليوم</th>
                <td>{{ \App\Models\Day::convertDate2ArName($date) }}</td>
            </tr>
            <tr>
                <th class="text-success">عدد المستفيدين</th>
                <td class="text-danger">{{$report->import->benefits}}</td>
            </tr>
            <tr>
                <th class="text-success">التاريخ</th>
                <td>
                   {{$report->for_date}}
                </td>
            </tr>
            <tr>
                <th class="text-success">الوجبة</th>
                <td>
                    <select class="form-select" wire:change="changeMeal($event.target.value)">
                        @foreach($meals as $meal)
                            <option value="{{ $meal->id }}" @if($selectedMeal && $meal->id == $selectedMeal->id) selected @endif>
                                {{ $meal->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @if ($report->surplus->count() == 0)
                {{--! to make it easy to make another similar meals !--}}
                <tr>
                    <th class="text-success">الوجبات المتشابة</th>
                    <td class="d-flex gap-1">
                        @foreach($meals->where('id','!=', $selectedMeal->id) as $meal)
                            <div>
                                <input type="checkbox" wire:model="sameReportMeals[]" wire:click="sameReportMealsChanged({{$meal->id}})" id="mealSame{{$meal->id}}">
                                <label for="mealSame{{$meal->id}}">{{$meal->name}}</label>
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endif

            @foreach(\App\Product\FoodType::all() as $foodType)
                <tr>
                    <th class="text-success">قوة وفر {{$foodType->title}}</th>
                    <td>
                        <input type="text"
                               wire:input.debounce.450ms="FoodTypeValuesUpdate({{$foodType->id}}, $event.target.value)"
                               placeholder="0" class="form-control"
                               wire:model.defer="surplusfoodTypeValues.{{$foodType->id}}"

                        >
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <div class="products-details ">
        <table class="table">
            <thead>
            <th>ت</th>
            <th>الصنف</th>
            <th>الإستحقاق اليومى</th>
            <th>الوفر(عدد المستفيدين)</th>
            <th>إجمال الإستحقاق</th>
            <th>الوارد الحقيقى</th>
            <th>إجمالى الوفر</th>
            <th>إجمالى المصروف</th>
            <th>وفر بالكمية</th>
            <th>وفر بالأفراد</th>
            </thead>
            <tbody>
            @php $index = 0; @endphp

            @foreach($staticProducts as $staticProduct)
                @php
                    $surplusBenefit = $this->surplusfoodTypeValues[$staticProduct->food_type_id] ?? 0;
                    $thisDayAmount = \App\Product\StaticProduct::howMealPerDay($staticProduct->id, \App\Models\Day::date2object($date)->id) * $report->import->benefits;
                    $thisDayImported = $staticProduct->importProductError ? $staticProduct->importProductError->error : 0;
                    $totalSurplus = $staticProduct->daily_amount * $surplusBenefit +
                        ($surplusAmount[$staticProduct->id] ?? 0) +
                        $staticProduct->daily_amount * ($surplusBenefits[$staticProduct->id] ?? 0); // 0 for the wrongs input
                    $total = $thisDayImported - $totalSurplus;


                @endphp
                <tr>
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
                    <td>{{ $staticProduct->name }}</td>
                    <td>
                        <div class="d-flex">
                            {{ $staticProduct->daily_amount }}
                            <span class="unit">{{ $staticProduct->foodUnit->title }}</span>
                        </div>
                    </td>
                    <td>{{$surplusBenefit}}</td>
                    <td>{{$thisDayAmount ?: 'غير مقرر'}}</td>
                    <td>{{$thisDayImported}}</td>
                    <td>{{$thisDayAmount ? $totalSurplus : 'غير مقرر'}}</td>
                    <td>{{$thisDayAmount ? $total : 'غير مقرر'}}</td>
                    <td>
                        <div class="d-flex">
                            <input type="text"
                                   wire:input.debounce.450ms="surplusAmountUpdate({{$staticProduct->id}}, $event.target.value)"
                                   class="form-control number-input"
                                  wire:model.defer="surplusAmount.{{$staticProduct->id}}" @if(!$thisDayAmount) disabled @endif>
                            <span class="unit">{{ $staticProduct->foodUnit->title }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <input type="text"
                                   wire:input.debounce.450ms="surplusBenefitsUpdate({{$staticProduct->id}}, $event.target.value)"
                                   class="form-control number-input"
                                    wire:model.defer="surplusBenefits.{{$staticProduct->id}}" @if(!$thisDayAmount) disabled @endif>
                            <span class="unit">{{'شخص'}}</span>
                        </div>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>
</div>

