@extends('layouts.bordered-report')


@section('titlePaper')
    <h1>تقرير التفتيش</h1>
@endsection

@section('article')

    <table class="text-center">
        <tr>
            <th colspan="100">
                بيان بأعداد العمالة الموجودة بموقع صرف الإعاشة ب
                {{$formEmployment->import->report->office->name}}
                و حالتهم
            </th>
        </tr>

        <!-- Split Titles into Rows -->
        @foreach($titles->chunk(5) as $chunkedTitles)
            <tr>
                @foreach($chunkedTitles as $title)
                    <th colspan="2">{{$title}}</th>
                @endforeach
                @if($loop->last)
                    <th colspan="2">الملاحظات</th>
                @endif
            </tr>
            <tr>
                @foreach($chunkedTitles as $index => $title)
                    <th>المقرر</th>
                    <th>الموجود</th>
                @endforeach
                @if($loop->last)
                    <td colspan="2" rowspan="{{ ceil(count($titles) / 5) }}"></td>
                @endif
            </tr>
        @endforeach

        <!-- Display Counts -->
        @foreach($counts->chunk(5) as $chunkedCounts)
            <tr>
                @foreach($chunkedCounts as $count)
                    <td>{{$count['expected']}}</td>
                    <td>{{$count['real']}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>



    <p class="mt-3">
        السلام عليكم ورحمة الله وبركاته،
        <br>
        نفيدكم أنه جرى التفتيش على كافة العمالة لهذا اليوم الجمعة الموافق
        {{\App\Models\Day::convertDate2ArName($formEmployment->import->report->for_date)}}
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
            <th colspan="2">المشرف على موقع صرف الإعاشة ب{{$formEmployment->import->report->office->name}}</th>
        </tr>
        <tr>
            <th >">الاسم</th>
            <td>
                <input type="text" class="form-control" value="{{auth()->user()->name}}">
            </td>
            <th>الاسم</th>
            <td><input type="text" class="form-control" ></td>
        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{auth()->user()->rank}}"></td>
            <th>الرتبة</th>
            <td><input type="text" class="form-control" ></td>
        </tr>
        <tr>
            <th>التوقيع</th>
            <td><input type="text" class="form-control" ></td>
            <th>التوقيع</th>
            <td><input type="text" class="form-control" ></td>
        </tr>
        </tbody>
    </table>
@endsection
