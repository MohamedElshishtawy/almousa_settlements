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
                        <x-message/>

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
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(++$n) }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->role_ar ?: 'لا يوجد' }}</td>
                                    <td>{{ $user->office ? $user->office->name : 'لا يوجد' }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="btn btn-primary btn-sm"><i class="fa-solid fa-edit"></i> تعديل</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.users.delete', $user->id) }}"
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
