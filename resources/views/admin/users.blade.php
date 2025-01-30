@extends('layouts.app')
@php($active = 'employee')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>إدارة الموظفين</h2>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm"><i
                                class="fa-solid fa-plus"></i> إضافة موظف</a>
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
                                <th scope="col">الهاتف</th>
                                <th scope="col">الرتبة</th>
                                <th scope="col">المقر</th>
                                <th scope="col">تعديل</th>
                                <th scope="col">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($n = 0)
                            @forelse ($employees as $employee)
                                <tr>
                                    <th scope="row">{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$n) }}</th>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->rank }}</td>
                                    <td>{{ $employee->employeeOffice ? $employee->employeeOffice->office->name : 'لا يوجد' }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $employee->id) }}"
                                           class="btn btn-primary btn-sm"><i class="fa-solid fa-edit"></i> تعديل</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.users.delete', $employee->id) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fa-solid fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا يوجد موظفين</td>
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
