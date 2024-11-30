<?php

namespace App\Livewire;

use Livewire\Component;

class HijriDateLiveWire extends Component
{
    public $dates, $gregorianDates, $years , $months, $days, $weekDays;
    public $gregorianDate, $year = '1446', $month, $monthName, $day, $weekDay;

    // rules
    protected $rules = [
        'gregorianDate' => 'required',
        'year' => 'required',
        'month' => 'required',
        'day' => 'required',
        'weekDay' => 'required',
    ];

    protected function getDates()
    {
        // use paginate to limit the number of records
        $this->dates = \App\Models\HijriDate::all();
        foreach ($this->dates as $date) {
            $this->gregorianDates[$date->id] = $date->gregorian_date;
            $this->years[$date->id] = $date->year;
            $this->months[$date->id] = $date->month;
            $this->days[$date->id] = $date->day;
            $this->weekDays[$date->id] = $date->weekday;
        }
    }

    public function mount()
    {
        $this->getDates();

    }

    public function add()
    {
        $this->validate();
        $date = \App\Models\HijriDate::create([
            'gregorian_date' => $this->gregorianDate,
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'weekday' => $this->weekDay,
        ]);



        $this->reset();
        $this->getDates();
    }

    public function delete($id)
    {
        \App\Models\HijriDate::destroy($id);

        $this->dates = $this->dates->except($id);
    }

    public function changeGregorianDate($dateId, $value)
    {
        $date = \App\Models\HijriDate::find($dateId);
        $date->update(['gregorian_date' => $value]);
    }

    public function changeYear($dateId, $value)
    {
        $date = \App\Models\HijriDate::find($dateId);
        $date->update(['year' => $value]);
    }

    public function changeMonth($dateId, $value)
    {
        $date = \App\Models\HijriDate::find($dateId);
        $date->update(['month' => $value]);
    }

    public function changeDay($dateId, $value)
    {
        $date = \App\Models\HijriDate::find($dateId);
        $date->update(['day' => $value]);
    }

    public function changeWeekDay($dateId, $value)
    {
        $date = \App\Models\HijriDate::find($dateId);
        $date->update(['weekday' => $value]);
    }

    public function render()
    {
        return view('livewire.hijri-date-live-wire');
    }
}
