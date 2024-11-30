<div class="card">
    <div class="card-header d-flex  align-items-center">
        <h2>
            <span>ترجمة التاريخ</span>

        </h2>
        <span wire:loading>
                        <span class="spinner-border spinner-border-sm text-success" role="status"></span>
            </span>
    </div>


    <div class="card-body table-responsive">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif



            <table class="table">





                <thead>
                <tr>
                    <th>التاريخ الميلادى</th>
                    <th>العام</th>
                    <th>الشهر</th>
                    <th>اليوم</th>
                    <th>اسم اليوم</th>
                    <th>عملية</th>
                </tr>
                </thead>

                <tbody>
                @php($n = 0)
                @foreach($dates ?? [] as $date)
                    <tr wire:key="{{$date->id}}">
                        <td>
                            <input type="date" class="form-control"
                                   wire:model="gregorianDates.{{$date->id}}"
                                   wire:change.debounce.450ms="changeGregorianDate({{$date->id}}, $event.target.value)"
                                   value="{{ $date->gregorian_date }}">
                        </td>
                        <td>
                            <input type="text" class="form-control"
                                   wire:model="years.{{$date->id}}"
                                   wire:change.debounce.450ms="changeYear({{$date->id}}, $event.target.value)"
                                   value="{{ $date->year }}">
                        </td>
                        <td>
                            <select class="form-select"
                                    wire:model="months.{{$date->id}}"
                                    wire:change.debounce.450ms="changeMonth({{$date->id}}, $event.target.value)">
                                @foreach(\App\Models\HijriDate::$hijryMonths as $month => $monthName)
                                    <option value="{{$month}}" {{ $date->month == $month ? 'selected' : '' }}>{{$monthName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control"
                                   wire:model="days.{{$date->id}}"
                                   wire:change.debounce.450ms="changeDay({{$date->id}}, $event.target.value)"
                                   value="{{ $date->day }}">
                        </td>
                        <td>
                            <select class="form-select"
                                    wire:model="weekDays.{{$date->id}}"
                                    wire:change.debounce.450ms="changeWeekDay({{$date->id}}, $event.target.value)">
                                @foreach(\App\Models\Day::$days as $weekDay)
                                    <option value="{{$weekDay}}" {{ $date->weekday == $weekDay ? 'selected' : '' }}>{{$weekDay}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button wire:click="delete({{$date->id}})" class="btn btn-danger">حذف</button>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td>
                        <input type="date" class="form-control @error('gregorianDate') is-invalid @enderror"
                               wire:model="gregorianDate">
                        @error('gregorianDate')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </td>
                    <td>
                        <input type="text" class="form-control @error('year') is-invalid @enderror" wire:model="year">
                        @error('year')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </td>
                    <td>
                        <select class="form-select @error('month') is-invalid @enderror" wire:model="month">
                            <option value="">إختر الشهر الهجرى</option>
                            @foreach(\App\Models\HijriDate::$hijryMonths as $month => $monthName)
                                <option value="{{$month}}">{{$monthName}}</option>
                            @endforeach
                        </select>
                        @error('month')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </td>
                    <td>
                        <input type="text" class="form-control @error('day') is-invalid @enderror" wire:model="day">
                        @error('day')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </td>
                    <td>
                        <select class="form-select @error('weekDay') is-invalid @enderror" wire:model="weekDay">
                            <option value="">إختر اليوم</option>
                            @foreach(\App\Models\Day::$days as $weekDay)
                                <option value="{{$weekDay}}">{{$weekDay}}</option>
                            @endforeach
                        </select>
                        @error('weekDay')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </td>
                    <td>
                        <button wire:click="add" class="btn btn-success">اضافة</button>
                    </td>
                </tr>
                </tbody>

            </table>


    </div>
</div>




