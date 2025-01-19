<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;
use mysql_xdevapi\Collection;

class ManageCompanyLivewire extends Component
{
    public string $name = '';
    public string $date = '';
    public array $names = [];
    public array $dates = [];
    public $companies   = [];

    protected array $rules = [
        'name' => 'required|string|max:255',
        'date' => 'required|date|unique:companies,date',
        'names.*' => 'string|max:255',
        'dates.*' => 'date|unique:companies,date',
    ];

    public function mount(): void
    {
        $this->getCompanies();
    }

    protected function getCompanies(): void
    {
        $this->companies = Company::all();
        foreach ($this->companies as $company) {
            $this->names[$company['id']] = $company['name'];
            $this->dates[$company['id']] = $company['date'];
        }
    }

    public function delete(int $id): void
    {
        $company = Company::find($id);
        if ($company && $company->obligations()->count() == 0) {
            $company->delete();
            $this->getCompanies();
        }
    }

    public function editName(int $id): void
    {
        $this->validateOnly('names.' . $id);

        $company = Company::find($id);
        if ($company) {
            $company->name = $this->names[$id] ?: 'غير معروف';
            $company->save();
        }
    }

    public function editDate(int $id): void
    {
        $this->validateOnly('dates.' . $id);

        $company = Company::find($id);
        if ($company) {
            $company->date = $this->dates[$id];
            $company->save();
        }
    }

    public function save(): void
    {
        $this->validate();

        Company::create([
            'name' => $this->name,
            'date' => $this->date,
        ]);

        $this->resetForm();
        $this->getCompanies();
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->date = '';
    }

    public function render()
    {
        return view('livewire.manage-company-livewire');
    }
}
