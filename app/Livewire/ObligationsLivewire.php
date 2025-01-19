<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Employee;
use App\Obligations\Bands;
use App\Obligations\Obligations;
use App\Office\Office;
use Livewire\Component;

class ObligationsLivewire extends Component
{

    public $bands = [], $contents, $headers, $obligation, $selectedOfficeId, $offices;
    public $selectedBands = [], $company;

    protected function getData() {



    }

    public function mount(Obligations $obligation)
    {
        $this->company = Company::CompanyOfTheSeason();
        $this->offices = Office::all()->filter(function($office) {
            return $office->living->title == 'ميدان';
        });
        $this->selectedOfficeId = auth()->user()->isAdmin() ? $this->offices->first()->id :
        Employee::find(auth()->user()->id)->office()->id;

        if ($obligation->id) {
            $this->obligation = $obligation;
            $dbBands = Bands::where('obligations_id', $obligation->id)->get();
            // sort by getting is active first
            $dbBands = $dbBands->sortByDesc('is_active');
            // pluck but make the key to be the band id
            $this->bands = $dbBands->pluck('head', 'id')->toArray();
            $this->contents = $dbBands->pluck('description', 'id')->toArray();
            $this->selectedBands = $dbBands->filter(function($band) {
                return $band->is_active;
            })->pluck('id')->toArray();
        } else {
            $this->bands = Obligations::$headers;
            $this->contents = [];
        }



    }

    public function toggleActivated($bandId)
    {
        $band = Bands::find($bandId);
        if ($band) {
            $band->update(['is_active' => !$band->is_active]);
        }
        if (in_array($bandId, $this->selectedBands)) {
            $this->selectedBands = array_diff($this->selectedBands, [$bandId]);
        } else {
            $this->selectedBands[] = $bandId;
        }
    }

    public function bandChange($bandId, $value)
    {
        $this->bands[$bandId] = $value;
    }

    public function contentChange($bandId, $value)
    {
        $this->contents[$bandId] = $value;
    }

    public function save()
    {
        $this->obligation = Obligations::create([
            'office_id' => $this->selectedOfficeId,
            'company_id' => $this->company->id,
        ]);
        foreach ($this->bands as $bandId => $band) {
            Bands::updateOrCreate(
                ['id' => $bandId],
                [
                    'head' => $band,
                    'description' => $this->contents[$bandId] ?? null,
                    'is_active' => in_array($bandId, $this->selectedBands),
                    'obligations_id' => $this->obligation->id
                ]
            );
        }

        $this->redirect(route('obligations.edit', $this->obligation->id));
    }

    public function edit()
    {
        // make the update for all data
        $this->obligation->update([
            'office_id' => $this->selectedOfficeId,
            'company_id' => $this->company,
        ]);
        foreach ($this->bands as $bandId => $band) {
            Bands::updateOrCreate(
                ['id' => $bandId],
                [
                    'head' => $band,
                    'description' => $this->contents[$bandId] ?? null,
                    'is_active' => in_array($bandId, $this->selectedBands),
                    'obligations_id' => $this->obligation->id
                ]
            );
        }
    }

    public function delete()
    {
        $this->obligation->delete();
        $this->redirect(route('obligations'));
    }

    public function render()
    {
        return view('livewire.obligations-livewire');
    }
}
