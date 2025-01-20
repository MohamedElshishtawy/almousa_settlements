<div>
    <table rules="all" class="mt-4 not-print">
        <tr>
            <th colspan="100 d-flex">
                <h2 class="d-flex text-right">إعدادات التقرير</h2>
            </th>
        </tr>
        <tr>
            <th>المقر</th>
            <td>
                <select wire:model.live="selectedOfficeId" class="form-select">
                    <option value="">إختر المقر</option>
                    @foreach($offices as $office)
                        <option value="{{$office->id}}" @if($office->id == $selectedDelegateId) selected @endif>{{$office->name}}</option>
                    @endforeach
                </select>
            </td>
            <th>المندوب</th>
            <td>
                <select wire:model.live="selectedDelegateId" class="form-select">
                    <option value="">إختر المندوب</option>
                    @foreach($delegates ?: [] as $delegateDb)
                        <option value="{{$delegateDb->id}}" @if($delegateDb->id == $selectedDelegateId) selected @endif>{{$delegateDb->name}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <th>الوجبة</th>
            <td colspan="100">
                <select wire:model.live="selectedMealId" class="form-select">
                    <option value="">إختر الوجبة</option>
                    @foreach($meals as $meal)
                        <option value="{{$meal->id}}" @if($meal->id == $selectedMealId) selected @endif>{{$meal->name}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <th>التاريخ ميلادى</th>
            <td>
                <input type="date" wire:model.live="date" class="form-control">
            </td>
            <th>هجريا</th>
            <td>{{\App\Models\Day::DateToHijri($date)}}</td>
        </tr>
    </table>

<main class="bordered-paper mt-4">
    <div>
        <header>
            <div>
                <div>إعاشة الميدان</div>
                <div>{{$delegate ? $delegate->office->name : 'المقر'}}</div>
            </div>
            <div></div>
            <div>
                <div>رقم التسلسل</div>
            </div>
            <div class="title">
                <h4>إقرار بتاريخ
                    {{$formatedDate}}</h4>
            </div>
        </header>

        <article>
            <div>
                إنه فى يوم
                {{$dateHijri['weekday']}}
                الموافق للتاريخ أعلاه أثناء صرف وجبة
                {{$selectedMeal ? $selectedMeal->name : ''}}
                حضر مندوب رقم
                {{$delegate ? \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($delegate->number) : '0'}}
                {{$delegate ? $delegate->institution : 'اسم الجهة'}}.
                وبناءً على رغبته لم يستلم كامل مخصصهم من الإعاشة المطهية.
                <br>
                وحفظُا للواقعة تم إعداد هذا المحضر.
            </div>

            <div class="mt-3">
                وأتعهد بإحضار خطاب من مديرى المباشر يفيد <strong>عدم</strong>
                رغبتنا بإستلام بعض أصناف مخصصنا من الإعاشة
            </div>
            <div class="text-center">
                وعلى ذلك جرى التوقيع،،،
            </div>
        </article>
    </div>

    <footer>
        <table rules="all" class="no-break">
            <tbody>
            <tr>
                <th colspan="2">مندوب الجهة</th>
                <th colspan="2">
                    <div class="">
                        <span>مشرف صرف وجبة</span>
                        {{$selectedMeal ? $selectedMeal->name : ''}}
                    </div>
                </th>
            </tr>
            <tr>
                <th>الاسم</th>
                <td>
                    <input type="text" class="form-control" value="{{auth()->user()->name}}">
                </td>
                <th>الاسم</th>
                <td><input type="text" class="form-control" value="{{$delegate ? $delegate->name : ''}}"></td>
            </tr>
            <tr>
                <th>الرتبة</th>
                <td><input type="text" class="form-control" value="{{auth()->user()->rank}}"></td>
                <th>الرتبة</th>
                <td><input type="text" class="form-control" value="{{$delegate ? $delegate->rank : ''}}"></td>
            </tr>
            <tr>
                <th>التوقيع</th>
                <td><input type="text" class="form-control"></td>
                <th>التوقيع</th>
                <td><input type="text" class="form-control"></td>
            </tr>
            </tbody>
        </table>
    </footer>
</main>
</div>
