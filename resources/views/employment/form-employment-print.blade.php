@extends('layouts.bordered-report')


@section('titlePaper')
    <h1>تقرير أعداد العاملة وحالتهم</h1>
@endsection

@section('article')

    <table class="text-center">
        <tr>
            <th colspan="100">
                بيان بأعداد العمالة الموجودة بمقر صرف الإعاشة ب
                {{$formEmployment->import->report->office->name}}
                و حالتهم
            </th>
        </tr>
        <!-- Split Titles into Rows -->
        @foreach(collect($titleAndCountsArr)->chunk(5) as $titleAndCountsArrChunked)
            <tr>
                @foreach($titleAndCountsArrChunked as $titleAndCounts)
                    <th colspan="2">{{$titleAndCounts['title']}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($titleAndCountsArrChunked as $titleAndCounts)
                    <td>المقرر</td>
                    <td>الموجود</td>
                @endforeach
            </tr>
            <tr>
                @foreach($titleAndCountsArrChunked as $titleAndCounts)
                    <td>{{$titleAndCounts['expected']}}</td>
                    <td>{{$titleAndCounts['real']}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>




    <p class="mt-3">
        السلام عليكم ورحمة الله وبركاته،
        <br>
        نفيدكم أنه جرى التفتيش على كافة العمالة لهذا اليوم
        {{\App\Models\Day::convertDate2ArName($formEmployment->import->report->for_date)}}
        الموافق
        {{\App\Models\Day::DateToHijri($formEmployment->import->report->for_date)}}
        و الموضح أعدادهم فى الجدول أعلاه وأتضح ما يلى:
    </p>
    <table>
        <tr>
            <th class="w-25">الأعداد</th>
            <td>{{$formEmployment->count_state}}</td>
        </tr>
        <tr>
            <th class="w-25">النظافة</th>
            <td>{{$formEmployment->cleaning_state}}</td>
        </tr>
        <tr>
            <th class="w-25">الشهادة الصحية</th>
            <td>{{$formEmployment->health_state}}</td>
        </tr>
    </table>
    <p class="mt-3">
        علما بأنه تم إبلاغ المتعهد بذلك وأخذ توقيعه أدناه.
        <br>
        لذا نأمل الإحاطة بذلك.
    </p>
    <p class="text-center">
        <strong>ولسعادتكم تحياتى و تقديرى</strong>
    </p>
@endsection

@section('footer')
    <table rules="all" class="no-break">
        <tbody>
        <tr>
            <th colspan="2">المتعهد أو من ينوب عنه</th>
            <th colspan="2">رئيس لجنة الإستلام الفرعية</th>
        </tr>
        <tr>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control" value="{{auth()->user()->name}}">
            </td>
            <th>الاسم</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{auth()->user()->role_ar}}"></td>
            <th>الرتبة</th>
            <td><input type="text" class="form-control"></td>
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

        </tr>
        <tr>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control" value="{{auth()->user()->name}}">
            </td>
        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{auth()->user()->role_ar}}"></td>
        </tr>
        <tr>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        </tbody>
    </table>
@endsection
