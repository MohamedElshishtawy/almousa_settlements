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

    <title>محضر توريد كتابى</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css?3')}}">
</head>
<body dir="rtl" class="import-writing">
<main>

    <header>
        <div>
            <div>قوات أمن الحجاج</div>
            <div>الإمداد والتموين</div>
            <div>قيادة الإعاشة</div>
        </div>
        <div>
            <img src="{{asset('images/ramadan.jpg')}}" alt="">
        </div>
        <div></div>
        <div class="title">
            <h1>محضر توريد ({{$office->name}})</h1>
        </div>
    </header>

    <article>
        <div>
            محضر بتوريد وصرف كامل استحقاق المستفيدين من المواد الطازجة والجافة لإعاشة العاملين {{$office->living->title}} ب{{$office->name}} ليوم
            {{$Hijri['day-text']}} الموافق ({{$Hijri['year']}}/{{$Hijri['month']}}/{{$Hijri['day']}} هـ).

        </div>
        <div class="mt-5">
            لقد تم توريد وصرف كامل استحقاق المستفيدين من الوجبات الثلاث للمواد الطازجة والجافة والمطهية بعد مطابقتها بالشروط والمواصفات {{$report->import->importProductError->count() ? "ماعدا النقص الموضح في نموذج التوريد" : ''}}، وتم الإشراف على توزيعها وصرفها من موقع إعاشة العاملين بال{{$office->living->title}} بـ ({{$office->name}} وقد بلغ عدد المستفيدين في اليوم والتاريخ الموضح أعلاه ({{$report->import->benefits}}) مستفيد.
        </div>
        <div class="text-center">
            وجارى التأكد من ذلك وعلى مسؤوليتنا والله الموفق ،،،
        </div>
    </article>

    <footer>
        <table rules="all">
            <tbody>
            <tr>
                <th colspan="2">المورد أو من ينوب عنه</th>
                <th colspan="2">عضو لجنة الإستلام الفرعية</th>
            </tr>
            <tr>
                <th>الاسم</th>
                <td></td>
                <th>الاسم</th>
                <td></td>
            </tr>
            <tr>
                <th>المسمى</th>
                <td></td>
                <th>الرتبة</th>
                <td></td>
            </tr>
            <tr>
                <th>التوقيع</th>
                <td></td>
                <th>التوقيع</th>
                <td></td>
            </tr>
            </tbody>
        </table>
    </footer>
</main>
</body>
</html>
