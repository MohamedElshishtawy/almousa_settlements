@extends('layouts.bordered-report')

@php
    $landScape=true;
@endphp

@section('titlePaper')
    <h1 class="text-center">تقرير الفطور</h1>
@endsection


@section('article')

    <table>
        <thead>
        <tr>
            <th colspan="2">حسب الكشف</th>
            <th colspan="{{ count($breakfastReportProducts) }}">تقرير الفطور</th>
        </tr>
        <tr>
            <th>الرقم</th>
            <th>القوة</th>
            @foreach($breakfastReportProducts as $breakfastReportProduct)
                <th>{{ $breakfastReportProduct->breakFastProduct->product->name }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($breakfastReportDelegates as $breakfastReportDelegate)
            <tr>
                <td>{{ $breakfastReportDelegate->delegate->number }}</td>
                <td>{{ $breakfastReportDelegate->benefits }}</td>

                @foreach($breakfastReportProducts as $breakfastReportProduct)
                    @php
                        $product = $breakfastReportProduct->breakFastProduct->product;
                        $totalAmount = $breakfastReportDelegate->benefits * $breakfastReportProduct->daily_amount;
                        $totalPacketValue = floor($totalAmount / $product->packet_value); // packet
                        $cartonValue = floor($totalPacketValue / $product->carton_value);
                        $packetValue = floor($totalPacketValue - $cartonValue*$product->carton_value);
                        $unitValue = $totalAmount / $product->packet_value - $totalPacketValue;
                        $unitValue = round($unitValue, 4);
                    @endphp

                    <td>
                        @if ($cartonValue > 0)
                            {{ $cartonValue }} كرتون<br>
                        @endif
                        @if ($packetValue > 0)
                            {{ $packetValue }} علبة <br>
                        @endif
                        @if ($unitValue > 0)
                            {{-- Check if there are any remaining units --}}
                            {{ $unitValue * $product->packet_value }} {{ $product->foodUnit->title }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
