@php use Carbon\Carbon; @endphp
    <!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
    <script src="https://kit.fontawesome.com/1f4dd9add7.js" crossorigin="anonymous"></script>

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/print-page.css?7')}}">
    <link rel="stylesheet" href="{{asset('css/print-page-media.css?10')}}" media="print">
    <link href="{{asset('css/layout.css?8')}}" rel="stylesheet"/>
</head>
<body dir="rtl">
<x-nav :active="$active ?? null"></x-nav>
@yield('content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="{{asset('js/toggle_table.js?3')}}"></script>

</body>
</html>
