@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div >
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>محاضر على المتعهد</h2>
                        <a href="{{route('obligations.create')}}" class="btn btn-success">إضافة</a>
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
                                <th>اليوم</th>
                                <th>المقر</th>
                                <th>تعديل</th>
                                <th>طباعة</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($obligations as $obligation)
                                <tr>
                                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration)}}</td>
                                    <td>{{\App\Models\Day::DateToHijri($obligation->created_at->format('Y-m-d'))}}</td>
                                    <td>{{$obligation->office->name}}</td>
                                    <td>
                                        <a href="{{route('obligations.edit', $obligation->id)}}" class="btn btn-primary">
                                            تعديل
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('obligations.print', $obligation->id)}}" class="btn btn-primary">
                                            طباعة
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{route('obligations.destroy', $obligation->id)}}" method="post" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا يوجد محاضر</td>
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

