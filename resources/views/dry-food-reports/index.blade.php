@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div >
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>محاضر الأصناف الجافة</h2>

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
                                    <th>المندوب</th>
                                    <th>المستفيدين</th>
                                    <th>الجهة</th>
                                    <th>تم الصرف يوم</th>
                                    <th>عدد ايام الصرف</th>
                                    <th>عدد ايام الصرف</th>
                                    <th>بداية الصرف</th>
                                    <th>نهاية الصرف</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php($n = 1)
                                @foreach ($dryFoodReports as $dryFoodReport)
                                    <tr>
                                        <td>{{$n++}}</td>

                                    </tr>
                                @endforeach
                            </tbody>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
