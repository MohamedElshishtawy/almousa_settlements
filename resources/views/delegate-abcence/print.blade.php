@extends('layouts.bordered-report')

@section('titlePaper')

@endsection
@section('header-right')
    الإمداد و التموين
    <br>
    قيادة الإعاشة
    <br>
    إعاشة
    {{$delegateAbcence->delegate->office->living->title}}
    <br>
    {{$delegateAbcence->delegate->office->name}}
@endsection
@section('header-left')
    <span class="text-center align-items-center">محضر غياب مندوب</span>
@endsection
@section('article')
    <div class="text-right my-2 text-center">
        <strong>سعادة المشرف على موقع صرف الإعاشة ب
            <span>{{ $delegateAbcence->delegate->office->name }}</span></strong>
    </div>
    <p class="text-right">
        السلام عليكم ورحمة الله وبركاته
    </p>
    <p class="text-right">
        نرفع لكم محضر غياب عن استلام وجبة
        ال{{$delegateAbcence->meal->name}}
        ليوم
        <span>{{ \App\Models\Day::DateToHijri($delegateAbcence->for_date) }}</span>
        لمندوب الإعاشة رقم
        ({{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($delegateAbcence->delegate->number)}})
        مندوب إعاشة
        {{$delegateAbcence->delegate->institution}}
        وعددهم
        <span>({{ $delegateAbcence->delegate->benefits }})</span>
        مستفيد

    </p>
    <p class="text-right">
        نأمل الإطلاع والتوجيه حيال ذلك.
    </p>
    <p class="text-center">
        <strong>ولكم تحياتي...</strong>
    </p>
@endsection

@section('footer')
    <table class="table text-center" style="width: 100%; border: 1px solid black;">
        <thead>
        <tr>
            <th colspan="2">معد المحضر</th>
            <th colspan="2">تصديق رئيس المجموعة</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>الاسم:</td>
            <td><input type="text" class="form-control" value="{{ auth()->user()->name }}"></td>
            <td>الاسم:</td>
            <td><input type="text" class="form-control"></td>
        </tr>
        <tr>
            <td>الرتبة:</td>
            <td><input type="text" class="form-control" value="{{ auth()->user()->role_ar }}"></td>
            <td>الرتبة:</td>
            <td><input type="text" class="form-control"></td>
        </tr>
        <tr>
            <td>التوقيع:</td>
            <td><input type="text" class="form-control"></td>
            <td>التوقيع:</td>
            <td><input type="text" class="form-control"></td>
        </tr>
        </tbody>
    </table>
@endsection
