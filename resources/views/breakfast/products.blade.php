@extends('layouts.app')
@php($active = 'products')
@section('css')
    <link href="{{ asset('css/products.css?3') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mx-2">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    @livewire('breakfast-products-livewire')
                </div>
            </div>
        </div>
    </div>
@endsection
