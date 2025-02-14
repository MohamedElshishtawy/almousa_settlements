<div class="card p-0 my-3">
    <!-- Card Header with Description -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">{{ $description }}</h2>

        <!-- Loading / Check Animation -->
        <span wire:loading wire:target="updateStage" class="spinner-border spinner-border-sm text-primary"
              role="status"></span>
        <span wire:loading.remove wire:target="updateStage">
    @if (optional($stage)->expression == 'done')
                <i class="fas fa-check-circle text-success animate__animated animate__fadeIn"></i>
            @elseif(optional($stage)->expression == 'working')
                <i class="fas fa-hourglass-half text-warning animate__animated animate__fadeIn"></i>
            @elseif(optional($stage)->expression == 'postponed')
                <i class="fas fa-pause-circle text-info animate__animated animate__fadeIn"></i>
            @else
                <i class="fas fa-times-circle text-secondary animate__animated animate__fadeIn"></i>
            @endif
</span>
    </div>

    <div class="card-body table-responsive">
        <p class="text-muted p-3 border rounded bg-light">
            <strong>ملاحظات:</strong> {{ $note ?? 'لا توجد ملاحظات' }}
        </p>

        <!-- Stage Selection -->
        <div class="form-group">
            <label for="stage">إختر الحالة المناسبة للتعديل</label>
            <select wire:change="updateStage($event.target.value)" id="stage" class="form-select">
                <option value="">اختر الحالة</option>
                @foreach($stages as $stage)
                    <option value="{{ $stage->id }}" @if($stage->id == $stage_id) selected @endif>
                        {{ $stage->ar_expression }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Card Footer with Timestamp -->
    <div class="card-footer text-secondary text-end">
        <small>تم الإنشاء منذ: {{ $task->created_at->diffForHumans() }}</small>
    </div>
</div>

