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
        <tr>

            @php($dailyTotal = $import->benefits * \App\Product\StaticProduct::howMealPerDay($product->id, \App\Models\Day::date2object($date)->id) * $product->daily_amount)
            @php($realyImported = $product->importProductError ? $product->importProductError->error : ($import->benefits_error ? $import->benefits_error * $dailyTotal : 0))
            @php($diffrence = ($dailyTotal) - $realyImported)

            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($product->daily_amount) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(\App\Product\ProductController::getWeeklyUsedCount($product)) }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($dailyTotal)}}</td>
            <td>
                {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($realyImported)}}
            </td>

            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($diffrence) }}</td>
            <td>{{ $product->foodUnit->title }}</td>
        </tr>
    @endforeach
</table>


</body>
</html>
