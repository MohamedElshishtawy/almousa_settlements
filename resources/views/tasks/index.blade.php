@extends('layouts.app')
@php($active = 'tasks')

@section('content')
    <div class="container">
        <livewire:tasks-admin-livewire />
    </div>
@endsection
