@php use Carbon\Carbon; @endphp
@extends('analytics.print-layout')
@php($active = 'units')
@section('content')
    <div class="container">
        <x-message/>
        <div class="row justify-content-center">
            <div>
                @livewire('analytics.import-analytics', ['showPrices' => $showPrices])
            </div>
        </div>
    </div>
@endsection
