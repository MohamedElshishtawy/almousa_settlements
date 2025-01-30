<?php

namespace App\Livewire;

use App\Employment\Employment;
use App\Living\Living;
use Livewire\Component;

class ManageEmploymentLivewire extends Component
{
    public string $title = '';
    public int $count = 0;
    public int $benefits = 0;

    public array $titles = [];
    public array $counts = [];
    public $employments = [];
    public $benefitses = [];
    public $livings = [];
    public $livingId = null;

    protected array $rules = [
        'title' => 'required|string|max:255',
        'count' => 'required|integer|min:0',
        'benefits' => 'required|integer|min:0',
        'titles.*' => 'required|string|max:255',
        'counts.*' => 'required|integer|min:0',
        'benefitses.*' => 'required|integer|min:0',
    ];

    public function mount(): void
    {
        $this->livings = Living::all();
        $this->getEmployments();
    }

    protected function getEmployments(): void
    {
        $this->employments = Employment::where('living_id', $this->livingId)->get();
        foreach ($this->employments as $employment) {
            $this->titles[$employment->id] = $employment->title;
            $this->counts[$employment->id] = $employment->count;
            $this->benefitses[$employment->id] = $employment->benefits;
        }
    }

    public function updatedLivingId($value): void
    {
        $this->livingId = $value;
        $this->getEmployments();
    }

    public function delete(int $id): void
    {
        $employment = Employment::find($id);
        if ($employment) {
            $employment->delete();
            $this->getEmployments();
        }
    }

    public function editField(int $id, string $field, $value): void
    {
        $employment = Employment::find($id);
        if ($employment) {
            $employment->$field = $value ?? '';
            $employment->save();
        }
    }

    public function save(): void
    {
        $this->validate();

        Employment::create([
            'title' => $this->title,
            'count' => $this->count,
            'benefits' => $this->benefits,
            'living_id' => $this->livingId,
        ]);

        $this->resetForm();
        $this->getEmployments();
    }

    protected function resetForm(): void
    {
        $this->title = '';
        $this->count = 0;
        $this->benefits = 0;
    }

    public function render()
    {
        return view('livewire.manage-employment-livewire');
    }
}
