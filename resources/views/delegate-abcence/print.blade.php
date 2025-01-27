@extends('layouts.bordered-report')

@section('titlePaper')
    <h1 class="text-center bold">محضر غياب مندوب</h1>
@endsection

@section('article')
    <p class="text-right mt-5">
        سعادة المشرف على موقع صرف الإعاشة ب
        <strong>{{ $delegateAbcence->delegate->office->name }}</strong>
    </p>
    <p class="text-right">
        السلام عليكم ورحمة الله وبركاته
    </p>
    <p class="text-right">
        نرفع لكم محضر غياب عن استلام وجبة ليوم
        <strong>{{ \App\Models\Day::DateToHijri($delegateAbcence->for_date) }}</strong>
        لمندوب الإعاشة رقم
        <strong>{{ $delegateAbcence->delegate->name }}</strong>
        وعددهم
        <strong>{{ $delegateAbcence->delegate->benefits }}</strong>
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
            <th colspan="2">رئيس المجموعة</th>
            <th colspan="2">تصديق الضابط المناوب</th>
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
            <td><input type="text" class="form-control" value="{{ auth()->user()->rank }}"></td>
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
