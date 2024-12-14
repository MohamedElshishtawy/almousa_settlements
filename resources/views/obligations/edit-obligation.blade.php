@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/products.css?3') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mx-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    @livewire('obligations-livewire', [$obligations])
                </div>
            </div>
        </div>
    </div>
@endsection
