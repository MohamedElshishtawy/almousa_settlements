<?php

namespace App\Task;

use App\Http\Controllers\Controller;
use App\Office\Office;

class TaskController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        return view('tasks.index', compact('offices'));
    }

    public function officeTasks($officeId)
    {
        $office = Office::find($officeId)->with('tasks')->first();
        return view('tasks.for-office', compact('office'));
    }

    public function storeTask(StoreRequest $request, $officeId)
    {
        $office = Office::find($officeId);
        $user = auth()->user();
        $task = Task::create([
            'office_id' => $office->id,
            'user_id' => $user->id,
            'description' => $request->description,
            'note' => $request->note,
        ]);
        activity('task')
            ->performedOn($task)
            ->causedBy($user)
            ->withProperties(['task' => $task])
            ->log('تم إنشاء مهمة جديدة');

        return redirect()->route('admin.tasks.office', $officeId)->with('success', 'تم إنشاء المهمة بنجاح');
    }

    public function show($officeId)
    {
        $tasks = auth()->user()->office->tasks;

        return view('tasks.managers-index', compact('tasks'));
    }
}
