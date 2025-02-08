@extends('layouts.bordered-report')


@section('titlePaper')
    <h1>محضر المواد الجافة</h1>
@endsection

@section('article')
    <div class="">
        <p class="text-center mt-3">لمندوب
            {{ $dryFoodReport->delegate->institution }}
            للفترة من
            {{ \App\Models\Day::DateToHijri($dryFoodReport->start_date) }}
            إلى
            {{ \App\Models\Day::DateToHijri($dryFoodReport->end_date) }}
            بعدد أيام
            {{ \Carbon\Carbon::parse($dryFoodReport->start_date)->diffInDays($dryFoodReport->end_date) + 1 }}
        </p>
        <table rules="all" class="table-text-right">
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
                $startDate = date('Y-m-d', strtotime($dryFoodReport->start_date));
                $endDate = date('Y-m-d', strtotime($dryFoodReport->end_date));
                $benefits =  $dryFoodReport->delegate->benefits;
                $office = $dryFoodReport->delegate->office;
            @endphp
            @foreach($products as $product)
                @php
                    $totalAmount = 0;
                    $currentDate = $startDate;
                    while ($currentDate <= $endDate) {

                        $day = \App\Models\Day::date2object($currentDate);
                        if ($day) {
                            $productLivingMission = \App\Product\ProductLivingMission::where('product_id', $product->id)
                                ->where('living_id', $office->living_id)->where('mission_id', $dryFoodReport->mission_id)
                                ->first();

                            $productMissionData = \App\Product\ProductDayMeal::where('product_living_mission_id', $productLivingMission->id)
                                ->where('day_id', $day->id)
                                ->first();

                            if ($productMissionData) {
                                $totalAmount += $productMissionData->ProductLivingMission->daily_amount * $benefits;
                            }
                        }
                        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                    }
                    $totalPacketValue = ($product->packet_value != 0) ? floor($totalAmount / $product->packet_value) : 0;
                    $cartonValue = ($product->carton_value != 0) ? floor($totalPacketValue / $product->carton_value) : 0;
                    $packetValue = ($product->carton_value != 0) ? floor($totalPacketValue - $cartonValue * $product->carton_value) : 0;
                    $unitValue = ($product->packet_value != 0) ? $totalAmount / $product->packet_value - $totalPacketValue : 0;
                    $unitValue = round($unitValue, 4);
                @endphp
                <tr>
                    <td>{{ \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <div
                            class="d-flex">{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($totalAmount)}}
                            <span
                                class="unit"> {{ $product->foodUnit->title }}</span></div>
                    </td>
                    <td>
                        <div class="d-flex">
                            @if ($cartonValue)
                                {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($cartonValue)}}
                                <span class="unit">كرتون </span>
                            @else
                                {{ '-' }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            @if($packetValue)
                                {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($packetValue)}}
                                <span class="unit">عبوة </span>
                            @else
                                {{ '-' }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex"> @if ($unitValue)
                                {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($unitValue)}}
                                <span
                                    class="unit"> {{ $product->foodUnit->title }}</span>
                            @else
                                {{ '-' }}
                            @endif</div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('footer')
    <table rules="all" class="no-break">
        <tbody>
        <tr>
            <th colspan="2">معد المحضر</th>
            <th colspan="2">المندوب</th>
        </tr>
        <tr>
            <th>الاسم</th>
            <td>
                <input type="text" class="form-control" value="{{auth()->user()->name}}">
            </td>
            <th>الاسم</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        <tr>
            <th>المسمى</th>
            <td><input type="text" class="form-control" value="{{auth()->user()->role_ar}}"></td>
            <th>الرتبة</th>
            <td><input type="text" class="form-control"></td>
        </tr>
        <tr>
            <th>التوقيع</th>
            <td><input type="text" class="form-control"></td>

        </tr>
        </tbody>
    </table>

@endsection



