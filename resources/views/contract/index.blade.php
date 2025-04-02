@extends('layouts.app')
@php($active = 'contract')
@section('content')
    <div class="container">
        <x-message/>
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-2">
                        <h2>العقود</h2>
                        {{--                        @can('create_contract')--}}
                        <a href="{{ route('contract.create') }}" class="btn btn-success btn-sm">
                            عقد جديد
                            <i class="fa fa-plus "></i>
                        </a>
                        {{--                        @endcan--}}
                    </div>

                    <div class="card-body table-responsive">
                        @forelse($contracts as $contract)
                            <section class="shadow-sm p-3 mb-5 bg-white rounded">

                            </section>
                        @empty
                            <div class="alert alert-info">لا يوجد عقود</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
