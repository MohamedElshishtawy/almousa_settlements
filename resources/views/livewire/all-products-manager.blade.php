<div class="card-body table-responsive ">
    <article class="p-3">
        سوف تظهر تلك الأصناف فى صفحات إدارة الأصناف أوتوماتيكيا وسوف يمكنك إستتخدام الأصناف اللتى تحب.
    </article>
    <table class="table text-center border table-hover table-bordered" data-toggle="table" data-sticky-header="true">
        <thead>
        <tr>
            <th colspan="100%" class="main-title">
                <span>جميع الأصناف</span>
            </th>
        </tr>
        <tr>
            <th rowspan="2">ت</th>
            <th rowspan="2">اسم الصنف</th>
            <th rowspan="2">الوحدة</th>
            <th rowspan="2">النوع</th>
            <th rowspan="2">قيمة الكرتون</th>
            <th rowspan="2">حذف</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <livewire:edit-product
                wire:key="product-{{ $product->id }}"
                :product="$product"
                :index="++$index"
                :units="$units"
                :types="$types"
                :key="$product->id"/>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex m-3 mt-4">
        <button wire:click="addProduct()" class="btn btn-success">إضافة صنف</button>
    </div>
</div>
