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
                أُقر أنا <strong>{{$delegate->name}}</strong> مندوب <strong>{{$delegate->institution}}</strong> وعدد المستفيدين <strong>{{$delegate->benefits}}</strong>، بأنني قد إستلمت كامل المخصص من الإعاشة الجافة وعمالة جيدة اعتباراً من تاريخ {{\App\Models\Day::DateToHijri($dryFoodReport->start_date)}} إلى تاريخ {{\App\Models\Day::DateToHijri($dryFoodReport->end_date)}}، ولن أكون مسؤولاً عن الإعاشة غير المطهية. ويوجد لدي أماكن تخزين وترتيب.
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
                    <td><input type="text" class="form-control" value="{{$delegate->rank}}"></td>
                </tr>
                <tr>
                    <th>رقم التلفون</th>
                    <td><input type="text" class="form-control" value="{{$delegate->phone}}"></td>
                </tr>
                <tr>
                    <th>التوقيع</th>
                    <td><input type="text" class="form-control"></td>
                </tr>
                </tbody>
            </table>
        @endsection

