<div class="card mt-lg-4 p-0">
    <div class="card-body table-responsive">
        <div class="row">

            <!-- Description Field -->
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="description">المهمة</label>
                    <input type="text" wire:model="description" id="description" class="form-control" required>
                </div>
            </div>

            <!-- Stage Field -->
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="stage">الحالة</label>
                    <select wire:model="stage_id" id="stage" class="form-select">
                        <option value="">اختر الحالة</option>
                        @foreach($stages as $stage)
                            <option value="{{$stage->id}}"
                                    @if($stage->id == $stage_id) selected @endif>{{$stage->ar_expression}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


        </div>

        <!-- Notes Field -->
        <div class="form-group mt-2">
            <label for="notes">ملاحظات</label>
            <textarea name="notes" id="notes" class="form-control" wire:model="note" required></textarea>
        </div>

        <!-- Buttons -->
        <div class="row mt-4">
            @can('tasks_edit')
                <div class="col">
                    <button type="submit" class="btn btn-primary"
                            wire:loading.attr="disabled"
                            wire:click="edit"
                            wire:confirm="هل أنت متأكد من تعديل المهمة؟">
                        <span wire:loading.remove wire:target="edit">تعديل</span>
                        <span wire:loading wire:target="edit">
                        <span class="spinner-border spinner-border-sm text-white" role="status"></span>
                    </span>
                    </button>
                    @endcan
                    @can('tasks_delete')
                        <button class="btn btn-danger"
                                wire:click="delete"
                                wire:confirm="هل أنت متأكد من حذف المهمة؟">
                            <span wire:loading.remove wire:target="delete">حذف</span>
                            <span wire:loading wire:target="delete">
                        <span class="spinner-border spinner-border-sm text-white" role="status"></span>
                    </span>
                        </button>
                    @endcan
                </div>
        </div>

        @if ($task->histories->count())
            <div class="row mt-2">
                <table class="table table-sm round">
                    <tr>
                        <th class="text-muted">تحديثات الحالة</th>
                    </tr>
                    @foreach($task->histories as $history)
                        <tr>
                            <td>
                                <div class="d-flex justify-content-between ">
                                    <small>{{$history->description}}</small>
                                    <small class="text-info"><strong><i class="fa fa-clock fw"></i></strong>
                                        {{$history->created_at->diffForHumans()}}</small>
                                </div>
                                <div>
                                    <small
                                        class="text-muted"> <strong><i
                                                class="fa fa-user fw"></i></strong>{{$history->user->name}}</small>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>

    <div class="card-footer text-secondary">
        <small>
            <span>تم الإنشاء منذ: </span>
            <span>{{$task->created_at->diffForHumans()}}</span>
        </small>
    </div>
</div>
