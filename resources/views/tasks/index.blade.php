@extends('layouts.app')
@php($active = 'tasks')

@section('content')

    <div class="container">
        <x-message/>
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-right align-items-center gap-2">
                        <h2>مهام المقرات</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المقر</th>
                                <th>عدد المهام</th>
                            </tr>

                            </thead>
                            <tbody>
                            @forelse($offices as $office)
                                <tr>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration)}}</td>
                                    <td>
                                        <a href="{{route('admin.tasks.office', [$office->id])}}">
                                            {{$office->name}}
                                        </a>
                                    </td>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($office->tasks->count())}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        لا يوجد مقرات
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
