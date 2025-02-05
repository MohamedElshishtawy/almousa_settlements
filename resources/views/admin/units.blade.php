@extends('layouts.app')
@php($active = 'units')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <livewire:manage-units/>
            </div>
        </div>
    </div>
@endsection
