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
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Indie+Flower&family=Lalezar&family=Matemasie&family=Permanent+Marker&family=Playwrite+FR+Moderne:wght@100..400&family=Readex+Pro:wght@160..700&family=Sen:wght@400..800&family=Tajawal:wght@200;300;400;500;700;800;900&family=Titan+One&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@200..1000&family=Indie+Flower&family=Lalezar&family=Matemasie&family=Permanent+Marker&family=Playwrite+FR+Moderne:wght@100..400&family=Readex+Pro:wght@160..700&family=Sen:wght@400..800&family=Tajawal:wght@200;300;400;500;700;800;900&family=Titan+One&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <title>طباعة التوريد</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css?7')}}">
    <link rel="stylesheet" href="{{asset('css/print-page-media.css?7')}}" media="print">
</head>
<body dir="rtl">
<h1></h1>
<table rules="all">
    <thead>
    <tr>
        <th colspan="100">محضر توريد المواد الطازجة و الجافة إعاشة {{$office->living->title}}
            ({{$office->name}})</th>
    </tr>
    <tr>
        <th>اليوم</th>
        <td>{{ \App\Models\Day::convertDate2ArName($date) }}</td>
        <th>التاريخ</th>
        <td colspan="2">{{$dateHijry}}</td>
        <th>عدد المستفيدين</th>
        <td colspan="2" class="focus">{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($import->benefits)}}</td>
    </tr>
    <tr>
        <th>عدد</th>
        <th>اسم الصنف</th>
        <th>مقرر الفرد اليومى</th>
        <th class="td-sm">عدد مرات التقديم فى الأسبوع</th>
        <th>الكمية المقررة</th>
        <th>الكمية الموردة</th>
        <th>الفرق</th>
        <th>الوحدة</th>
    </tr>
    </thead>
    @php $index = 0; @endphp
    @foreach($products as $product)
        @php
            $HowManyPday = \App\Product\StaticProduct::howMealPerDay($product->id, \App\Models\Day::date2object($import->report->for_date)->id);
            $dailyTotal = $HowManyPday ? $import->benefits * $product->daily_amount : 'غير مقرر';
            $realyImported = $HowManyPday ? ($product->importProductError ? $product->importProductError->error : ($import->benefits_error ? $dailyTotal - $import->benefits_error * $product->daily_amount : 0)) : 'غير مقرر';
            $diffrence = $HowManyPday ? ($dailyTotal) - $realyImported : 'غير مقرر';

            // Format the numbers with two decimal places
            $dailyTotalFormatted = is_numeric($dailyTotal) ? round($dailyTotal, 4) : $dailyTotal;
            $realyImportedFormatted = is_numeric($realyImported) ? round($realyImported, 4) : $realyImported;
            $diffrenceFormatted = is_numeric($diffrence) ? round($diffrence, 4) : $diffrence;
            $diffrenceFormatted =  $diffrenceFormatted >= 0 ? $diffrenceFormatted : 0;
        @endphp

        <tr>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($product->daily_amount) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($product->getHowManyDayPerWeekUsed()) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($dailyTotalFormatted) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($realyImportedFormatted) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($diffrenceFormatted) }}</td>
            <td>{{ $product->foodUnit->title }}</td>
        </tr>
    @endforeach

</table>

</body>
</html>
