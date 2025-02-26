<?php

namespace App\Livewire;

use App\Models\Company;
use App\Obligations\Bands;
use App\Obligations\Obligations;
use App\Office\Office;
use Livewire\Component;

class ObligationsLivewire extends Component
{
    public $bands = [];
    public $contents = [];
    public $headers;
    public $obligation;
    public $selectedOfficeId;
    public $offices;
    public $selectedBands = [];
    public $company;

    public function mount(Obligations $obligation)
    {
        // Load the company and offices for initialization
        $this->company = Company::CompanyOfTheSeason();
        $this->offices = Office::all();

        if (auth()->user()->office) {
            $this->offices = $this->offices->filter(function ($office) {
                return auth()->user()->office->id == $office->id;
            });
        }

        // Determine the selected office
        $this->selectedOfficeId = $this->offices->first()->id;

        // Initialize obligation and bands
        if ($obligation->id) {
            $this->initializeExistingObligation($obligation);
        } else {
            $this->bands = Obligations::$headers;
            $this->contents = [];
        }
    }

    private function initializeExistingObligation(Obligations $obligation)
    {
        $this->obligation = $obligation;

        // Retrieve bands sorted by active status
        $dbBands = Bands::where('obligations_id', $obligation->id)->get()->sortByDesc('is_active');
        $this->bands = $dbBands->pluck('head', 'id')->toArray();
        $this->contents = $dbBands->pluck('description', 'id')->toArray();
        $this->selectedBands = $dbBands->filter(fn($band) => $band->is_active)->pluck('id')->toArray();
    }

    public function toggleActivated($bandId)
    {
        $band = Bands::find($bandId);
        if ($band) {
            $band->update(['is_active' => !$band->is_active]);
        }

        // Toggle the band's selection state
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

        $this->saveBands();

        activity('obligations')
            ->performedOn($this->obligation)
            ->causedBy(auth()->user())
            ->withProperties(['obligation_id' => $this->obligation->id])
            ->log('تم إنشاء محضر على المتعهد');

        session()->flash('success', 'تم إنشاء المحضر  بنجاح');

        $this->redirect(route('obligations'));
    }

    private function saveBands()
    {
        foreach ($this->bands as $bandId => $band) {
            Bands::create(
                [
                    'head' => $band,
                    'description' => $this->contents[$bandId] ?? null,
                    'is_active' => in_array($bandId, $this->selectedBands),
                    'obligations_id' => $this->obligation->id,
                ]
            );
        }
    }

    public function edit()
    {
        $this->obligation->update([
            'office_id' => $this->selectedOfficeId,
            'company_id' => $this->company->id,
        ]);

        $this->editBands();

        activity('obligations')
            ->performedOn($this->obligation)
            ->causedBy(auth()->user())
            ->withProperties([
                'office_id' => $this->selectedOfficeId,
                'old' => $this->obligation
            ])
            ->log('تم تعديل محضر على النتعهد');
        session()->flash('success', 'تم تعديل المحضر  بنجاح');
    }

    //edit bands

    private function editBands()
    {
        // delete all bands
        Bands::where('obligations_id', $this->obligation->id)->delete();

        // save bands
        $this->saveBands();


    }


    public function delete()
    {
        $this->obligation->delete();


        activity('obligations')
            ->performedOn($this->obligation)
            ->causedBy(auth()->user())
            ->withProperties([
                'office_id' => $this->selectedOfficeId,
                'old' => $this->obligation
            ])
            ->log('تم حذف محضر على النتعهد');


        return redirect()->route('obligations')->with('success', 'تم حذف المحضر بنجاح');

    }

    public function render()
    {
        return view('livewire.obligations-livewire');
    }
}
