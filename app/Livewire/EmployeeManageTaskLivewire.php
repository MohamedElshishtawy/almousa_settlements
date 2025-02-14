<?php

namespace App\Livewire;

use App\Task\Stage;
use App\Task\Task;
use Livewire\Component;

class EmployeeManageTaskLivewire extends Component
{
    public $task;
    public $description;
    public $note;
    public $position;
    public $stage_id;
    public $stages;
    public $stage;

    public function mount(Task $task)
    {
        $this->stages = Stage::all();
        $this->task = $task;
        $this->description = $task->description;
        $this->note = $task->note;
        $this->stage_id = optional($task->stage)->id;
        $this->stage = $task->stage;
    }

    public function edit()
    {
        $this->validate([
            'description' => 'required',
            'note' => 'nullable',
            'stage_id' => 'nullable',
        ]);


        $this->task->update([
            'description' => $this->description,
            'note' => $this->note,
        ]);
    }

    public function updateStage($stage_id)
    {
        // Validate stage_id
        $newStage = Stage::find($stage_id);
        if (!$newStage) {
            session()->flash('error', 'Stage not found.');
            return;
        }

        $currentStage = $this->task->stage;

        // Create a new history for the stage change
        $this->task->histories()->create([
            'stage_id' => $stage_id,
            'user_id' => auth()->id(),
            'description' => $currentStage ?
                'تحديث حالة المهمة من '.$currentStage->ar_expression.' إلى '.$newStage->ar_expression :
                'تحديث حالة المهمة إلى '.$newStage->ar_expression,
        ]);

        // Update current stage
        $this->stage = $newStage;

        // Log activity with proper old/new values
        activity('task')
            ->performedOn($this->task)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => [
                    'stage_id' => optional($currentStage)->id,
                    'stage_ar_expression' => optional($currentStage)->ar_expression,
                ],
                'new' => [
                    'stage_id' => $newStage->id,
                    'stage_ar_expression' => $newStage->ar_expression,
                ],
            ])
            ->log('تم تحديث حالة المهمة');
    }


    public function render()
    {
        return view('livewire.employee-manage-task-livewire');
    }
}
