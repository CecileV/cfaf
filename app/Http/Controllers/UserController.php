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
        $users = User::get();
        return view('admin.user.list', ['users' => $users]);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        if(Auth::user()->hasAnyRole(array('admin', 'moderator')) || Auth::user()->id == $id) {
            return view('admin.user.edit', ['user' => User::findOrFail($id)]); 
        } else {
            return redirect(route('admin.users'));
        }
    }

    public function add() {
        return view('admin.user.add');
    }

    public function store(StoreUser $request) {

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $role_user  = Role::where('name', 'user')->first();
        $user->roles()->attach($role_user);

        return redirect(route('admin.users'));
    }

    /**
     * Update the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, StoreUser $request){

        if( Auth::user()->hasAnyRole(array('admin', 'moderator')) || Auth::user()->id == $id ) {

            $user = User::findOrFail($id);
            $name = $request->input('name');
            $email = $request->input('email');
            $user->update(['name' => $name, 'email' => $email]);

            // Modification du mot de passe
            $old_password = $request->input('old_password');
            $password = $request->input('password');
            if(!empty($password)){
                if( Auth::user()->hasAnyRole(array('admin', 'moderator')) ){
                    $user->password = bcrypt($password);
                    $user->save();
                } elseif( Hash::check($old_password, $user->password) ){
                    $user->password = bcrypt($password);
                    $user->save();
                } else {
                    return redirect(route('admin.user.edit', $id))
                        ->withErrors('Renseignez votre mot de passe actuel dans le champ mot de passe.');
                }
            }

            return redirect(route('admin.user.edit', $id))->with('success', 'Votre profil a été mis à jour.');
        } else {
            return redirect(route('admin.dashboard'));
        }
    }

    /**
     * Update the password for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function updatePassword($id, Request $request)
    {
        if( Auth::user()->hasAnyRole(array('admin', 'moderator')) || Auth::user()->id == $id ) {

            if( !Auth::user()->hasAnyRole(array('admin', 'moderator')) ){
                $request->validate([
                    'old_password' => 'required',
                    'password' => 'required|string|min:6|confirmed',
                ]);                
            } else {
                $request->validate([
                    'password' => 'required|string|min:6|confirmed',
                ]);  
            }


            $user = User::findOrFail($id);
            if( !Auth::user()->hasAnyRole(array('admin', 'moderator')) ){
                $user->password = bcrypt($request->password);
                $user->save();
                return redirect(route('admin.user.edit', $id))
                    ->with('success', 'Le mot de passe a été mis à jour : "'.$request->password.'".');
            } elseif( Hash::check($request->old_password, $user->password) ){
                $user->password = bcrypt($request->password);
                $user->save();
                return redirect(route('admin.user.edit', $id))
                    ->with('success', 'Votre mot de passe a été mis à jour.');
            } else {
                return redirect(route('admin.user.edit', $id))
                    ->withErrors('Renseignez votre mot de passe actuel dans le champ mot de passe.'); 
            }
            
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
        if(empty($id)){
            if(!empty($request->has('id'))){
                $id = $request->input('id');
            }
        }
        if(!empty($id)){
            $user = User::findOrFail($id);
            $return = $user->delete();            
        } else {
            $return = false;
        }

        return json_encode($return);
    }

    public function restore() {
        return redirect(route('admin.dashboard'));
    }
}