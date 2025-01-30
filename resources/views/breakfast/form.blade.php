@extends('layouts.app')
@php($active = 'employee')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>محضر الإفطار</h2>

                    </div>


                    <div class="card-body table-responsive">
                        <div class="container mt-5" dir="rtl">

                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <form
                                action="{{ $breakFastReport->exists ? route('breakfast.update', $breakFastReport->id) : route('breakfast.store') }}"
                                method="POST">
                                @csrf
                                @if($breakFastReport->exists)
                                    @method('PUT')
                                @endif

                                <!-- First row: Date -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="for_date" class="form-label">التاريخ</label>
                                        <input type="date" id="for_date" class="form-control" name="for_date"
                                               value="{{ old('for_date', $breakFastReport->for_date) ?: now()->format('Y-d-m') }}">
                                        @error('for_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Second row: Notes -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="notes" class="form-label">الملاحظات</label>
                                        <textarea id="notes" class="form-control" name="notes"
                                                  placeholder="أكتب هنا">{{ old('notes', $breakFastReport->notes) }}</textarea>
                                        @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Third row: Select Delegates -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="delegates" class="form-label">اختر المندوبين</label>

                                        @foreach($delegatesAll as $delegate)
                                            <div class=" d-flex gap-2">
                                                <input class="form-check-input" type="checkbox" name="delegates[]"
                                                       value="{{ $delegate->id }}"
                                                    {{ in_array($delegate->id,
                                                        old('delegates', $breakFastReport->breakFastReportDelegates ? $breakFastReport->breakFastReportDelegates->pluck('delegate_id')->toArray() :[])) ? 'checked' : '' }}>
                                                <label class="form-check" for="delegates">({{$delegate->number}}
                                                    ) {{ $delegate->name }}</label>
                                            </div>
                                        @endforeach
                                        @error('delegates') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary w-100">
                                            {{ $breakFastReport->exists ? 'تحديث التقرير' : 'إضافة التقرير' }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
