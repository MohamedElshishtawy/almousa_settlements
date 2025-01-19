<div class="report-page">
    <div class="header">
        <h1 class="text-center text-success">
            محضر على المتعهد عليه
        </h1>
    </div>

    <div class="report-details">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success">معلومات المحضر</h2>
            <div class="d-flex">
                @if($obligation)
                    <button wire:click="delete" class="btn btn-danger">
                        <i class="fa-solid fa-trash fa-fw"></i>
                    </button>
                    <button wire:loading.attr="disabled" class="btn btn-primary  mx-1" wire:click="edit">
                        <i class="fa-solid fa-pen-to-square fa-lg fa-fw"></i>
                    </button>
                    <a href="{{route('obligations.print', $obligation->id)}}" class="btn btn-secondary">
                        <i class="fas fa-print"></i>
                    </a>
                @else
                    <button wire:loading.attr="disabled" class="btn btn-success mx-1" wire:click="save">حفظ</button>
                @endif
            </div>
        </div>

        <table class="table table-borderless">
            <tbody>
            <tr>
                <th>اسم المقر</th>
                <td>
                    <select class="form-select" wire:model="selectedOffice">
                        <option value="">اختر المقر</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" @if($office->id == $selectedOfficeId) selected @endif>{{ $office->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="products-details">
        <h2 class="text-center">البنود</h2>
        @foreach($bands as $id => $band)
            <section class="mt-3">
                <div class="d-flex align-items-center gap-1">
                    <input type="checkbox" wire:click="toggleActivated({{$id}})" id="band{{$id}}"
                    @if(in_array($id, $selectedBands)) checked @endif>
                    <input type="text" wire:model="bands.{{$id}}" class="form-control"
                           wire:change="bandChange({{$id}}, $event.target.value)"
                           @if(!in_array($id, $selectedBands)) disabled @endif>
                </div>
                <div class="mt-1">
                    <textarea class="form-control" wire:model="contents.{{$id}}"
                                wire:change="contentChange({{$id}}, $event.target.value)"
                    @if(!in_array($id, $selectedBands)) disabled @endif>{{$contents[$id] ?? ''}}</textarea>
                </div>
            </section>
        @endforeach

    </div>
</div>
