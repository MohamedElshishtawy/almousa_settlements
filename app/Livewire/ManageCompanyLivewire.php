<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;

class ManageCompanyLivewire extends Component
{
    public string $name = '';
    public string $delegate_name = '';
    public string $delegate_rank = '';
    public string $delegate_phone = '';
    public bool $is_active = false;

    public array $names = [];
    public array $delegate_names = [];
    public array $delegate_ranks = [];
    public array $delegate_phones = [];
    public array $is_actives = [];
    public $companies = [];

    protected array $rules = [
        'name' => 'required|string|max:255',
        'delegate_name' => 'string|max:255',
        'delegate_rank' => 'string|max:255',
        'delegate_phone' => 'string|max:255',
        'is_active' => 'boolean',
        'names.*' => 'string|max:255',
        'is_actives.*' => 'boolean',
    ];

    public function mount(): void
    {
        $this->getCompanies();
    }

    protected function getCompanies(): void
    {
        $this->companies = Company::all();
        foreach ($this->companies as $company) {
            $this->names[$company->id] = $company->name;
            $this->delegate_names[$company->id] = $company->delegate_name;
            $this->delegate_ranks[$company->id] = $company->delegate_rank;
            $this->delegate_phones[$company->id] = $company->delegate_phone;
            $this->is_actives[$company->id] = $company->is_active;
        }
    }

    public function delete(int $id): void
    {
        $company = Company::find($id);
        if ($company && $company->obligations()->count() === 0) {
            $company->delete();
            $this->getCompanies();
        }
    }

    public function editField(int $id, string $field, $value): void
    {
//        $this->validateOnly("$field.$id");
        $company = Company::find($id);
        if ($company) {
            $company->$field = $value ?? '';
            if ($field === 'is_active') {
                $comps = Company::where('is_active', '>', 0)->update(['is_active' => false]);
                $company->is_active = true;
            }
            $company->save();
        }
    }

    public function save(): void
    {
        $this->validate();

        $company = Company::create([
            'name' => $this->name,
            'delegate_name' => $this->delegate_name,
            'delegate_rank' => $this->delegate_rank,
            'delegate_phone' => $this->delegate_phone,
            'is_active' => $this->is_active,
        ]);

        if ($this->is_active) {
            Company::where('id', '!=', $company->id)->update(['is_active' => false]);
        }

        $this->resetForm();
        $this->getCompanies();
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->delegate_name = '';
        $this->delegate_rank = '';
        $this->delegate_phone = '';
        $this->is_active = false;
    }

    public function render()
    {
        return view('livewire.manage-company-livewire');
    }
}
