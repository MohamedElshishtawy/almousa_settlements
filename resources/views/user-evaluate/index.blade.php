@extends('layouts.app')
@php($active = 'units')
@section('content')
    <div class="container">
        <x-message/>
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-right align-items-center gap-2">
                        <h2>تقييم الموظفين</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الموظف</th>
                                <th>إتمام</th>
                            </tr>

                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration)}}</td>
                                    <td>
                                        <a href="{{route('admin.evaluate.user', [$user->id])}}">
                                            {{$user->name}}
                                        </a>
                                    </td>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(0)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100">
                                        <div class="alert alert-info text-center">
                                            لا يستوجب عليك تقييم أحد
                                        </div>
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
