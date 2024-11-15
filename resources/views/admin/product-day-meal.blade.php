@extends('layouts.app')
@php($active = 'products')
@section('css')
    <link href="{{ asset('css/products.css?2') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mx-2">
        @livewire('products-days-meals-manager', ['mission'=>$mission, 'living'=>$living])
    </div>
@endsection
