<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class LogsCounterLivewire extends Component
{
    public $unreadedCount = 0;

    public function mount()
    {
        $this->checkLogs();
    }

    public function checkLogs()
    {
        $lastReadedLog = auth()->user()->lastReadedLog;
        $this->unreadedCount = $lastReadedLog
            ? Activity::where('id', '>', $lastReadedLog->activity_id)->count()
            : Activity::count();
    }


    public function render()
    {
        return view('livewire.logs-counter-livewire');
    }
}
