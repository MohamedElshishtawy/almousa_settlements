<?php

namespace App\Task;

use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks.index');
    }

    public function managers()
    {
        return view('tasks.managers-index');
    }
}
