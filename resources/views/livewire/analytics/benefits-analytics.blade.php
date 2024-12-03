<div>
    <table rules="all" class="mt-4 not-print">
        <tr>
            <th colspan="100 d-flex">
                <h2 class="d-flex text-right">إعدادات البيان</h2>
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
        <tr>
            <td colspan="100" class="p-3">
                <div class="d-flex gap-3">
                    @foreach($offices as $office)
                        <div class="text-lg">
                            <input type="checkbox" wire:model.live="selectedOffices" value="{{$office->id}}" id="office{{$office->id}}">
                            <label class="" for="office{{$office->id}}"><strong>{{$office->name}}</strong></label>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>
    <h2 class="text-center not-print mb-0 mt-3">ملف الطباعة</h2>
    <hr class="not-print">

    <article>
        <h2 class="text-center">بيان بعدد المستفيدين</h2>
        <p class="text-center mt-5">
            بيان بعدد المستفيدين من
            @if(count($selectedOffices) > 1)
                المقرات التالى اسمها:
                @foreach($selectedOffices as $office)
                    {{\App\Office\Office::find($office)->name}}
                @endforeach
            @elseif(count($selectedOffices) == 1)
                المقر {{\App\Office\Office::find($selectedOffices[0])->name}}
            @endif
            خلال الفترة من <strong>{{\App\Models\Day::DateToHijri($startDate)}}</strong> الى <strong>{{\App\Models\Day::DateToHijri($endDate)}}</strong>
            بأنه تم إستفادة <strong>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($benefits)}}</strong> مستفيد
            من الخدمات المقدمة
        </p>
    </article>


</div>
