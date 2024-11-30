@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div >
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>الرئيسية</h2>

                    </div>


                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(auth()->user()->isAdmin())
                                <section class="mt-2">
                                    <h3>التقريرات</h3>

                                    <div class="d-flex reports-cards">
                                        <a href="{{route('admin.analytics.imports')}}" class="btn btn-success">
                                            <i class="fa-solid fa-print"></i>
                                            <span>تقرير التوريدات</span>
                                        </a>
                                        <a href="{{route('admin.analytics.imports', ['showPrices' => true])}}" class="btn btn-warning">
                                            <div>
                                                <i class="fa-solid fa-print"></i>

                                            </div>
                                            <span>تقرير التوريدات بالأسعار </span>
                                        </a>
                                        <a href="{{route('admin.analytics.surplus')}}" class="btn btn-success">
                                            <i class="fa-solid fa-print"></i>
                                            <span>تقرير الوفر</span>
                                        </a>
                                        <a href="{{route('admin.analytics.surplus', ['showPrices' => true])}}" class="btn btn-warning">
                                            <div><i class="fa-solid fa-print"></i>
                                            </div>
                                            <span>تقرير الوفر بالأسعار  </span>
                                        </a>
                                    </div>
                                </section>
                            <section class="mt-5">
                                <h3><i class="fa-solid fa-"></i> إعدادات</h3>
                                <div class="d-flex reports-cards">
                                    <a href="{{route('admin.dates')}}" class="btn btn-primary">
                                        <i class="fa-regular fa-calendar-days"></i>
                                        <span>ترجمة التايخ</span>
                                    </a>
                                </div>

                            </section>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
