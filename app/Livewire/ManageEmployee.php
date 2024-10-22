<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\EmployeeOffice;
use App\Office\Office;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ManageEmployee extends Component
{

    public Employee $employee;
    public $name, $phone, $rank, $office_id, $password;
    public $offices;

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
        if ($employee->exists) {
            $this->name = $employee->name;
            $this->phone = $employee->phone;
            $this->rank = $employee->rank;
            $this->office_id = $employee->employeeOffice->office_id;
        }
        $this->offices = Office::all();
    }

    public function save()
    {
        $this->employee->name = $this->name;
        $this->employee->phone = $this->phone;
        $this->employee->rank = $this->rank;
        $this->employee->password = Hash::make($this->password);

        $this->validate([
            'employee.name' => 'required',
            'employee.phone' => 'required|unique:users,phone,' . $this->employee->id,
            'employee.rank' => 'required',
            'office_id' => 'required|exists:offices,id',
        ]);

        $this->employee->save();

        EmployeeOffice::create([
            'office_id' => $this->office_id,
            'user_id' => $this->employee->id
        ]);


        return redirect()->route('admin.users');
    }

    public function render()
    {
        return view('livewire.manage-employee');
    }
}
