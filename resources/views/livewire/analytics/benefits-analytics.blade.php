<div>
    <table rules="all" class="mt-4 not-print">
        <tr>
            <th colspan="100 d-flex">
                <h2 class="d-flex text-right">إعدادات البيان</h2>
            </th>
        </tr>
        <tr>
            <th class="p-2">المهمة</th>
            <td colspan="100">
                <div class="d-flex gap-3 align-items-center">
                    @foreach($missions as $mission)
                        <div>
                            <input type="checkbox" wire:model.live="selectedMissions" value="{{$mission->id}}" id="mission{{$mission->id}}">
                            <label class="" for="mission{{$mission->id}}"><strong>{{$mission->title}}</strong></label>
                        </div>
                    @endforeach
                </div>

            </td>
        </tr>
        <tr>
            <th>الفترة من</th>
            <td >
                <select wire:model.live="startDate" class="form-select">
                    <option value="">اليوم</option>
                    @foreach($dates ?? [] as $date)
                        <option value="{{$date}}">{{\App\Models\Day::DateToHijri($date)}}</option>
                    @endforeach
                </select>
            </td>
            <th>الى</th>
            <td >
                <select wire:model.live="endDate" class="form-select">
                    <option value="">اليوم</option>
                    @foreach($dates ?? [] as $date)
                        <option value="{{$date}}">{{\App\Models\Day::DateToHijri($date)}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <th>المقرات</th>
            <td colspan="100" class="p-2">
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

    {{--the value بيان بأعداد المستفيدين لمهمة
            @foreach($selectedMissions as $mission)
                {{\App\Mission\Mission::find($mission)->title}}
                @if(!$loop->last && count($selectedMissions) > 1)
                    و
                @endif
            @endforeach
        لعام
        {{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($year)}}
        هـ
    --}}
    @php($value  = ' بيان بأعداد المستفيدين لمهمة ')
    @foreach($selectedMissions as $mission)
        @php($value .= \App\Mission\Mission::find($mission)->title)
        @if(!$loop->last && count($selectedMissions) > 1)
            @php($value .= ' و ')
        @endif
    @endforeach
    @php($value .= ' لعام ')
    @php($value .= \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($year))
    @php($value .= ' هـ')
    <input type="text" class="form-control text-center font-weight-bold bold" value="{{$value}}">

    <h3 class="text-center"></h3>


    <table rules="all" class="mt-3">
        <tr>
            <th class="td-sm">عدد</th>
            <th class="w-25">اليوم</th>
            @foreach($selectedOffices as $office)
                <th width="auto">{{\App\Office\Office::find($office)->name}}</th>
            @endforeach
            <th>الإجمالى</th>
        </tr>
        @php($total = ['perDay' => 0])
        @foreach($datesBetween as $date)
            @php($totalPerDay = 0)
            <tr>
                <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration)}}</td>
                <td>{{\App\Models\Day::DateToHijri($date)}}</td>
                @forelse($selectedOffices as $office)
                    @php($office = App\Office\Office::find($office))
                    @php($report= $office->reports->where('for_date', $date)->first())
                    @php($benefits = $report && $report->import ? $report->import->benefits : 0)
                    @php($totalPerDay += $benefits)
                    @php($total[$office->id] = ($total[$office->id] ?? 0) + $benefits)
                    @php($office = App\Office\Office::find($office))
                    <td>{{$benefits}}</td>
                @empty
                @endforelse
                <td>{{$totalPerDay}}</td>
            </tr>
            @php($total['perDay'] += $totalPerDay)
        @endforeach
        <tr>
            <th colspan="2">الإجمالى</th>
            @foreach($selectedOffices as $office)
                <td>{{$total[$office]}}</td>
            @endforeach
            <td>{{$total['perDay']}}</td>
        </tr>
    </table>


</div>
