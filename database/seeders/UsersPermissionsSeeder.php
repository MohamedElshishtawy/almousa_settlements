<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // import
            'import_writing_print',
            'import_create', 'import_edit', 'import_delete', 'import_show_price', 'import_print',
            'import_model2_create', 'import_model2_create_price',
            // surplus
            'surplus_create', 'surplus_edit', 'surplus_delete', 'surplus_show_price', 'surplus_print',
            'surplus_model2_create', 'surplus_model2_price',
            // employment
            'employment_create', 'employment_edit', 'employment_delete', 'employment_print',
            // dry food
            'dry_food_create', 'dry_food_edit', 'dry_food_delete', 'dry_food_print', 'confirm_dry_food_reception',
            // tasks
            'tasks_create', 'tasks_edit', 'tasks_delete',
            // delegate absence (corrected spelling)
            'delegate_absence_create', 'delegate_absence_edit', 'delegate_absence_delete', 'delegate_absence_print',
            // delegate
            'delegate_create', 'delegate_edit', 'delegate_delete',
            // break_fast reports
            'break_fast_create', 'break_fast_edit', 'break_fast_delete', 'break_fast_print',
            // unites
            'unites_management',
            // offices
            'offices_management',
            // users
            'users_management',
            // new
            'break_fast_products_manage',
            'manage_companies',
            'manage_dates',
            'obligations_create',
            'obligations_edit',
            'obligations_delete',
            'obligations_print',
            'delegate_rejects_management',
            'beneficiaries_report_manage',
            // products
            'manage_all_products',
            'manage_mission_products',
            // view_beneficiaries_report
            'view_beneficiaries_report',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'admin'])->givePermissionTo($permissions);

        // Define roles
        $roles = [
            'main_receiving_committee_president',
            'assistant_main_receiving_committee_president',
            'main_receiving_committee_member',

            'subsidiary_receiving_committee_president',
            'subsidiary_receiving_committee_member',

            'site_supervisor',

            'administrative_affairs_member',
            'security_member',
            'group_head',
            'supplier',
            'deputy_supplier',
            'company_representative',
            'delegate',
            'meal_dispenser',
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName) {
            $role = Role::create(['name' => $roleName]);

            // Assign permissions based on the role (customize these)
            switch ($roleName) {
                case 'main_receiving_committee_president':
                    $role->givePermissionTo([
                        'dry_food_create', 'dry_food_edit',
                        'dry_food_delete', 'tasks_create', 'tasks_edit', 'tasks_delete', 'delegate_absence_create',
                        'delegate_absence_edit', 'delegate_absence_delete', 'delegate_create', 'delegate_edit',
                        'delegate_delete',
                        'import_writing_print',
                        'import_create',
                        'import_edit',
                        'import_delete',
                        'import_show_price',
                        'surplus_model2_price',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                        'employment_create', 'employment_edit', 'employment_delete', 'employment_print',
                        'manage_mission_products',
                    ]);
                    break;
                case 'main_receiving_committee_member':
                    $role->givePermissionTo([
                        'dry_food_print', 'tasks_create',
                        'delegate_absence_print',
                        'import_writing_print',
                        'import_create',
                        'import_edit',
                        'import_delete',
                        'import_show_price',
                        'surplus_model2_price',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                        'employment_create', 'employment_edit', 'employment_delete',
                        'manage_mission_products',
                    ]);
                    break;
                case 'assistant_main_receiving_committee_president':
                    $role->givePermissionTo([
                        'dry_food_edit', 'dry_food_print', 'tasks_create',
                        'tasks_edit', 'delegate_absence_create', 'delegate_absence_edit', 'delegate_create',
                        'delegate_edit',
                        'import_writing_print',
                        'import_create',
                        'import_edit',
                        'import_delete',
                        'import_show_price',
                        'surplus_model2_price',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                        'employment_create', 'employment_edit', 'employment_delete',
                        'manage_mission_products',
                    ]);
                    break;
                case 'site_supervisor':
                    $role->givePermissionTo([
                        'tasks_create', 'tasks_edit', 'tasks_delete', 'delegate_absence_create',
                        'delegate_absence_edit',
                        'import_writing_print',
                        'import_create',
                        'import_edit',
                        'import_delete',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                        'employment_create', 'employment_edit', 'employment_delete',
                    ]);
                    break;
                case 'subsidiary_receiving_committee_president':
                    $role->givePermissionTo([
                        'dry_food_create', 'dry_food_edit',
                        'dry_food_delete', 'tasks_create', 'tasks_edit', 'tasks_delete', 'delegate_absence_create',
                        'delegate_absence_edit', 'delegate_absence_delete', 'delegate_create', 'delegate_edit',
                        'delegate_delete', 'import_writing_print',
                        'import_create',
                        'import_edit',
                        'import_delete',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                        'employment_create', 'employment_edit', 'employment_delete',
                    ]);
                    break;
                case 'subsidiary_receiving_committee_member':
                    $role->givePermissionTo([
                        'dry_food_print', 'tasks_create',
                        'delegate_absence_print', 'import_writing_print',
                        'import_create',
                        'import_edit',
                        'import_delete',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                        'employment_create', 'employment_edit', 'employment_delete',
                    ]);
                    break;
                case 'administrative_affairs_member':
                    $role->givePermissionTo(['users_management']);
                    break;
                case 'security_member':
                    // Add security-related permissions if needed
                    break;
                case 'group_head':
                    $role->givePermissionTo(['tasks_create', 'tasks_edit', 'tasks_delete']);
                    break;
                case 'supplier' or 'deputy_supplier':
                    $role->givePermissionTo([
                        'employment_create', 'employment_edit', 'employment_delete',
                        'import_writing_print', 'import_create', 'import_edit',
                        'import_delete',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                    ]);
                    break;
                case 'company_representative' :
                    $role->givePermissionTo([
                        'import_writing_print',
                        'import_create',
                        'import_edit',
                        'import_delete',
                        'import_model2_create',
                        'surplus_create',
                        'surplus_edit',
                        'surplus_delete',
                        'surplus_model2_create',
                        'employment_create', 'employment_edit', 'employment_delete',
                    ]);
                    break;
                case 'meal_dispenser':
                    $role->givePermissionTo(['dry_food_create', 'dry_food_edit', 'dry_food_delete', 'dry_food_print']);
                    break;
            }
        }

    }
}
