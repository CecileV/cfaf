<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use App\Role;
use Auth;

class RoleController extends Controller
{
    /* -- ESPACE ADMINISTRATION -- */
    public function list() {
        if (Auth::user()->can('list', Role::class)) {
            $roles = Role::get();
            return view('admin.role.list', compact('roles'));
        }
        return redirect(route('admin.dashboard'));
    }
    public function edit($id) {
        $role = Role::findOrFail($id);   
        if (Auth::user()->can('update', $role)) {
            return view('admin.role.edit', compact('role'));
        }
        return redirect(route('admin.roles'));
    }
    public function add() {
        if (Auth::user()->can('create', Role::class)) {
            return view('admin.role.add');
        }
        return redirect(route('admin.dashboard'));
    }
    public function update($id, StoreRole $request) {
        $role = Role::findOrFail($id);
        if (Auth::user()->can('update', $role)) {
            $role->name = $request->name;
            $role->save();
            return redirect( route('admin.role.edit', compact('id')) )->withSuccess('Rôle Modifié');
        }
        return redirect(route('admin.roles'));
    }
    public function store(StoreRole $request) {
        if (Auth::user()->can('create', Role::class)) {
            $role = new Role;
            $role->name = $request->name;
            $role->slug = str_replace( array(' ', '\'', '"'), array('_', '', ''), $request->slug ? $request->slug : $request->name );
            $role->save();
        }
        return redirect(route('admin.roles'));
    }
    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $role = Role::findOrFail($id);
        if (Auth::user()->can('delete', $role)) {
            if( $role->delete() ){
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }
    public function restore() {
        return redirect(route('admin.roles'));
    }
}