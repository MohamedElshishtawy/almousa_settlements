<?php

namespace App\Livewire;


use App\Models\Employee;
use App\Task\Task;
use Livewire\Component;

class TasksManagerLivewire extends Component
{
    public $tasks = [];
    public $states = [], $notesArr = [], $office_ids = [];
    public $tasksStates;
    public Employee $manager;

    public function mount()
    {

        $this->tasksStates = Task::$states;
        $this->manager = Employee::find(auth()->id());
        $this->loadTasks();

    }

    protected function loadTasks()
    {
        // Fetch tasks related to the user's office
        $office = $this->manager->office();

        // Get tasks for the specific office
        $this->tasks = $office->tasks;

        // Populate state, notes, and office information
        foreach ($this->tasks as $task) {
            $this->states[$task->id] = $task->state;
            $this->notesArr[$task->id] = $task->notes;
            $this->office_ids[$task->id] = $task->office_id;
        }
    }

    public function editField(int $id, string $field, $value): void
    {
        $task = Task::find($id);
        if ($task) {
            // Only allow editing state and notes
            if (in_array($field, ['state', 'notes'])) {
                $task->$field = $value ?? '';
                $task->save();
                $this->loadTasks(); // Refresh tasks after update
            }
        }
    }

    public function render()
    {
        return view('livewire.tasks-manager-livewire');
    }
}
