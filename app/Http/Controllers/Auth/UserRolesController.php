<?php

namespace App\Http\Controllers\Auth;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Laratrust\Helper;

class UserRolesController
{
    protected $rolesModel;

    protected $permissionModel;

    public function __construct()
    {
        $this->rolesModel = config('laratrust.models.role');
        $this->permissionModel = config('laratrust.models.permission');
    }

    public function index()
    {        
        $permissions = $this->permissionModel::get()->groupBy('target_module')
            ->map(function ($modules) {
                return $modules->groupBy('operation')
                    ->map(function ($operations) {
                        return $operations->map(function ($permission) {
                            return [
                                'id' => $permission->id,
                                'name' => $permission->name,
                                'display_name' => $permission->display_name,
                                'description' => $permission->description,
                            ];
                        });
                    });
            });

        return View::make('livewire.user-management.access.userRoles', [
            'roles' => $this->rolesModel::withCount('permissions')
                ->latest()->get(),
            'permissions' => collect($permissions),
        ]);
    }

    // public function create()
    // {
    //     return View::make('laratrust::panel.edit', [
    //         'model' => null,
    //         'permissions' => $this->permissionModel::all(['id', 'name']),
    //         'type' => 'role',
    //     ]);
    // }

    // public function show(Request $request, $id)
    // {
    //     $role = $this->rolesModel::query()
    //         ->with('permissions:id,name,display_name')
    //         ->findOrFail($id);

    //     return View::make('livewire.user-management.access.showRole', ['role' => $role]);
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
            'user_group' => 'required|string',
        ]);

        $role = $this->rolesModel::create($data);
        $role->syncPermissions($request->get('permissions') ?? []);

        return redirect(route('user-roles.index'))->with('success', 'Role created successfully!');
    }

    public function edit($id)
    {
        if (Auth::user()->hasPermission(['update_role'])) {
            $role = $this->rolesModel::query()
                ->with('permissions:id')
                ->findOrFail($id);

            if (! Helper::roleIsEditable($role)) {
                Session::flash('success', 'The role is not editable');

                return redirect()->back();
            }

            $permissions = $this->permissionModel::all()
                ->map(function ($permission) use ($role) {
                    $permission->assigned = $role->permissions
                        ->pluck('id')
                        ->contains($permission->id);

                    return $permission;
                })
                ->groupBy('target_module')
                ->map(function ($modules) {
                    return $modules->groupBy('operation')
                        ->map(function ($operations) {
                            return $operations->map(function ($permission) {
                                return [
                                    'id' => $permission->id,
                                    'name' => $permission->name,
                                    'display_name' => $permission->display_name,
                                    'description' => $permission->description,
                                    'operation' => $permission->operation,
                                    'assigned' => $permission->assigned,
                                ];
                            });
                        });
                });

                // return $permissions;
            return View::make('livewire.user-management.access.editRolePermission', [
                'model' => $role,
                'permissions' => $permissions,
                'type' => 'role',
            ]);
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function update(Request $request, $id)
    {
        $role = $this->rolesModel::findOrFail($id);

        if (! Helper::roleIsEditable($role)) {
            Session::flash('laratrust-error', 'The role is not editable');
            return redirect()->back();
        }

        $data = $request->validate([
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
            'user_group' => 'required|string',
        ]);

        $role->update($data);
        $role->syncPermissions($request->get('permissions') ?? []);

        return redirect(route('user-roles.index'))->with('success', 'Role Updated successfully!');
    }

    public function destroy($id)
    {
        $usersAssignedToRole = DB::table(config('laratrust.tables.role_user'))
            ->where(config('laratrust.foreign_keys.role'), $id)
            ->count();
        $role = $this->rolesModel::findOrFail($id);

        if (! Helper::roleIsDeletable($role)) {
            return redirect()->back()->with('error', 'The role is not deletable!');
        }

        if ($usersAssignedToRole > 0) {
            return redirect()->back()->with('error', 'Role is attached to one or more users. It can not be deleted!');
        } else {
            $this->rolesModel::destroy($id);

            return redirect()->back()->with('success', 'Role deleted successfully!');
        }
    }
}
