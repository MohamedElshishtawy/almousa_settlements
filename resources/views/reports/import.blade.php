@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/products.css?1') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="mx-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    @livewire('reports.import', ['office' => $office, 'date' => $date, 'products' => $products])
                </div>
            </div>
        </div>
    </div>
@endsection
