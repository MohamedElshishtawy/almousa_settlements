@extends('layouts.app')
@php($active = 'tasks')

@section('content')

    <div class="container">
        <x-message/>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h2 class="text-center">
                    مهام مقر {{$office->name}}
                </h2>
            </div>
            @can('tasks_create')
                <div class="">
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-right align-items-center gap-2">
                            <h2>إضافة مهمة</h2>
                        </div>
                        <div class="card-body table-responsive">
                            <form action="{{route('admin.tasks.store', [$office->id])}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="description">المهمة</label>
                                    <input type="text" name="description" id="name"
                                           class="form-control @error('description') is-invalid @enderror">
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label for="note">ملاحظات</label>
                                    <textarea name="note" id="note"
                                              class="form-control @error('note') is-invalid @enderror"
                                    ></textarea>
                                    @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mt-4">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">إضافة</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        <h4 class="text-center mt-5">المهام</h4>

        <div class="row">
            @foreach($office->tasks as $index => $task)
                <div class="col-12 col-lg-6 mt-4">
                    @livewire('admin-manage-task-livewire', ['task' => $task])
                </div>

                {{-- Start a new row after every 2 tasks --}}
                @if(($index + 1) % 2 == 0)
        </div>
        <div class="row">
            @endif
            @endforeach
        </div>

    </div>

@endsection
