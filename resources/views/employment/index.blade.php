@extends('layouts.app')
@php($active = '')
@section('content')
    <div class="container">
        <x-message/>
        <div class="row justify-content-center">
            <div>
                <livewire:manage-employment-livewire/>
            </div>
        </div>
    </div>
@endsection
