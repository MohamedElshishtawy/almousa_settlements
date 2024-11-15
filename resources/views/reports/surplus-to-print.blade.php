<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طباعة الوفر</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css')}}">
</head>
<body dir="rtl">
<h1>محضر وفر المواد الطازجة و الجافة إعاشة {{$office->living->title}}</h1>
<table rules="all">
    <thead>
    <tr>
        <th>اليوم</th>
        <td>{{ \App\Models\Day::convertDate2ArName($date) }}</td>
        <th>التاريخ</th>
        <td colspan="2">{{$date}}</td>
        <th>إجمالى القوة</th>
        <td colspan="1" class="focus">{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($report->import->benefits)}}</td>
        <th>وقت الوجبة</th>
        <td>{{$surplus->meal->name}}</td>
    </tr>

    <tr>
        <th>ت</th>
        <th>الصنف</th>
        <th>الوحدة</th>
        <th>الإستحقاق اليومى</th>
        <th>إجمال الإستحقاق</th>
        <th>الوارد الحقيقى</th>
        <th>الوفر(الأشخاص)</th>
        <th>إجمالى الوفر(الوحدة)</th>
        <th>إجمالى المصروف(الوحدة)</th>
    </tr>
    </thead>
    @php $index = 0; @endphp
    @foreach($staticProducts as $staticProduct)
        @php
            $thisDayAmount = \App\Product\StaticProduct::howMealPerDay($staticProduct->id, \App\Models\Day::date2object($date)->id) * $report->import->benefits;
            $thisDayImported = $staticProduct->importProductError ? $staticProduct->importProductError->error : 0;
            $surplusProductError = $surplus->surplusProductErrors
                            ->where('static_product_id', $staticProduct->id)->first();
            $surplusFoodType = $surplus->surplusFoodTypes->where('food_type_id', $staticProduct->food_type_id)->first();
            $surplusBenefitFromTypes =  $surplus->surplusFoodTypes
                            ->where('food_type_id', $staticProduct->food_type_id)->first()->value ?? 0;
            $surplusBenefit = $surplusBenefitFromTypes + ($surplusProductError ? $surplusProductError->surplus_benefits : 0);

            $totalSurplus = $staticProduct->daily_amount * $surplusBenefit +
                ($surplusProductError ? $surplusProductError->surplus_amount : 0); // 0 for the wrongs input
            $total = $thisDayImported - $totalSurplus;
        @endphp
        <tr>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
            <td>{{ $staticProduct->name }}</td>
            <td>{{ $staticProduct->foodUnit->title }}</td>
            <td>{{ $staticProduct->daily_amount }}</td>
            <td>{{$thisDayAmount ?: 'غير مقرر'}}</td>
            <td>{{$thisDayAmount ? $thisDayImported : 'غير مقرر'}}</td>
            <td>{{$thisDayAmount ? $surplusBenefit : 'غير مقرر'}}</td>
            <td>{{$thisDayAmount ? $totalSurplus : 'غير مقرر'}}</td>
            <td>{{$thisDayAmount ? $total : 'غير مقرر'}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
