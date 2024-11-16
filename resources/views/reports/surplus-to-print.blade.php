@php use Carbon\Carbon; @endphp
    <!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--Google Font--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Indie+Flower&family=Lalezar&family=Matemasie&family=Permanent+Marker&family=Playwrite+FR+Moderne:wght@100..400&family=Readex+Pro:wght@160..700&family=Sen:wght@400..800&family=Tajawal:wght@200;300;400;500;700;800;900&family=Titan+One&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@200..1000&family=Indie+Flower&family=Lalezar&family=Matemasie&family=Permanent+Marker&family=Playwrite+FR+Moderne:wght@100..400&family=Readex+Pro:wght@160..700&family=Sen:wght@400..800&family=Tajawal:wght@200;300;400;500;700;800;900&family=Titan+One&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <title>طباعة الوفر</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css?2')}}">
</head>
<body dir="rtl">
<h1>محضر وفر المواد الطازجة و الجافة إعاشة {{$office->living->title}}
    ({{$office->name}})
</h1>
<table rules="all">
    <thead>
    <tr>
        <th>اليوم</th>
        <td>{{ \App\Models\Day::convertDate2ArName($date) }}</td>
        <th>التاريخ</th>
        <td colspan="2">{{\App\Models\Day::DateToHijri($date)}}</td>
        <th>إجمالى القوة</th>
        <td colspan="1"
            class="focus">{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($report->import->benefits)}}</td>
        <th>وقت الوجبة</th>
        <td>{{$surplus->meal->name}}</td>
    </tr>

    <tr>
        <th>ت</th>
        <th>الصنف</th>
        <th>الوحدة</th>
        <th>الإستحقاق اليومى (للوجبة)</th>
        <th>إجمال الإستحقاق</th>
        <th>الوارد الحقيقى</th>

        <th>الوفر(الأشخاص)</th>
        <th>إجمالى الوفر(الوحدة)</th>
        <th>إجمالى المصروف(الوحدة)</th>
    </tr>
    </thead>
    @php
        $index = 0;
        $day = \App\Models\Day::date2object($date);
    @endphp
    @foreach($staticProducts as $staticProduct)
        @php
            $timesPerDay = $staticProduct->getHowManyPerDay($day);
            $amountForMeal = $staticProduct->getAmountForMeal($day, $surplus->meal) * $report->import->benefits;
            $thisDayImported = $timesPerDay && $staticProduct->importProductError ? $staticProduct->importProductError->error / $timesPerDay: 0;

            $surplusProductError = $surplus->surplusProductErrors
                            ->where('static_product_id', $staticProduct->id)->first();
            $surplusFoodType = $surplus->surplusFoodTypes->where('food_type_id', $staticProduct->food_type_id)->first();
            $surplusBenefitFromTypes =  $surplus->surplusFoodTypes
                            ->where('food_type_id', $staticProduct->food_type_id)->first()->value ?? 0;
            $surplusBenefit = $surplusBenefitFromTypes + ($surplusProductError ? $surplusProductError->surplus_benefits : 0);

            $totalSurplus = $staticProduct->daily_amount * $surplusBenefit +
                ($surplusProductError ? $surplusProductError->surplus_amount : 0); // 0 for the wrongs input
            $total = $thisDayImported - $totalSurplus;

            // format numbers

        @endphp
        <tr>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
            <td>{{ $staticProduct->name }}</td>
            <td>{{ $staticProduct->foodUnit->title }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($staticProduct->daily_amount, 4)) }}</td>
            <td>{{$amountForMeal ? \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($amountForMeal, 4)) : 'غير مقرر'}}</td>
            <td>{{$amountForMeal ? \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($thisDayImported, 4)) : 'غير مقرر'}}</td>
            <td>{{$amountForMeal ? \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($surplusBenefit) : 'غير مقرر'}}</td>
            <td>{{$amountForMeal ? \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($totalSurplus, 4)) : 'غير مقرر'}}</td>
            <td>{{$amountForMeal ? \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($total, 4)) : 'غير مقرر'}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
