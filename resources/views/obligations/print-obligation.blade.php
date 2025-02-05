@php use App\Models\Day; @endphp
@php use Alkoumi\LaravelArabicNumbers\Numbers; @endphp
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/print-page-media.css?10')}}" media="print">
    <title>بيان رفض مندوب إستلام صنف {{ Day::DateToHijri(now()->format('Y-m-d')) }}</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css?9')}}">
</head>
<body dir="rtl" class="import-writing m-3 ">
<main class="bordered-paper mt-4  ">
    <div>
        <header>
            <div>
                <div>إعاشة الميدان</div>
                <div>{{$obligations->office->name}}</div>
            </div>
            <div></div>
            <div>
                <div>رقم التسلسل</div>
            </div>
            <div class="title">
                <h4>إقرار بتاريخ
                    {{\App\Models\HijriDate::formatedDate($obligations->created_at->format('Y-m-d'))}}</h4>
            </div>
        </header>

        <article class="centered">
            <div>
                إنه فى يوم
                {{$dateHijri['weekday']}}
                الموافق للتاريخ أعلاه انه بمعرفتى انا رئيس لجنة الإستلام الفرعية
                {{auth()->user()->role_ar}}/{{auth()->user()->name}}
                ومن خلال مباشرة أعمال الإعاشة بمقر
                {{$obligations->office->name}}
                {{$obligations->office->living->title}}
                حيث رصد عدة ملاحظات على متعهد الإعاشة وهى كالأتى:-
                <ul class="my-4">
                    @foreach($obligations->bands as $band)
                        @if($band->is_active)
                            <li>{{$band->head}}</li>
                            @if($band->description)
                                <ul class="mb-2">
                                    <li>{{$band->description}}</li>
                                </ul>
                            @endif
                        @endif
                    @endforeach
                </ul>
                وبناء عليه قد تم إبلاغ متعهد الشركة بوجود هذه الملاحظات وحتى تاريخه لم يقم بمعالجتها وعليه تم إعداد هذا
                المحضر حفظا بالواقعة.
            </div>


            <div class="text-center">
                وعلى ذلك جرى التوقيع،،،
            </div>
        </article>
    </div>

    <footer>
        <table rules="all" class="no-break">
            <tbody>
            <tr>
                <th>الاسم</th>
                <td>
                    <input type="text" class="form-control" value="{{auth()->user()->name}}">
                </td>
            </tr>
            <tr>
                <th>الرتبة</th>
                <td><input type="text" class="form-control" value="{{auth()->user()->role_ar}}"></td>
            </tr>
            <tr>
                <th>التوقيع</th>
                <td><input type="text" class="form-control"></td>
            </tr>
            </tbody>
        </table>
    </footer>
</main>


</body>
</html>
