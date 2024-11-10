<?php

namespace App\Livewire;

use App\Office\Office;
use App\Living\Living;
use App\Mission\Mission;
use Livewire\Component;

class ManageOffice extends Component
{
    public Office $office;
    public $name, $start_date, $end_date, $living_id, $getting_ready_start_date, $getting_ready_end_date;
    public $mission_id; // main mission


    public $livings; // To store available living options
    public $missions; // To store available mission options



    protected function rules()
    {
        return [
            'office.name' => ['required'],
            'office.living_id' => 'required|exists:livings,id',
            'getting_ready_start_date' => 'nullable|date|before:office.start_date',
            'getting_ready_end_date' => 'nullable|date|after_or_equal:office.getting_ready_start_date',
            'start_date' => 'required|date|after:office.getting_ready_start_date',
            'end_date' => 'nullable|date|after_or_equal:office.start_date',
            'mission_id' => 'required|exists:missions,id',
        ];

    }

    public function mount(Office $office)
    {
        $this->office = $office;
        if ($office->exists) {
            $this->name = $office->name;
            $this->living_id = $office->living_id;
            $mainMission = $office->OfficeMissions()
                ->whereNotIn('mission_id', Mission::gettingReadyMissionsIds())->first();
            $this->mission_id = $mainMission->id;
            $this->start_date = $mainMission->start_date;
            $this->end_date = $mainMission->end_date;
            $gettingReadyMission = $office->OfficeMissions()
                ->whereIn('mission_id', Mission::gettingReadyMissionsIds())->first();
            $this->getting_ready_start_date = $gettingReadyMission->start_date;
            $this->getting_ready_end_date = $gettingReadyMission->end_date;
        }
        $this->livings = Living::all();
        $this->missions = Mission::all()->slice(0,2); // Fetch only hajj and ramadan missions
    }

    public function save()
    {

        $this->office->name = $this->name;
        $this->office->living_id = $this->living_id;
        $this->office->save();

        // update of make new for the office relations tables
        if ($this->office->OfficeMissions()->count() > 0) {
            $MainMission = $this->office->OfficeMissions()
                ->whereNotIn('mission_id', Mission::gettingReadyMissionsIds())->first();
            $MainMission->start_date = $this->start_date;
            $MainMission->end_date = $this->end_date;
            $MainMission->save();
            $getReadyMission = $this->office->OfficeMissions()
                ->whereIn('mission_id', Mission::gettingReadyMissionsIds())->first();
            $getReadyMission->start_date = $this->getting_ready_start_date;
            $getReadyMission->end_date = $this->getting_ready_end_date;
            $getReadyMission->save();
        } else {
            $this->office->OfficeMissions()->create([
                'mission_id' => $this->mission_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
            $this->office->OfficeMissions()->create([
                'mission_id' => Mission::syncMainWithReady($this->mission_id),
                'start_date' => $this->getting_ready_start_date,
                'end_date' => $this->getting_ready_end_date,
            ]);
        }

        // Redirect to the offices list or any other appropriate route
        return redirect()->route('admin.offices')->with('message', $this->office->exists ? 'تم تحديث المقر بنجاح' : 'تم إنشاء المقر بنجاح');
    }

    public function render()
    {
        return view('livewire.manage-office');
    }
}
