<?php

namespace App\Livewire;

use App\Office\Office;
use App\Living\Living;
use App\Mission\Mission;
use Livewire\Component;

class ManageOffice extends Component
{
    public Office $office;
    public $name, $start_date, $end_date, $living_id, $mission_id;

    public $livings; // To store available living options
    public $missions; // To store available mission options



    protected function rules()
    {
        return [
            'office.name' => ['required'],
            'office.start_date' => 'required|date',
            'office.end_date' => 'nullable|date|after_or_equal:office.start_date',
            'office.living_id' => 'required|exists:livings,id',
            'office.mission_id' => 'required|exists:missions,id',
        ];

    }

    public function mount(Office $office)
    {
        $this->office = $office;
        if ($office->exists) {
            $this->name = $office->name;
            $this->start_date = $office->start_date;
            $this->end_date = $office->end_date;
            $this->living_id = $office->living_id;
            $this->mission_id = $office->mission_id;
        }
        $this->livings = Living::all(); // Fetch all available living options
        $this->missions = Mission::all(); // Fetch all available mission options
    }

    public function save()
    {
        $this->office->name = $this->name;
        $this->office->living_id = $this->living_id;
        $this->office->mission_id = $this->mission_id;
        $this->office->start_date = $this->start_date;
        $this->office->end_date = $this->end_date;

        $this->validate();

        $this->office->save();

        // Redirect to the offices list or any other appropriate route
        return redirect()->route('admin.offices')->with('message', $this->office->exists ? 'تم تحديث المقر بنجاح' : 'تم إنشاء المقر بنجاح');
    }

    public function render()
    {
        return view('livewire.manage-office');
    }
}
