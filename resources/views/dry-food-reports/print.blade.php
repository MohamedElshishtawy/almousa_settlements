@extends('analytics.print-layout')
@section('title', 'طباعة تقارير التوريد')

@section('content')
    <div class="mx-2">
        <div class="row justify-content-center">
            <div>
                <div class="">
                    <h4 class="text-center">محضر المواد الجافة</h4>
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
                                    <div class="d-flex">{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($totalAmount)}}  <span
                                            class="unit"> {{ $product->foodUnit->title }}</span></div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if ($cartonValue) {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($cartonValue)}} <span class="unit">كرتون </span>
                                        @else {{ '-' }} @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if($packetValue){{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($packetValue)}} <span class="unit">عبوة </span>
                                        @else {{ '-' }} @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex"> @if ($unitValue) {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($unitValue)}} <span
                                            class="unit"> {{ $product->foodUnit->title }}</span> @else {{ '-' }} @endif</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
