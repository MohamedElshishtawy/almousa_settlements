<div class="card-body table-responsive ">
    <table class="table text-center border table-hover table-bordered" data-toggle="table" data-sticky-header="true">
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
            <th rowspan="2">المقرر اليومى</th>
            <th rowspan="2">الوحدة</th>
            <th rowspan="2">السعر</th>
            <th rowspan="2">النوع</th>
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
        @foreach($products as $productLivingMission)
            <livewire:edit-product wire:key="product-{{ $product->id }}" :product="$productLivingMission->product" :index="++$index" :mission="$mission" :living="$living" :units="$units" :types="$types" :key="$productLivingMission->product->id"/>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex">
        <button wire:click="addProduct()" class="btn btn-success">إضافة صنف</button>
    </div>
</div>
