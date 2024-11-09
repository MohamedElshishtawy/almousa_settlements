@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>إدارة الأصناف</h2>
                    </div>

                    <div class="categories tours">
                        <div class="all-products">
                            <a href="{{route('admin.products.all')}}">
                                <h3>إدارة جميع الأصناف</h3>
                            </a>
                        </div>

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
{{--                        <div class="tour">--}}
{{--                            <div class="img-div">--}}
{{--                                <a href="{{route('admin.products.specific', [1, 1])}}">--}}
{{--                                    <img src="{{asset('images/hij.jpg')}}" alt="">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="tour-info">--}}
{{--                                <h3>أصناف حج قيادة</h3>--}}
{{--                                <p class="des">--}}
{{--                                    <span>عدد الأصناف:</span>--}}
{{--                                    <strong>{{$counts[\App\Mission\Mission::$missions[0]][App\Living\Living::$livings[0]]}}</strong>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="tour">--}}
{{--                            <div class="img-div">--}}
{{--                                <a href="{{route('admin.products.specific', [1, 2])}}">--}}
{{--                                    <img src="{{asset('images/hij-midan.jpg')}}" alt="">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="tour-info">--}}
{{--                                <h3>أصناف حج ميدان</h3>--}}
{{--                                <p class="des">--}}
{{--                                    <span>عدد الأصناف:</span>--}}
{{--                                    <strong>{{$counts[\App\Mission\Mission::$missions[0]][App\Living\Living::$livings[1]]}}</strong>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="tour">--}}
{{--                            <div class="img-div">--}}
{{--                                <a href="{{route('admin.products.specific', [2, 1])}}">--}}
{{--                                    <img src="{{asset('images/ramadan-vip.jpg')}}" alt="">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="tour-info">--}}
{{--                                <h3>أصناف رمضان قيادة</h3>--}}
{{--                                <p class="des">--}}
{{--                                    <span>عدد الأصناف:</span>--}}
{{--                                    <strong>{{$counts[\App\Mission\Mission::$missions[1]][App\Living\Living::$livings[0]]}}</strong>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="tour">--}}
{{--                            <div class="img-div">--}}
{{--                                <a href="{{route('admin.products.specific', [2, 2])}}">--}}
{{--                                    <img src="{{asset('images/ramadan.jpg')}}" alt="">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="tour-info">--}}
{{--                                <h3>أصناف رمضان ميدان</h3>--}}
{{--                                <p class="des">--}}
{{--                                    <span>عدد الأصناف:</span>--}}
{{--                                    <strong>{{$counts[\App\Mission\Mission::$missions[1]][App\Living\Living::$livings[1]]}}</strong>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
