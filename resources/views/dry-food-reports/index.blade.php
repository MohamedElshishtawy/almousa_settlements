@extends('layouts.app')

@section('content')
    <div class="container">
        <x-message/>
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>محاضر الأصناف الجافة</h2>
                        @can('dry_food_create')
                            <a href="{{route('dry-food-reports.create')}}" class="btn btn-success">إضافة</a>
                        @endcan
                    </div>


                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المندوب</th>
                                <th>المستفيدين</th>
                                <th>الجهة</th>
                                <th>بداية الصرف</th>
                                <th>نهاية الصرف</th>
                                <th>عدد ايام الصرف</th>
                                <th>يوم التسجيل</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($n = 1)
                            @forelse ($dryFoodReports as $dryFoodReport)
                                <tr>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($n++)}}</td>
                                    <td>{{$dryFoodReport->delegate->name}}</td>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($dryFoodReport->delegate->benefits)}}</td>
                                    <td>{{$dryFoodReport->delegate->institution}}</td>
                                    <td>{{\App\Models\Day::DateToHijri($dryFoodReport->start_date)}}</td>
                                    <td>{{\App\Models\Day::DateToHijri($dryFoodReport->end_date)}}</td>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(count(\App\Models\Day::datesBetween($dryFoodReport->start_date, $dryFoodReport->end_date)))}}</td>
                                    <td>{{\App\Models\Day::DateToHijri($dryFoodReport->created_at->format('Y-m-d'))}}</td>
                                    <td>
                                        <a href="{{route('dry-food-reports.print', $dryFoodReport->id)}}"
                                           class="btn btn-info">طباعة</a>
                                        <a href="{{route('dry-food-reports.edit', $dryFoodReport->id)}}"
                                           class="btn btn-primary">تعديل</a>
                                        <form action="{{route('dry-food-reports.destroy', $dryFoodReport->id)}}"
                                              method="post" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger confirm-btn">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100" class="text-center">لا يوجد محاضر</td>
                                </tr>
                            @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
