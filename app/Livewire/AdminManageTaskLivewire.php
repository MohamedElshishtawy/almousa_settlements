<?php

namespace App\Livewire;

use App\Task\Stage;
use App\Task\Task;
use Livewire\Component;

class AdminManageTaskLivewire extends Component
{
    public $task;
    public $description;
    public $note;
    public $position;
    public $stage_id;
    public $stages;

    public function mount(Task $task)
    {
        $this->stages = Stage::all();
        $this->task = $task;
        $this->description = $task->description;
        $this->note = $task->note;
        $this->stage_id = optional($task->stage)->id;
    }

    public function edit()
    {
        $this->validate([
            'description' => 'required',
            'note' => 'nullable',
            'stage_id' => 'nullable',
        ]);


        if ($this->stage_id && $this->stage_id != $this->task->stage_id) {
            $this->task->histories()->create([
                'stage_id' => $this->stage_id,
                'user_id' => auth()->id(),
                'description' => optional($this->task->stage)->ar_expression ?
                    'تحديث حالة المهمة من '.$this->task->stage->ar_expression.' إلى '.Stage::find($this->stage_id)->ar_expression :
                    'تحديث حالة المهمة '.' إلى '.Stage::find($this->stage_id)->ar_expression,
            ]);
        }

        activity('task')
            ->performedOn($this->task)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $this->task,
                'new' => [
                    'description' => $this->description,
                    'note' => $this->note,
                ],

            ])
            ->log('تم تحديث المهمة');

        $this->task->update([
            'description' => $this->description,
            'note' => $this->note,
        ]);

        session()->flash('success', 'تم تحديث المهمة بنجاح');
    }

    public function delete()
    {
        $this->task->delete();
        activity('task')
            ->performedOn($this->task)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $this->task,
            ])
            ->log('تم حذف المهمة');
        
        return redirect()->route('admin.tasks.office', [$this->task->office->id])->with('success',
            'تم حذف المهمة بنجاح');
    }

    public function render()
    {
        return view('livewire.admin-manage-task-livewire');
    }
}
