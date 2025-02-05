@extends('layouts.app')
@php($active = 'products')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>إدارة الأصناف</h2>
                    </div>

                    <div class="categories tours">
                        @role('admin')
                        <div class="all-products">
                            <a href="{{route('admin.products.all')}}">
                                <h3>إدارة جميع الأصناف</h3>
                            </a>
                        </div>

                        <div class="all-products">
                            <a href="{{route('admin.breakfast-products')}}">
                                <h3>إدارة أصناف الفطور</h3>
                            </a>
                        </div>
                        @endrole

                        @foreach(\App\Mission\Mission::all()->sortBy('title') as $mission)
                            @foreach(\App\Living\Living::all() as $living)
                                <div>
                                    <a href="{{route('admin.products.specific', [$mission->id, $living->id])}}">
                                        <h3>أصناف {{$mission->title}} {{$living->title}}</h3>
                                        <p class="des">
                                            <span>عدد الأصناف:</span>
                                            <strong>{{$counts[$mission->id][$living->id]}}</strong>
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
