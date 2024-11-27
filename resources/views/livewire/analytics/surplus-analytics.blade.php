<div>
    <table rules="all" class="mt-4 not-print">
        <tr>
            <th colspan="100 d-flex">
                <h2 class="d-flex text-right">إعدادات التقرير</h2>
            </th>
        </tr>
        <tr>
            <th>المقر</th>
            <th colspan="100">
                <select wire:model.live="selectedOfficeId" class="form-select">
                    <option value="">إختر المقر</option>
                    @foreach($offices as $office)
                        <option value="{{$office->id}}" @if($selectedOfficeId == $office->id) selected @endif>{{$office->name}}</option>
                    @endforeach
                </select>
            </th>
        </tr>
        <tr>
            <th>الفترة من</th>
            <td colspan="2">
                <select wire:model.live="startDate" class="form-select">
                    <option value="">اليوم</option>
                    @foreach($dates ?? [] as $date)
                        <option value="{{$date}}">{{\App\Models\Day::DateToHijri($date)}}</option>
                    @endforeach
                </select>
            </td>
            <th>الى</th>
            <td colspan="2">
                <select wire:model.live="endDate" class="form-select">
                    <option value="">اليوم</option>
                    @foreach($dates ?? [] as $date)
                        <option value="{{$date}}">{{\App\Models\Day::DateToHijri($date)}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
    </table>
    <h2 class="text-center not-print mb-0 mt-3">ملف الطباعة</h2>
    <hr class="not-print">
    <table rules="all" class="mt-4">
        <tr>
            <th colspan="5">
            <span>
                <span wire:loading>
                        <span class="spinner-border spinner-border-sm text-success" role="status"></span>
                    </span>
            </span>
                تقرير نموذج رقم (2) (تقرير وفر) خاص بالجان الإستلام الفرعية إعاشة ال{{$office ? $office->living->title : ''}} ب
            </th>
            <th colspan="3">
                {{\App\Office\Office::find($selectedOfficeId)->name ?? ''}}
            </th>
        </tr>
        <tr>
            <th>الفترة من</th>
            <td colspan="2">{{\App\Models\Day::DateToHijri($startDate)}}</td>
            <th>الى</th>
            <td colspan="2">{{\App\Models\Day::DateToHijri($endDate)}}</td>
            <th>قوة المستفيدين</th>
            <td>{{$benefitsTotal ?: 0}}</td>
        </tr>
        <tr>
            <td>عدد</td>
            <td>اسم الصنف</td>
            <td>مقرر الفرد اليومى</td>
            <td>الكمية المقررة</td>
            <td>الكمية الموردة</td>
            <td>كمية المصروف</td>
            <td>كمية الوفر</td>
            <td class="unit">الوحدة</td>
        </tr>
        @foreach($staticProducts ?? [] as $staticProduct)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$staticProduct['name']}}</td>
                <td>{{$staticProduct['daily_amount']}}</td>
                <td>{{$staticProduct['totalAmount']}}</td>
                <td>{{$staticProduct['imported_total']}}</td>
                <td>{{$staticProduct['imported_total'] - $staticProduct['total_surplus']}}</td>
                <td>{{$staticProduct['total_surplus']}}</td>
                <td>{{$staticProduct['unit']}}</td>
            </tr>
        @endforeach
    </table>


    <table rules="all" class="mt-4 td-15">
        <tr>
            <th>عدد الأيام</th>
            <td>{{$daysCount}}</td>
            <th>إجمالى عدد المستفيدين</th>
            <td>{{$benefitsTotal ?: 0}}</td>
            @if($showPrices)
                <th>إجمالى المبالغ المصروفة</th>
                <td>{{$staticProducts ? number_format($totalPayed, 2) : 0}}</td>
                <th>إجمالى المبالغ غير المصروفة</th>
                <td>{{$staticProducts ? number_format($totalNotPayed, 2) : 0}}</td>
            @endif

        </tr>
    </table>

    <footer class="mt-4">
        <table rules="all">
            <tbody>
            <tr>
                <th colspan="2">المورد أو من ينوب عنه</th>
                <th colspan="2">عضو لجنة الإستلام الفرعية</th>
            </tr>
            <tr>
                <th>الاسم</th>
                <td></td>
                <th>الاسم</th>
                <td></td>
            </tr>
            <tr>
                <th>المسمى</th>
                <td></td>
                <th>الرتبة</th>
                <td></td>
            </tr>
            <tr>
                <th>التوقيع</th>
                <td></td>
                <th>التوقيع</th>
                <td></td>
            </tr>
            </tbody>
        </table>
    </footer>
</div>
