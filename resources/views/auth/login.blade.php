@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}"/>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card pb-3">
                    <h1 class="card-header text-center">تسجيل الدخول</h1>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Phone number input field -->
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-6 text-right">
                                    <label for="phone" class="form-label">رقم الهاتف</label>
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password input field -->
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-6 text-right">
                                    <label for="password" class="form-label">الباسورد</label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="row mb-0 mt-4 justify-content-center">
                                <div class="col-md-6 text-center">
                                    <button type="submit" class="btn btn-success w-100">
                                        تسجيل الدخول
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
