<div class="row">
    <div class="col-md-2">
        <h2>مخزن الأصناف</h2>
        <ul>
            @foreach($allProducts as $product)
                <li wire:key="all-product-{{$product->id}}">
                    <input type="checkbox" wire:click="toggleProduct({{$product->id}})"
                           id="all-product-{{$product->id}}"
                           @if(in_array($product->id, $missionProducts->pluck('product_id')->toArray())) checked @endif>
                    <label for="all-product-{{$product->id}}">{{$product->name}}</label>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-10 table-responsive ">
        <table class="table text-center border table-hover table-bordered" data-toggle="table"
               data-sticky-header="true">
            <thead>
            <tr>
                <th colspan="100%" class="main-title">
                    <span>أصناف</span>
                    <span>{{$mission->title}}</span>
                    <span>{{$living->title}}</span>
                </th>
            </tr>
            <tr>
                <th rowspan="2">ت</th>
                <th rowspan="2">اسم الصنف</th>
                <th rowspan="2" colspan="2">المقرر اليومى</th>
                <th rowspan="2">السعر</th>
                <th rowspan="2">الصرف</th>
                @foreach(\App\Models\Day::$days as $day)
                    <th colspan="3">{{$day}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach(\App\Models\Day::$days as $day)
                    @foreach(array_reverse((new \App\Models\Meal())->meals($mission->title)) as $meal)
                        <th>{{\App\Models\Meal::$translateSmaller[$meal]}}</th>
                    @endforeach
                @endforeach
            </tr>
            </thead>
            <tbody>
            @php($index=0)
            @foreach($missionProducts as $productLivingMission)
                <livewire:product-mission-edit wire:key="product-{{ $productLivingMission->product->id }}"
                                               :product="$productLivingMission->product"
                                               :productLivingMission="$productLivingMission"
                                               :index="++$index"
                                               :mission="$mission"
                                               :living="$living" :key="$productLivingMission->product->id"/>
            @endforeach

            </tbody>
        </table>

    </div>
</div>
