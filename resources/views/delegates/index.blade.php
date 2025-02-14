@extends('layouts.app')
@php($active = 'delegates')
@section('content')
    <x-message/>
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>إدارة المناديب</h2>
                        <a href="{{ route('admin.delegates.create') }}" class="btn btn-success btn-sm"><i
                                class="fa-solid fa-plus"></i> إضافة مندوب</a>
                    </div>

                    <div class="card-body table-responsive">


                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">الرقم بالكشف</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">الجهة</th>
                                <th scope="col">الرتبة</th>
                                <th scope="col">عدد المستفيدين</th>
                                <th scope="col">نوع الصرف</th>
                                <th scope="col">المقر الحالى</th>
                                <th scope="col">الجوال</th>
                                <th scope="col">تعديل</th>
                                <th scope="col">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($n = 0)
                            @forelse ($delegates as $delegate)
                                <tr>
                                    <th scope="row">{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($delegate->number) }}</th>
                                    <td>{{ $delegate->name }}</td>
                                    <td>{{ $delegate->institution }}</td>
                                    <td>{{ $delegate->rank}}</td>
                                    <td>{{ $delegate->benefits}}</td>
                                    <td>{{ $delegate->foodType->title}}</td>
                                    <td>{{ $delegate->office->name}}</td>
                                    <td>{{ $delegate->phone}}</td>

                                    <td>
                                        <a href="{{ route('admin.delegates.edit', $delegate->id) }}"
                                           class="btn btn-primary btn-sm"><i class="fa-solid fa-edit"></i> تعديل</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.delegates.delete', $delegate->id) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm confirm-btn"><i
                                                    class="fa-solid fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100" class="text-center">لا يوجد مندوبين</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center mt-5">
                <div>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2>تاريخ كل مندوب</h2>
                        </div>

                        <div class="card-body table-responsive">
                            @forelse($delegateHistory as $delegateName => $delegateHistories)
                                <table class="table mb-3">
                                    <thead>
                                    <tr>
                                        <th colspan="100">{{$delegateName}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">الرقم بالكشف</th>
                                        <th scope="col">الاسم</th>
                                        <th scope="col">الجهة</th>
                                        <th scope="col">الرتبة</th>
                                        <th scope="col">عدد المستفيدين</th>
                                        <th scope="col">نوع الصرف</th>
                                        <th scope="col">المقر الحالى</th>
                                        <th scope="col">الجوال</th>
                                        <th scope="col">فعال من</th>
                                        <th scope="col">إنتهاء فى</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($delegateHistories as $delegate)
                                        <tr>
                                            <th scope="row">{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($delegate->number) }}</th>
                                            <td>{{ $delegate->name }}</td>
                                            <td>{{ $delegate->institution }}</td>
                                            <td>{{ $delegate->rank}}</td>
                                            <td>{{ $delegate->benefits}}</td>
                                            <td>{{ $delegate->foodType->title}}</td>
                                            <td>{{ $delegate->office->name}}</td>
                                            <td>{{ $delegate->phone}}</td>
                                            @if ($delegate->affected_at && $delegate->terminated_at )
                                                <td>{{ $delegate->affected_at }}</td>
                                                <td>{{ $delegate->terminated_at  }}</td>
                                            @else
                                                <td colspan="2">حالى</td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">لا يوجد تعديلات بعد</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            @empty
                                <tr>
                                    <td colspan="100" class="text-center ">لا يوجد تعديلات</td>
                                </tr>
                            @endforelse

                        </div>
                    </div>
                </div>


            </div>
        </div>
@endsection
