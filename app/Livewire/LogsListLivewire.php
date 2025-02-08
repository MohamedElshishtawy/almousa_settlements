<?php

namespace App\Livewire;

use App\Models\LastReadedLog;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class LogsListLivewire extends Component
{
    public $lastLogs;
    public $unreadedLogsIds = [];

    public function mount()
    {
        $this->checkLogs();
    }

    public function checkLogs()
    {
        $this->lastLogs = Activity::orderBy('created_at', 'desc')->limit(6)->get();
        if ($this->lastLogs->isNotEmpty()) {
            $this->makeAllVisible();
        }
    }

    public function makeAllVisible()
    {
        $user = auth()->user();

        $lastReadedLog = $user->lastReadedLog;

        if ($lastReadedLog) {
            $lastReadedLog->update([
                'activity_id' => $this->lastLogs->first()->id,
            ]);
        } else {
            LastReadedLog::create([
                'user_id' => $user->id,
                'activity_id' => $this->lastLogs->first()->id,
            ]);
        }


    }

    public function render()
    {
        return view('livewire.logs-list-livewire');
    }
}
