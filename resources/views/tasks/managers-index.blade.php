@extends('layouts.app')
@php($active = 'tasks')

@section('content')
    <div class="container">
        <livewire:tasks-manager-livewire />
    </div>
@endsection
