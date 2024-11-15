@extends('layouts.app')
@php($active = 'products')
@section('css')
    <link href="{{ asset('css/products.css?2') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mx-2">
        <div class="row justify-content-center">
            <div >
                <div class="card">
                    @livewire('all-products-manager')
                </div>
            </div>
        </div>
    </div>
@endsection
