@extends('layouts.app')
@php($active = 'tasks')

@section('content')
    <div class="container">
        <x-message/>
        <h2>المهام الخاصة بالمقر</h2>
        <div class="row">

            @forelse($tasks as $task)
                <div class="col-12 col-lg-6">
                    @livewire('employee-manage-task-livewire', ['task' => $task])
                </div>
            @empty
                <div class="alert alert-info text-center">
                    لا توجد مهام حتى الآن
                </div>
            @endforelse

        </div>

@endsection
