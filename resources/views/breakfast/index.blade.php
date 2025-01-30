@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>تقارير الإفطار</h2>
                        <a href="{{ route('breakfast.create') }}" class="btn btn-success btn-sm"><i
                                class="fa-solid fa-plus"></i> إنشاء تقرير </a>
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
                                <th scope="col">#</th>
                                <th scope="col">التاريخ</th>
                                <th scope="col">الملاحظات</th>
                                <th scope="col">عدد المندوبين</th>
                                <th scope="col">تعديل</th>
                                <th scope="col">طباعة</th>
                                <th scope="col">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($breakFastReports as $report)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $report->for_date }}</td>
                                    <td>{{ $report->notes ?: 'لا توجد ملاحظات' }}</td>
                                    <td>{{ $report->breakFastReportDelegates->count() }}</td>
                                    <td>
                                        <a href="{{ route('breakfast.edit', $report->id) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i> تعديل
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('breakfast.print', $report->id) }}"
                                           class="btn btn-secondary btn-sm">
                                            <i class="fa-solid fa-print"></i> طباعة
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('breakfast.destroy', $report->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('هل أنت متأكد من الحذف؟');">
                                                <i class="fa-solid fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد تقارير إفطار</td>
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
