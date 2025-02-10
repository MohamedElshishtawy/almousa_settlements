<div class="container mt-4">
    <x-message/>
    <h3 class="mb-3">إدارة الصلاحيات</h3>
    <style>
        /* Ensure checkboxes are centered */
        td {
            vertical-align: middle;
        }
    </style>

    <div class="table-responsive">
        <table class="table table-bordered text-right table-sm table-hover" style="font-size: 13px">
            <thead class="table-dark">
            <tr>
                <th colspan="2">الصلاحية / الرتبة</th>
                @foreach($roles as $role)
                    <th>{{ __('roles_permissions.' . $role->name) }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{\Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($loop->iteration)}}</td>
                    <td class="fw-bold">{{ __('roles_permissions.' . $permission->name) }}</td>
                    @foreach($roles as $role)
                        <td class="text-center">
                            <input
                                type="checkbox"
                                wire:change="updateRolePermission({{ $role->id }}, {{ $permission->id }})"
                                class="form-check-input"
                                @if($role->hasPermissionTo($permission->name)) checked @endif
                            >
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

