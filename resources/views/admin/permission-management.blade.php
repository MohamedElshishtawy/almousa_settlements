@extends('layouts.app')
@php($active = 'units')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                @livewire('permission-management-livewire')
            </div>
        </div>
    </div>
@endsection
