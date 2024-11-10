<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طباعة التوريد</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css')}}">
</head>
<body dir="rtl">
<h1>محضر توريد المواد الطازجة و الجافة إعاشة {{$office->living->title}}</h1>
<table rules="all">
    <thead>
    <tr>
        <th>اليوم</th>
        <td>{{ \App\Models\Day::convertDate2ArName($date) }}</td>
        <th>التاريخ</th>
        <td colspan="2">{{$date}}</td>
        <th>عدد المستفيدين</th>
        <td colspan="2" class="focus">{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($import->benefits)}}</td>
    </tr>
    <tr>
        <th>عدد</th>
        <th>اسم الصنف</th>
        <th>مقرر الفرد اليومى</th>
        <th>عدد مرات التقديم فى الأسبوع</th>
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
            $dailyTotalFormatted = is_numeric($dailyTotal) ? number_format($dailyTotal, 2) : $dailyTotal;
            $realyImportedFormatted = is_numeric($realyImported) ? number_format($realyImported, 2) : $realyImported;
            $diffrenceFormatted = is_numeric($diffrence) ? number_format($diffrence, 2) : $diffrence;
        @endphp

        <tr>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($product->daily_amount) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(\App\Product\ProductController::getWeeklyUsedCount($product)) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($dailyTotalFormatted) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($realyImportedFormatted) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($diffrenceFormatted) }}</td>
            <td>{{ $product->foodUnit->title }}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
