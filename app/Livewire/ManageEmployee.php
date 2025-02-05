<?php

namespace App\Livewire;

use App\Models\User;
use App\Office\Office;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ManageEmployee extends Component
{
    public User $user;
    public $name, $phone, $office_id, $password, $role;
    public $offices;
    public $roles;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->roles = Role::all();
        if ($user->exists) {
            $this->name = $user->name;
            $this->phone = $user->phone;
            $this->role = $user->role->name;
            $this->office_id = $user->office ? $user->office->id : null;
        }
        $this->offices = Office::all();
    }

    public function save()
    {
        // Validate input data
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                Rule::unique('users', 'phone')->ignore($this->user->id),
            ],
            'role' => 'required|string|exists:roles,name',
            'office_id' => 'nullable|exists:offices,id',
            'password' => 'nullable|string|min:6', // Password is optional but must be at least 8 characters if provided
        ]);

        // Update user attributes
        $this->user->name = $this->name;
        $this->user->phone = $this->phone;
        $this->user->office_id = $this->office_id ?: null;

        // Only update the password if it's provided
        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();


        $this->user->syncRoles($this->role);

        return redirect()->route('admin.users')->with('success', 'تم حفظ الموظف بنجاح');
    }

    public function render()
    {
        return view('livewire.manage-employee');
    }
}
