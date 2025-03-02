<div>
    <table rules="all" class="mt-4 not-print">
        <tr>
            <th colspan="100 d-flex">
                <h2 class="d-flex text-right">إعدادات التقرير</h2>
            </th>
        </tr>
        <tr>
            <th>المقر</th>
            <th colspan="100" class="p-2">
                <div class="d-flex gap-2">
                    @foreach($offices as $officeDb)
                        <span>
                            <input type="checkbox" class="form-check-input p-2"
                                   wire:model.live="selectedOfficesIds"
                                   id="office{{$officeDb->id}}"
                                   value="{{$officeDb->id}}">
                            <label for="office{{$officeDb->id}}">{{$officeDb->name}}</label>
                        </span>
                    @endforeach
                </div>
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
            <th colspan="100">
            <span>
                <span wire:loading>
                        <span class="spinner-border spinner-border-sm text-success" role="status"></span>
                    </span>
            </span>
                تقرير نموذج رقم (2) (تقرير وفر) خاص بلجان الإستلام الفرعية إعاشة
                ب
                @foreach($selectedOffices as $office)
                    مقر <span>{{$office->name}}</span>
                    @if(!$loop->last)
                        و
                    @endif
                @endforeach
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
            <td>الكمية المصروف</td>
            <td>كمية الوفر</td>
            <td>الوحدة</td>
        </tr>
        @foreach($staticProducts ?? [] as $staticProduct)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$staticProduct['name']}}</td>
                <td>{{round($staticProduct['daily_amount'], 4)}}</td>
                <td>{{round($staticProduct['totalAmount'], 4)}}</td>
                <td>{{round($staticProduct['imported_total'], 4)}}</td>
                <td>{{round(bcsub($staticProduct['imported_total'], $staticProduct['total_surplus']), 4)}}</td>
                <td>{{round($staticProduct['total_surplus'], 4)}}</td>
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
            @if($showPrices && auth()->user()->can('import_model2_create_price'))
                <th>إجمالى المبالغ المصروفة</th>
                <td>{{$staticProducts ? number_format($totalPayed, 2) : 0}}</td>
                <th>إجمالى المبالغ غير المصروفة</th>
                <td>{{$staticProducts ? number_format($totalNotPayed, 2) : 0}}</td>
            @endif

        </tr>
    </table>

    <footer class="mt-4">
        <table rules="all" class="no-break">
            <tbody>
            <tr>
                <th colspan="2">المورد أو من ينوب عنه</th>
                <th colspan="2">عضو لجنة الإستلام
                    @if($selectedOffices->count() > 1)
                        الرئيسية
                    @else
                        الفرعية
                    @endif
                </th>
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
                <th>التوقيع</th>
                <td><input type="text" class="form-control"></td>
            </tr>

            </tbody>
        </table>

        <table rules="all" class="no-break mt-2">
            <tbody>
            <tr>
                <th colspan="2">عضو لجنة الإستلام
                    @if($selectedOffices->count() > 1)
                        الرئيسية
                    @else
                        الفرعية
                    @endif
                </th>
                <th colspan="2">رئيس لجنة الإستلام
                    @if($selectedOffices->count() > 1)
                        الرئيسية
                    @else
                        الفرعية
                    @endif
                </th>
            </tr>
            <tr>
                <th>الاسم</th>
                <td>
                    <input type="text" class="form-control" value="">
                </td>
                <th>الاسم</th>
                <td><input type="text" class="form-control"></td>
            </tr>
            <tr>
                <th>المسمى</th>
                <td><input type="text" class="form-control" value=""></td>
                <th>الرتبة</th>
                <td><input type="text" class="form-control"></td>
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
</div>
