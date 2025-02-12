@php use App\Models\Delegate; @endphp
@php use App\Office\Office; @endphp
@php use App\Models\Day; @endphp
@php use App\Product\ProductLivingMission; @endphp
@php use App\Product\ProductDayMeal; @endphp
<div class="report-page">
    <x-message/>
    <div class="header">
        <h1 class="text-center text-success">
            محضر صرف الأصناف الجافة
        </h1>
    </div>

    <div class="report-details">
        <x-calc-loading/>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success">معلومات المحضر</h2>
            <div class="d-flex gap-1">
                @if($dryFoodReport->id)
                    @can('dry_food_edit')
                        <button wire:click="edit" class="btn btn-primary btn-sm" wire:confirm="هل انت متأكد من التعديل">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                    @endcan
                    @can('dry_food_delete')
                        <button wire:click="delete" class="btn btn-danger btn-sm" wire:confirm="هل انت متأكد من الحذف">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    @endcan
                @else
                    @can('dry_food_create')
                        <button wire:click="save" class="btn btn-success btn-sm">
                            حفظ
                        </button>
                    @endcan
                @endif
            </div>
        </div>

        <table class="table table-borderless">
            <tbody>
            @if($dryFoodReport->id)
                <tr>
                    <th>طباعة</th>

                    <td>
                        <div class="grid">
                            @can('dry_food_print')
                                <a href="{{ route('dry-food-reports.print', $dryFoodReport->id) }}"
                                   class="btn btn-secondary btn-sm">
                                    <i class="fas fa-print"></i>
                                    التقرير
                                </a>
                            @endcan
                            @can('confirm_dry_food_reception')
                                <a href="{{ route('dry-food-reports.delegateReport', $dryFoodReport->id) }}"
                                   class="btn btn-secondary btn-sm">
                                    <i class="fas fa-print"></i>
                                    إقرار المندوب
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endif
            <tr>
                <th>المقر</th>
                <td>
                    <select wire:model.live="selectedOfficeId"
                            class="form-select @error('selectedOfficeId') is-invalid @enderror">
                        <option value="">اختر المقر</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" @if($selectedOfficeId == $office->id) selected @endif>
                                {{ $office->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedOfficeId')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>المهمة</th>
                <td>
                    <select wire:model.live="selectedMissionId"
                            class="form-select @error('selectedMissionId') is-invalid @enderror">
                        <option value="">اختر المهمة</option>
                        @foreach($selectedOfficeId ? Office::find($selectedOfficeId)->OfficeMissions : [] as $officeMission)
                            <option value="{{ $officeMission->mission->id }}"
                                    @if($selectedMissionId == $officeMission->mission->id) selected @endif>
                                {{ $officeMission->mission->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedMissionId')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>من تاريخ</th>
                <td>
                    <select wire:model.live="startDate" class="form-select @error('startDate') is-invalid @enderror">
                        <option value="">اختر التاريخ</option>
                        @foreach($dates as $date)
                            <option value="{{ $date }}" @if($startDate == $date) selected @endif>
                                {{ Day::DateToHijri($date) }}
                            </option>
                        @endforeach
                    </select>
                    @error('startDate')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>إلى تاريخ</th>
                <td>
                    <select wire:model.live="endDate" class="form-select @error('endDate') is-invalid @enderror">
                        <option value="">اختر التاريخ</option>
                        @foreach($dates as $date)
                            <option value="{{ $date }}" @if($endDate == $date) selected @endif>
                                {{ Day::DateToHijri($date) }}
                            </option>
                        @endforeach
                    </select>
                    @error('endDate')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>المندوب</th>
                <td>
                    <select wire:model.live="selectedDelegateId"
                            class="form-select @error('selectedDelegateId') is-invalid @enderror">
                        <option value="">اختر المندوب</option>
                        @foreach($selectedOfficeId ? Office::find($selectedOfficeId)->delegates : [] as $delegate)
                            <option value="{{ $delegate->id }}"
                                    @if($selectedDelegateId == $delegate->id) selected @endif>
                                {{ $delegate->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedDelegateId')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>المستفيدين</th>
                <td>{{$selectedDelegateId ? Delegate::find($selectedDelegateId)->benefits : 0}}</td>
            </tr>
            </tbody>
        </table>
    </div>


    <div class="products-details">
        <table class="table">
            <thead>
            <tr>
                <th>ت</th>
                <th>الصنف</th>
                <th>الكمية المقررة</th>
                <th>كرتون</th>
                <th>علبة</th>
                <th>وحدة</th>
            </tr>
            </thead>
            <tbody>
            @php


                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));
                $benefits = $selectedDelegateId ? Delegate::find($selectedDelegateId)->benefits : 0;
                $office = $selectedOfficeId ? Office::find($selectedOfficeId) : null;
            @endphp

            @foreach($products as $product)
                @php

                    $totalAmount = 0;
                    $currentDate = $startDate;
                    while ($currentDate <= $endDate) {

                        $day = Day::date2object($currentDate);
                        if ($day) {
                            $productLivingMission = ProductLivingMission::where('product_id', $product->id)
                                ->where('living_id', $office->living_id)->where('mission_id', $selectedMissionId)
                                ->first();

                            $productMissionData = ProductDayMeal::where('product_living_mission_id', $productLivingMission->id)
                                ->where('day_id', $day->id)
                                ->first();

                            if ($productMissionData) {
                                $totalAmount += $productMissionData->ProductLivingMission->daily_amount * $benefits;
                            }
                        }
                        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                    }
                    $totalPacketValue = floor($totalAmount / $product->packet_value); // packet
                    $cartonValue = floor($totalPacketValue / $product->carton_value);
                    $packetValue = floor($totalPacketValue - $cartonValue*$product->carton_value);
                    $unitValue = $totalAmount / $product->packet_value - $totalPacketValue;
                    $unitValue = round($unitValue, 4);
                @endphp
                <tr>
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <div class="d-flex">{{ $totalAmount }} <span class="unit">{{ $product->foodUnit->title }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">{{$cartonValue}} <span class="unit">كرتون</span></div>
                    </td>
                    <td>
                        <div class="d-flex">{{$packetValue}} <span class="unit">عبوة</span></div>
                    </td>
                    <td>
                        <div class="d-flex">{{$unitValue}} <span class="unit">{{ $product->foodUnit->title }}</span>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
