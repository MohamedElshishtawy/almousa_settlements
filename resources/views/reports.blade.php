@php use App\Models\Day; @endphp
@extends('layouts.app')
@php($active = 'reports')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>المحاضر</h2>
                    </div>

                    <x-message/>

                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif




                        @forelse ($officesReports as $officeName => $reports)
                            <div class="office-container" id="{{$reports[0]['office']->id}}">
                                <table
                                    class="table table-hover table-bordered table-small rounded-3 thead-light office-table @if(count($officesReports) == 1) show-table @endif">
                                    <thead>
                                    <tr class="thead-dark">
                                        <th colspan="100" class="text-center">{{$officeName}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">تسلسل</th>
                                        <th scope="col">التاريخ</th>
                                        @canany(['import_create', 'import_edit', 'import_delete', 'import_writing_print', 'import_print'])
                                            <th scope="col">التوريد</th>
                                        @endcanany
                                        @canany(['surplus_create', 'surplus_edit', 'surplus_delete', 'surplus_print'])
                                            <th scope="col">الوفر</th>
                                        @endcanany
                                        <th scope="col">المهمة</th>
                                        <th scope="col">نوع الإعاشة</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($n = 0)
                                    @forelse($reports as $report)
                                        <tr>
                                            <th scope="row">{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$n) }}</th>
                                            <td>{{ Day::DateToHijri($report['date']) }}</td>

                                            @canany(['import_create', 'import_edit', 'import_delete', 'import_writing_print', 'import_print'])
                                                <td>
                                                    {{--                                                    <a href="{{route('managers.reports.import', [$report['officeMission']->id, $report['date']])}}"--}}
                                                    {{--                                                       class="btn {{ $report['import'] ? 'btn-success' : 'btn-primary' }}">--}}
                                                    {{--                                                        <span>التوريد</span>--}}
                                                    {{--                                                        @if($report['import'])--}}
                                                    {{--                                                            <span><i--}}
                                                    {{--                                                                    class="fa-regular fa-circle-check fa-sm"></i></span>--}}
                                                    {{--                                                        @endif--}}
                                                    {{--                                                    </a>--}}
                                                </td>
                                            @endcanany

                                            @canany(['surplus_create', 'surplus_edit', 'surplus_delete', 'surplus_print'])
                                                <td>
                                                    {{--                                                    <a href="{{route('managers.reports.surplus', [$report['officeMission']->id, $report['date']])}}"--}}
                                                    {{--                                                       class="btn {{ $report['surplus'] ? 'btn-success' : 'btn-primary' }} @if(!$report['import']) disabled @endif">--}}
                                                    {{--                                                        <span>الوفر</span>--}}
                                                    {{--                                                        @if($report['surplus'])--}}
                                                    {{--                                                            <span><i--}}
                                                    {{--                                                                    class="fa-regular fa-circle-check fa-sm"></i></span>--}}
                                                    {{--                                                        @endif--}}
                                                    {{--                                                    </a>--}}
                                                </td>
                                            @endcanany

                                            <td>{{ $report['officeMission']->mission->title }}</td>
                                            <td>{{ $report['office']->living->title }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">لا يوجد محاضر</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @empty
                            <div class="alert alert-warning text-center">لا يوجد محاضر</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

