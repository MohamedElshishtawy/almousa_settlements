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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>طباعة الوفر</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css?7')}}">
    <link rel="stylesheet" href="{{asset('css/print-page-media.css?7')}}" media="print">
</head>
<body dir="rtl" class="m-3">

<table rules="all">
    <thead>
    <tr>
        <th colspan="100">
            محضر وفر نموذج رقم (
            {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(2)}}
            ) المواد الطازجة و الجافة إعاشة {{$office->living->title}}
            ال
            ({{$office->name}})

        </th>
    </tr>
    <tr>
        <th>اليوم</th>
        <td>{{ \App\Models\Day::convertDate2ArName($date) }}</td>
        <th>التاريخ</th>
        <td>{{\App\Models\Day::DateToHijri($date)}}</td>
        <th>إجمالى القوة</th>
        <td colspan="1"
            class="focus">{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($report->import->benefits)}}</td>
        <th>وقت الوجبة</th>
        <td>{{$meal ? $surplus->meal->name : 'كل الوجبات'}}</td>
    </tr>

    <tr>
        <th>ت</th>
        <th width="100">الصنف</th>
        <th width="100">الوحدة</th>
        <th>الإستحقاق اليومى</th>
        <th>إجمال الإستحقاق</th>
        <th>الوفر(الأشخاص)</th>
        <th>إجمالى الوفر(الوحدة)</th>
        <th>إجمالى المصروف(الوحدة)</th>
    </tr>
    </thead>
    <tbody>
    @php
        $index = 0;
        $day = \App\Models\Day::date2object($date);
    @endphp
    @foreach($staticProducts as $staticProduct)
        <tr>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$index) }}</td>
            <td>{{ $staticProduct->name }}</td>
            <td>{{ $staticProduct->foodUnit->title }}</td>
            <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($staticProduct['surplusData']['amountForMeal'], 4)) }}</td>
            <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($staticProduct['surplusData']['totalAmountForMeal'])}}</td>
            <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($staticProduct['surplusData']['surplusBenefitFromTypes'])}}</td>
            <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($staticProduct['surplusData']['totalSurplus'], 4))}}</td>
            <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($staticProduct['surplusData']['total'], 4))}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<footer class="mt-4">
    <table rules="all" class="no-break mt-2">
        <tbody>
        <tr>
            <th colspan="2">رئيس لجنة الإستلام الفرعية</th>
            <th colspan="2">المورد أو من ينوب عنه</th>
        </tr>
        <tr>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control"
                       value="{{optional($subsidiary_receiving_committee_president)->name}}">
            </td>
            <th>الاسم</th>
            <td><input type="text" class="form-control" value="{{optional($supplier)->name}}"></td>
        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{'رئيس لجنة الإستلام الفرعية'}}"></td>
            <th>الرتبة</th>
            <td><input type="text" class="form-control" value="{{'المورد'}}"></td>
        </tr>
        <tr>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        </tbody>
    </table>
    <table rules="all" class="no-break mt-2">
        <tbody>
        <tr>
            <th colspan="2">عضو لجنة الإستلام الفرعية</th>
            <th colspan="2">عضو لجنة الإستلام الفرعية</th>
        </tr>
        <tr>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control"
                       value="{{isset($subsidiary_receiving_committee_member[0]) ? $subsidiary_receiving_committee_member[0]->name : ''}}">
            </td>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control"
                       value="{{isset($subsidiary_receiving_committee_member[1]) ? $subsidiary_receiving_committee_member[1]->name : ''}}">
            </td>
        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{'عضو لجنة الإستلام الفرعية'}}"></td>
            <th>الرتبة</th>
            <td><input type="text" class="form-control" value="{{'عضو لجنة الإستلام الفرعية'}}"></td>
        </tr>
        <tr>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        </tbody>
    </table>
</footer>
</body>
</html>
