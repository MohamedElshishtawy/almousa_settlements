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
                <div class="d-flex gap-2 ">
                    @foreach($offices as $officeDb)
                        <span>
                        <input type="checkbox" class="form-check-input p-2 cursor-pointer"
                               wire:model.live="selectedOfficesIds"
                               value="{{$officeDb->id}}"
                               id="office{{$officeDb->id}}">
                        <label class="form-check-label" for="office{{$officeDb->id}}">{{$officeDb->name}}</label>
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
        <thead>
        <tr>
            <th colspan="100">
            <span>
                <span wire:loading>
                        <span class="spinner-border spinner-border-sm text-success" role="status"></span>
                    </span>
            </span>

                تقرير نموذج رقم (1) محضر توريد الموارد الطازجة و الجافة إعاشة
                ب
                @foreach($selectedOffices as $selectedOffice)
                    مقر {{$selectedOffice->name}}
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
            <th>عدد المستفيدين</th>
            <td>{{$benefitsTotal ?: 0}}</td>
        </tr>
        <tr>
            <td>عدد</td>
            <td>اسم الصنف</td>
            <td>مقرر الفرد اليومى</td>
            <td class="td-sm">عدد مرات تقديم الإسبوع</td>
            <td>الكمية المقررة</td>
            <td>الكمية الموردة</td>
            <td>الفرق</td>
            <td>الوحدة</td>
        </tr>
        </thead>
        <tbody>
        @foreach($staticProducts ?? [] as $staticProduct)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$staticProduct['name']}}</td>
                <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($staticProduct['daily_amount'])}}</td>
                <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($staticProduct['numberPerWeek'])}}</td>
                <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($staticProduct['totalAmount'])}}</td>
                <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($staticProduct['imported_total'])}}</td>
                <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits(round($staticProduct['totalAmount'] - $staticProduct['imported_total'], 4 ))}}</td>
                <td>{{$staticProduct['unit']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <table rules="all" class="mt-4 td-15">
        <tr>
            <th>عدد الأيام</th>
            <td>{{$daysCount}}</td>
            <th>إجمالى عدد المستفيدين</th>
            <td>{{$benefitsTotal ?: 0}}</td>
            @if($showPrices && auth()->user()->role->hasPermissionTo('import_model2_create_price'))
                <th>إجمالى المبالغ المصروفة</th>
                <td>{{$staticProducts ? $totalPayed : 0}}</td>
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
