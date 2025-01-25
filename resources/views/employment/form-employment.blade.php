@extends('layouts.app')
@php($active = 'reports')
@section('css')
    <link href="{{ asset('css/products.css?3') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mx-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    @livewire('form-employment-livewire', ['import' => $import])
                </div>
            </div>
        </div>
    </div>
@endsection

