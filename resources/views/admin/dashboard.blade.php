@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
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

                        <section class="mt-2">
                            <h3>التقريرات</h3>
                            <div class="d-flex reports-cards">
                                @can('import_model2_create')
                                    <a href="{{route('admin.analytics.imports')}}" class="btn btn-success">
                                        <i class="fa-solid fa-print"></i>
                                        <span>تقرير التوريدات</span>
                                    </a>
                                @endcan
                                @can('import_model2_create_price')
                                    <a href="{{route('admin.analytics.imports', ['showPrices' => true])}}"
                                       class="btn btn-warning">
                                        <div>
                                            <i class="fa-solid fa-print"></i>
                                        </div>
                                        <span>تقرير التوريدات بالأسعار </span>
                                    </a>
                                @endcan
                                @can('surplus_model2_create')
                                    <a href="{{route('admin.analytics.surplus')}}" class="btn btn-success">
                                        <i class="fa-solid fa-print"></i>
                                        <span>تقرير الوفر</span>
                                    </a>
                                @endcan
                                @can('surplus_model2_price')
                                    <a href="{{route('admin.analytics.surplus', ['showPrices' => true])}}"
                                       class="btn btn-warning">
                                        <div><i class="fa-solid fa-print"></i>
                                        </div>
                                        <span>تقرير الوفر بالأسعار  </span>
                                    </a>
                                @endcan
                                @can('view_beneficiaries_report')
                                    <a href="{{route('admin.analytics.benefits')}}" class="btn btn-success">
                                        <i class="fa-solid fa-users"></i>
                                        <span>بيان المستفيدين</span>
                                    </a>
                                @endcan
                            </div>
                        </section>

                        <section class="mt-5">
                            <h3><i class="fa-solid fa-"></i> محاضر</h3>
                            <div class="d-flex reports-cards">
                                @can('delegate_rejects_management')
                                    <a href="{{route('papers.doesNotWant')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-user-xmark "></i>
                                        <span>بيان رفض المندوب صنف</span>
                                    </a>
                                @endcan
                                @canany(['delegate_absence_create','delegate_absence_edit'])
                                    <a href="{{route('delegate-absence')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-user-xmark "></i>
                                        <span>غياب مندوب (قابل للحفظ)</span>
                                    </a>
                                @endcanany
                                @canany(['dry_food_create','dry_food_edit','dry_food_delete','dry_food_print'])
                                    <a href="{{ route('dry-food-reports') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-apple-whole"></i>
                                        <span>محاضر المواد الجافة</span>
                                    </a>
                                @endcanany
                                @can('break_fast_products_manage')
                                    <a href="{{route('breakfast.index')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-bread-slice"></i>
                                        <span>محضر الإفطار</span>
                                    </a>
                                @endcan
                                @can('view_supplier_record')
                                    <a href="{{route('obligations')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-screwdriver-wrench"></i>
                                        <span>محضر على المتعهد</span>
                                    </a>
                                @endcan
                            </div>
                        </section>


                        <section class="mt-5">
                            <h3><i class="fa-solid fa-"></i> إعدادات</h3>
                            <div class="d-flex reports-cards">
                                @can('manage_dates')
                                    <a href="{{route('admin.dates')}}" class="btn btn-primary">
                                        <i class="fa-regular fa-calendar-days"></i>
                                        <span>ترجمة التايخ</span>
                                    </a>
                                @endcan
                                @can('manage_companies')
                                    {{-- Added can gate --}}
                                    <a href="{{route('admin.companies')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-handshake"></i>
                                        <span>شركة الموسم</span>
                                    </a>
                                @endcan
                                @canany(['employment_create','employment_edit','employment_delete'])
                                    {{-- Added can gate --}}
                                    <a href="{{route('admin.employment')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-users"></i>
                                        <span>إعدادات العمالة</span>
                                    </a>
                                @endcanany
                                @can('unites_management')
                                    {{-- Added can gate --}}
                                    <a href="{{route('admin.units')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-ruler"></i>
                                        <span>وحدات العد</span>
                                    </a>
                                @endcan
                                @can('break_fast_products_manage')
                                    {{-- Added can gate --}}
                                    <a href="{{route('admin.breakfast-products')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-products"></i>
                                        <span>أصناف الإفطار</span>
                                    </a>
                                @endcan
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
