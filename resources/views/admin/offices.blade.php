@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>إدارة المقرات</h2>
                        <a href="{{ route('admin.office.create') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> إضافة مقر</a>
                    </div>


                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">الترتيب</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">المهمة</th>
                                <th scope="col">المعايش</th>
                                <th colspan="2"> تجهيز</th>
                                <th colspan="2">الرئيسية</th>

                                <th scope="col">تعديل</th>
                                <th scope="col">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($n = 0)
                            @forelse ($offices as $office)
                                @php($mainOfficeMission = $office->OfficeMissions()->whereNotIn('mission_id', \App\Mission\Mission::gettingReadyMissionsIds())->first())
                                @php($getReadyOfficeMission = $office->OfficeMissions()->whereNot('id',$mainOfficeMission->id)->first())
                                <tr id="{{$office->id}}">
                                    <th scope="row">{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$n) }}</th>
                                    <td>{{ $office->name }}</td>
                                    <td>{{$mainOfficeMission->mission->title}}</td>
                                    <td>{{ $office->living->title }}</td>
                                    <td>{{ $getReadyOfficeMission->start_date }}</td>
                                    <td>{{ $getReadyOfficeMission->end_date }}</td>
                                    <td>{{ $mainOfficeMission->start_date }}</td>
                                    <td>{{ $mainOfficeMission->end_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.office.edit', $office->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-edit"></i> تعديل</a>
                                    </td>
                                    <td>
                                        <form action="{{route('admin.office.delete', $office->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا يوجد مقرات</td>
                            @endforelse
                            </tbody>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
