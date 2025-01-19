
@extends('layouts.app')
@php($active = 'units')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div >
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>إدارة شركة العام</h2>

                    </div>


                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <livewire:manage-company-livewire />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
