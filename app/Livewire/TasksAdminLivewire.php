<?php

namespace App\Livewire;

use App\Living\Living;
use App\Office\Office;
use App\Task\OfficeTask;
use App\Task\Task;
use Livewire\Component;

class TasksAdminLivewire extends Component
{
    public $title = '';
    public $state = '';
    public $notes = '';
    public $office_id;
    public $tasks = [];
    public $livingOptions = [];
    public $titles = [], $states = [], $notesArr = [], $office_ids = [];
    public $officesOptions = [];
    public $tasksStates ;

    protected $rules = [
        'title' => 'required|string|max:255',
        'state' => 'required',
        'notes' => 'nullable|string|max:500',
        'office_id' => 'required|exists:offices,id',
    ];

    public function mount()
    {
        // Fetch all tasks and living groups on initialization
        $this->loadTasks();
        $this->officesOptions = Office::all();
        $this->tasksStates = Task::$states;
    }

    protected function loadTasks()
    {
        $this->tasks = Task::all();
        foreach ($this->tasks as $task) {
            $this->titles[$task->id] = $task->title;
            $this->states[$task->id] = $task->state;
            $this->notesArr[$task->id] = $task->notes;
            $this->office_ids[$task->id] = $task->office_id;
        }
    }

    public function editField(int $id, string $field, $value): void
    {
        $task = Task::find($id);
        if ($task) {
            $task->$field = $value ?? '';
            $task->save();
            $this->loadTasks();
        }
    }

    public function deleteTask(int $id): void
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            $this->loadTasks();
        }
    }

    public function saveTask()
    {
        $this->validate();

        $task = Task::create([
            'title' => $this->title,
            'state' => $this->state,
            'notes' => $this->notes,
            'office_id' => $this->office_id,
        ]);

        $this->resetForm();
        $this->loadTasks();
    }

    protected function resetForm()
    {
        $this->title = '';
        $this->state = '';
        $this->notes = '';
        $this->office_id = null;
    }

    public function render()
    {
        return view('livewire.tasks-admin-livewire');
    }
}
