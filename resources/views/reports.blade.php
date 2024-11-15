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


                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>q
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">تسلسل</th>
                                <th scope="col">التاريخ</th>
                                <th scope="col">الإرادات</th>
                                <th scope="col">الوفر</th>
                                <th scope="col">المقر</th>
                                <th scope="col">المهمة</th>
                                <th scope="col">المعايش</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php($n = 0)

                            @forelse ($days as $day)

                                <tr>
                                    <th scope="row">{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$n) }}</th>
                                    <td>{{ $day['date'] }}</td>

                                    @if($day['import'])
                                        <td>
                                            <a href="{{route('managers.reports.import', [$day['officeMission']->id, $day['date']])}}"  class="btn btn-success">
                                                <span>التوريد</span>
                                                <span><i class="fa-regular fa-circle-check fa-sm"></i></span>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{route('managers.reports.import', [$day['officeMission']->id, $day['date']])}}" class="btn btn-primary">
                                                <span>التوريد</span>
                                            </a>
                                        </td>
                                    @endif

                                    @if($day['surplus'])
                                        <td>
                                            <a href="{{route('managers.reports.surplus', [$day['officeMission']->id, $day['date']])}}"  class="btn btn-success">
                                                <span>الوفر</span>
                                                <span><i class="fa-regular fa-circle-check fa-sm"></i></span>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{route('managers.reports.surplus', [$day['officeMission']->id, $day['date']])}}" class="btn btn-primary @if(!$day['import']) disabled  @endif"  >
                                                <span>الوفر</span>
                                            </a>
                                        </td>
                                    @endif


                                    <td>{{ $day['office']->name }}</td>
                                    <td>{{ $day['officeMission']->mission->title }}</td>
                                    <td>{{ $day['office']->living->title }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا يوجد محاضر</td>
                            @endforelse
                            </tbody>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

