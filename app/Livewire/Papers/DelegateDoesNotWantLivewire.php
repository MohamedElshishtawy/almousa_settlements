<?php

namespace App\Livewire\Papers;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Models\Delegate;
use App\Models\HijriDate;
use App\Office\Office;
use Livewire\Component;

class DelegateDoesNotWantLivewire extends Component
{
    public $offices , $delegates, $date;
    public $selectedOfficeId = null;
    public $selectedDelegateId = null;
    public $delegate;
    public $formatedDate;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->updatedDate();
        $this->offices = Office::all()->filter(function($office) {
            return $office->living->title == 'ميدان';
        });

    }

    public function updatedSelectedOfficeId()
    {
        $this->delegates = $this->selectedOfficeId ? Office::find($this->selectedOfficeId)->delegates : null;
    }

    public function updatedDate()
    {
        $hijri  = HijriDate::where('gregorian_date', $this->date)->first();
        if ($hijri) {
            $year = Numbers::ShowInArabicDigits($hijri->year);
            $month = Numbers::ShowInArabicDigits($hijri->month);
            $day = Numbers::ShowInArabicDigits($hijri->day);
            $this->formatedDate = $day . '/' . $month . '/' . $year . ' هـ';
        } else {
            $this->formatedDate = $this->date . ' ميلادي';
        }
    }

    public function updatedSelectedDelegateId()
    {
        $this->delegate = $this->selectedDelegateId ? Delegate::find($this->selectedDelegateId) : null;
    }


    public function render()
    {
        return view('livewire.papers.delegate-does-not-want-livewire');
    }
}
