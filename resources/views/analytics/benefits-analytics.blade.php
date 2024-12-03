@extends('analytics.print-layout')
@section('title', 'طباعة تقارير التوريد')

@section('content')
    <div class="mx-2">
        <div class="row justify-content-center">
            <div >
                <div class="">
                    @livewire('analytics.benefits-analytics')
                </div>
            </div>
        </div>
    </div>
@endsection
