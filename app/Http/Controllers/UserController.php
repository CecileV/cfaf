<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUser;
use Hash;

class UserController extends Controller
{

    /* -- ESPACE ADMINISTRATION -- */

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function list() {
        if (Auth::user()->can('list', User::class)) {
            $users = User::get();
            return view('admin.user.list', ['users' => $users]);
        } else {
            return redirect(route('admin.dashboard'));
        }
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $user = User::findOrFail($id);
        if (Auth::user()->can('update', $user)) {
            return view('admin.user.edit', ['user' => $user]); 
        } else {
            return redirect(route('admin.users'));
        }
    }

    public function add() {
        if (Auth::user()->can('create', User::class)) {
            return view('admin.user.add');
        } else {
            return redirect(route('admin.users'));
        }
    }

    public function store(StoreUser $request) {
        if (Auth::user()->can('create', User::class)) {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            $role_user  = Role::where('name', 'user')->first();
            $user->roles()->attach($role_user);
        }
        return redirect(route('admin.users'));
    }

    /**
     * Update the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, StoreUser $request){

        $user = User::findOrFail($id);

        if (Auth::user()->can('update', $user)) {

            $name = $request->input('name');
            $email = $request->input('email');
            $user->update(['name' => $name, 'email' => $email]);

            // Modification du mot de passe
            $password = $request->input('password');
            if(!empty($password) && Auth::user()->can('update_password', $user) ){
                $user->password = bcrypt($password);
                $user->save();
            }

            return redirect(route('admin.user.edit', $id))->with('success', 'Votre profil a été mis à jour.');
        } else {
            return redirect(route('admin.dashboard'));
        }
    }
    
    /**
     * Delete the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id = NULL, Request $request)
    {
        $return = false;
        if(empty($id)){
            if(!empty($request->has('id'))){
                $id = $request->input('id');
            }
        }
        if(!empty($id)){
            $user = User::findOrFail($id);
            if( Auth::user()->can('delete', $user) ){
                $return = $user->delete();   
            }
        }

        return json_encode($return);
    }

    public function restore() {
        return redirect(route('admin.dashboard'));
    }
}