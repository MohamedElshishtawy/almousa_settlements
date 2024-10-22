@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="mx-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @livewire('products-manager', ['mission' => $mission, 'living' => $living])
            </div>
        </div>
    </div>
</div>
@endsection
