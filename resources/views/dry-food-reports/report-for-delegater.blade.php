@extends('layouts.bordered-report')

@section('title', 'إقرار إستلام الجاف - ' . $delegate->name . ' - ' . $formatedDate)

@section('header-right')
    <div>إعاشة الميدان</div>
    <div>{{$delegate ? $delegate->office->name : 'المقر'}}</div>
@endsection
@section('titlePaper')
    <h4 class="text-center">
        إقرار وتعهد بتاريخ
        <br>
        {{$formatedDate}}

    </h4>
@endsection

@section('article')
    <p>
        أقر أنا
        <span>{{$delegate->rank}}</span>/<strong>{{$delegate->name}}</strong>
        مندوب
        <span>{{$delegate->institution}}</span>
        وعدد المستفيدين
        <span>{{$delegate->benefits}}</span>
        شخص
        بأنني قد إستلمت كامل المخصص من الإعاشة الجافة وبحالة جيدة اعتباراً من تاريخ
        <span>{{$formatedDate}}</span>
        إلى تاريخ
        <span>{{$formatedDate}}</span>
        ، وإنى مسؤولاً عن الإعاشة غير المطهية. ويوجد لدي أماكن تخزين وتبريد.
    </p>

    <div class="text-center mt-5">
        عليه جرى توقيعي بذلك،،،
    </div>
@endsection
@section('footer')
    <table rules="all" class="no-break">
        <tbody>
        <tr>
            <th>اسم المندوب</th>
            <td>
                <input type="text" class="form-control" value="{{$delegate->name}}">
            </td>
        </tr>
        <tr>
            <th>الرتبة</th>
            <td><input type="text" class="form-control" value="{{$delegate->role_ar}}"></td>
        </tr>
        <tr>
            <th>رقم الجوال</th>
            <td><input type="text" class="form-control" value="{{$delegate->phone}}"></td>
        </tr>
        <tr>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        </tbody>
    </table>
@endsection

