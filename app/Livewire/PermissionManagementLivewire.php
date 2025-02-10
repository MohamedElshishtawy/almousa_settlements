<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionManagementLivewire extends Component
{
    public $roles = [];
    public $permissions = [];
    public $rolePermissions = [];

    public function mount()
    {
        // Fetch all roles and permissions
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();

        // Initialize rolePermissions array with existing permissions
        foreach ($this->roles as $role) {
            foreach ($this->permissions as $permission) {
                $this->rolePermissions[$role->id][$permission->id] = $role->hasPermissionTo($permission->name);
            }
        }
    }

    public function updateRolePermission($roleId, $permissionId)
    {
        $role = Role::find($roleId);
        $permission = Permission::find($permissionId);
        if ($role && $permission) {
            if ($this->rolePermissions[$roleId][$permissionId]) {
                $role->revokePermissionTo($permission);
                $log = 'تم إزالة الصلاحية '.__('roles_permissions.'.$permission->name).' من الرتبة '.__('roles_permissions.'.$role->name);
            } else {
                $role->givePermissionTo($permission);
                $log = 'تم إعطاء الصلاحية '.__('roles_permissions.'.$permission->name).' لرتبة '.__('roles_permissions.'.$role->name);
            }

            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            activity('logs')
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->log($log);
            session()->flash('success', 'تم تعديل الصلاحيات بنجاح');

        } else {
            session()->flash('error', 'حدث خطأ ما');
        }

    }


    public function render()
    {
        return view('livewire.permission-management-livewire');
    }
}
