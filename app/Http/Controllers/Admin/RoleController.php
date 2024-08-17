<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use \Illuminate\Http\Request;
use DataTables;

class RoleController extends Controller {

	private function view($blade_file, $compact = []) {
		return view('admin.pages.settings.role.' . $blade_file, $compact);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request) {
		if ($request->ajax()) {
			$data = Role::select(['name', 'id']);
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('permissions', fn($row) => $row->permissions->implode('name',', '))
				->addColumn('action', function ($row) {
					$btn = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="' . route('admin.role.edit', $row->id) . '">Edit</a>
                      <a class="dropdown-item dt-ajax-delete" data-url="' . route('admin.role.destroy', $row->id) . '" href="#">Delete</a>
                    </div>
                  </div>';
					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		return $this->view('index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		return $this->view('create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		DB::transaction(function () use ($request) {
			$permissions = Permission::find([$request->permissions]);
			Role::create(['name' => $request->name])->syncPermissions($permissions);
		});
		return to_route('admin.role.index')->with('success', 'Role Created');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Role $role) {
		return $this->view('edit', compact('role'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Role $role) {
		DB::transaction(function () use ($request,$role) {
			$permissions = Permission::find([$request->permissions]);
			tap($role, fn($rol) => $rol->update(['name' => $request->name]))->syncPermissions($permissions);
		});
		return to_route('admin.role.index')->with('success', 'Role Updated');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Role $role) {
		$role->delete();
        // return response()->json(['message' => 'Role Deleted']);
	}
}
