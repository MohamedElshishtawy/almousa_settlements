@extends('layouts.bordered-report')

@section('header-right')
    <div>إعاشة
        {{$obligations->office->living->title}}
    </div>
    <div>{{$obligations->office->name}}</div>
@endsection

@section('header-left')
    <div>رقم التسلسل</div>
@endsection
@section('titlePaper')
    <h1>محضر بتاريخ
        {{\App\Models\HijriDate::formatedDate($obligations->created_at->format('Y-m-d'))}}</h1>
@endsection

@section('article')
    <div>
        إنه فى ليوم
        {{\App\Models\Day::DateToHijri($obligations->created_at->format('Y-m-d'))}}
        الموافق للتاريخ أعلاه بمعرفتى انا
        {{auth()->user()->role_ar}}/{{auth()->user()->name}}
        ومن خلال مباشرة أعمال الإعاشة بمقر
        {{$obligations->office->name}}
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
        وبناء عليه قد تم إبلاغ متعهد الشركة بوجود هذه الملاحظات وأخذ توقيعه وحتى تاريخه لم يقم بمعالجتها وعليه
        تم إعداد هذا
        المحضر حفظا بالواقعة.
    </div>


    <div class="text-center">
        وعلى ذلك جرى التوقيع،،،
    </div>
@endsection

@section('footer')
    <table rules="all" class="no-break mt-2">
        <tbody>
        <tr>
            <th colspan="2">المورد أو من ينوب عنه</th>
            <th colspan="2">عضو لجنة الإستلام الفرعية</th>
        </tr>
        <tr>
            <th>الاسم</th>
            <td><input type="text" class="form-control" value="{{optional($supplier)->name}}"></td>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control"
                       value="{{isset($subsidiary_receiving_committee_member[0]) ? $subsidiary_receiving_committee_member[0]->name : ''}}">
            </td>
        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{'المورد'}}"></td>
            <th>المسمى</th>
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
    <table rules="all" class="no-break mt-2">
        <tbody>
        <tr>
            <th colspan="2">رئيس لجنة الإستلام الفرعية</th>
        </tr>
        <tr>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control"
                       value="{{optional($subsidiary_receiving_committee_president)->name}}">
            </td>

        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{'رئيس لجنة الإستلام الفرعية'}}"></td>
        </tr>
        <tr>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        </tbody>
    </table>

@endsection




