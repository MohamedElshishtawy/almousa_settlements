<div class="report-page">
    <div class="header">
        <h1 class="text-center text-success">
            تقييم العمالة
        </h1>
    </div>

    <div class="report-details">
        <div class="d-flex justify-content-between align-items-center">
            <div class="justify-content-right">
                <h2 class="text-success">معلومات المحضر</h2>
            </div>
            <div class="d-flex">
                @if($formEmployment)
                    <button wire:click="delete" class="btn btn-danger ">
                        <i class="fa-solid fa-trash fa-fw"></i>
                    </button>
                    <a href="{{route('managers.employment.print', [$import])}}" class="btn btn-secondary mx-1">
                        <i class="fa-solid fa-print"></i>
                    </a>
                    <button class="btn btn-primary" wire:click="edit">
                        <i class="fa-solid fa-pen-to-square fa-lg fa-fw"></i>
                    </button>

                @else
                    <button wire:loading.remove class="btn btn-success mx-1" wire:click="save">حفظ
                        </button>
                @endif
            </div>
        </div>

        <table class="table table-borderless">
            <tbody>
            <tr>
                <th>اسم المقر</th>
                <td><a href="{{ route('admin.offices') }}#{{ $import->report->office->id }}">{{ $import->report->office->name }}</a></td>
            </tr>
            <tr>
                <th>التاريخ</th>
                <td>
                    {{ \App\Models\Day::DateToHijri($import->report->for_date) }}
                </td>
            </tr>
            <tr>
                <th class="">عدد المستفيدين</th>
                <td>{{$import->getBenefits()}}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="products-details">
        <table class="table">
            @php($n = 0)
            @foreach($formEmploymentArr as $formEmployment)
                <tr>
                    <th>{{ $formEmployment['title'] }}</th>
                    <td>
                        <input class="form-control" type="number"
                               wire:input.debounce.240="updateCounts({{$formEmployment['id']}}, $event.target.value)"
                               wire:model="counts.{{$formEmployment['id'] ?? $n++}}"
                               value="{{$formEmployment['count']}}">
                    </td>
                </tr>
            @endforeach
        </table>

        <table class="table">
            <tr>
                <th>{{'الأعداد'}}</th>
                <td>
                    <select class="form-select @error('countState') is-invalid @enderror"
                            wire:change="updateWrittenState('countState', 'count_state',$event.target.value)">
                        <option value="0">إختر</option>
                        @foreach(\App\Employment\FormEmploymentElement::COUNT_STATUS as $key => $value)
                            <option value="{{$value}}" @if($countState == $value) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                    @error('countState')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>{{'النظافة'}}</th>
                <td>
                    <select class="form-select @error('cleaningState') is-invalid @enderror"
                            wire:change="updateWrittenState('cleaningState', 'cleaning_state',$event.target.value)">
                        <option value="0">إختر</option>
                        @foreach(\App\Employment\FormEmploymentElement::CLEAN_STATUS as $key => $value)
                            <option value="{{$value}}" @if($cleaningState == $value) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                    @error('cleaningState')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>{{'الشهادة الصحية'}}</th>
                <td>
                    <select class="form-select @error('healthState') is-invalid @enderror"
                            wire:change="updateWrittenState('healthState', 'health_state',$event.target.value)">
                        <option value="0">إختر</option>
                        @foreach(\App\Employment\FormEmploymentElement::HEALTH_STATUS as $key => $value)
                            <option value="{{$value}}" @if($healthState == $value) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                    @error('healthState')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </td>
            </tr>
        </table>
    </div>
</div>
