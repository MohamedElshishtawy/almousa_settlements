@extends('layouts.app')
@php($active = 'employee')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>إضافة عقد</h2>
                    </div>

                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="container mt-5" dir="rtl">
                            <x-message/>

                            <form method="POST" action="{{ route('contract.store') }}">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h4 class="mb-3">معلومات العقد الأساسية</h4>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="reference_number" class="form-label">الرقم المرجعي</label>
                                        <input type="text" id="reference_number" class="form-control"
                                               name="reference_number" placeholder="أكتب هنا"
                                               value="{{ old('reference_number') }}">
                                        @error('reference_number') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="company_name" class="form-label">اسم الشركة</label>
                                        <input type="text" id="company_name" class="form-control"
                                               name="company_name" placeholder="أكتب هنا"
                                               value="{{ old('company_name') }}">
                                        @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="project_name" class="form-label">اسم المشروع</label>
                                        <input type="text" id="project_name" class="form-control"
                                               name="project_name" placeholder="أكتب هنا"
                                               value="{{ old('project_name') }}">
                                        @error('project_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="contract_type_id" class="form-label">نوع العقد</label>
                                        <select id="contract_type_id" class="form-select" name="contract_type_id">
                                            <option value="">اختر نوع العقد</option>
                                            @foreach($contractTypes as $contractType)
                                                <option
                                                    value="{{ $contractType->id }}" {{ old('contract_type_id') == $contractType->id ? 'selected' : '' }}>{{ $contractType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('contract_type_id') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                </div>

                                <hr class="mb-4">

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h4 class="mb-3">تواريخ العقد</h4>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="start_date" class="form-label">تاريخ البدء</label>
                                        <input type="date" id="start_date" class="form-control" name="start_date"
                                               value="{{ old('start_date') }}">
                                        @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="end_date" class="form-label">تاريخ الانتهاء</label>
                                        <input type="date" id="end_date" class="form-control" name="end_date"
                                               value="{{ old('end_date') }}">
                                        @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="contract_signing_date" class="form-label"> ابرام العقد</label>
                                        <input type="date" id="contract_signing_date" class="form-control"
                                               name="contract_signing_date" value="{{ old('contract_signing_date') }}">
                                        @error('contract_signing_date') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="award_date" class="form-label"> استلام التعميد</label>
                                        <input type="date" id="award_date" class="form-control" name="award_date"
                                               value="{{ old('award_date') }}">
                                        @error('award_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="commission_date" class="form-label">التعميد</label>
                                        <input type="date" id="commission_date" class="form-control"
                                               name="commission_date" value="{{ old('commission_date') }}">
                                        @error('commission_date') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <hr class="mb-4">

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h4 class="mb-3">معلومات مالية</h4>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="contract_amount_without_tax" class="form-label">مبلغ العقد غير شامل
                                            الضريبة</label>
                                        <input type="number" id="contract_amount_without_tax" class="form-control"
                                               name="contract_amount_without_tax" placeholder="أكتب هنا" min="0"
                                               value="{{ old('contract_amount_without_tax') }}">
                                        @error('contract_amount_without_tax') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="tax_percentage" class="form-label">نسبة الضريبة</label>
                                        <input type="number" id="tax_percentage" class="form-control"
                                               placeholder="أكتب هنا"
                                               name="tax_percentage" min="0" value="{{ old('tax_percentage') }}">
                                        @error('tax_percentage') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="modified_tax" class="form-label">الضريبة المعدلة</label>
                                        <input type="number" id="modified_tax" class="form-control"
                                               placeholder="فى حالة عدم وجود نسبة واضحة" name="modified_tax" min="0"
                                               value="{{ old('modified_tax') }}">
                                        @error('modified_tax') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="deduction_ratio" class="form-label">نسبة الإستقطاع</label>
                                        <input type="number" id="deduction_ratio" class="form-control"
                                               placeholder="أكتب هنا"
                                               name="deduction_ratio" min="0" value="{{ old('deduction_ratio') }}">
                                        @error('deduction_ratio') <span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                </div>

                                <hr class="mb-4">

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h4 class="mb-3">ملاحظات</h4>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="note" class="form-label">ملاحظات</label>
                                        <textarea id="note" class="form-control" name="note"
                                                  placeholder="أكتب هنا">{{ old('note') }}</textarea>
                                        @error('note') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary w-100">
                                            إضافة العقد
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
