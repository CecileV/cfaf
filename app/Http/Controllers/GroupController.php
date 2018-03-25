<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGroup;
use App\Group;
use App\User;
use App\Rank;
use App\Country;
use App\Department;

class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request, $id)
    {

        $group = Group::findOrFail($id);
        $data = compact('group');
        return view('group.users', $data);
    }

    public function usersTable(Request $request, $id)
    {

        $group = Group::findOrFail($id);

        $ranks = Rank::get();
        foreach ($ranks as $rank) { $users[$rank->slug] = array(); }

        foreach($group->users as $user){
            foreach ($ranks as $rank) {
                if($user->pivot->rank_id == $rank->id){
                    $users[$rank->slug][] = $user;
                    break;
                }
            }
        }

        /* DROITS */
        $can_edit_rank = false;
        $can_delete = false;

        if(Auth::user()->hasAnyRole(array('admin', 'moderator'))) {
            $can_edit_rank = true;
            $can_delete = true;
        }
        else {
            // Si l'utilisateur est administrateur du group, il peut le modifier
            $user_rank = Auth::user()->groups->where('id', $id)->first()->pivot->rank_id;
            if(!empty($user_rank) && $user_rank == '1'){
                $can_edit_rank = true;
                $can_delete = true;
            }
        }


        $data = compact('group', 'users', 'ranks', 'can_edit_rank', 'can_delete');
        return view('group.users_table', $data);
    }

    public function userAdd(Request $request, $id)
    {

        $group = Group::findOrFail($id);
        $iIDUser = $request->input('user');
        $aUser = User::findOrFail($iIDUser);

        if(!empty($aUser) ){

            $authorized = false;
            if(Auth::user()->id == $aUser->id ) { $authorized = true; }
            elseif(Auth::user()->hasAnyRole(array('admin', 'moderator'))) { $authorized = true; }
            else {
                // Si l'utilisateur est administrateur du group, il peut le modifier
                $user_rank = Auth::user()->groups->where('id', $id)->first()->pivot->rank_id;
                if(!empty($user_rank) && $user_rank == '1'){
                    $authorized = true;
                }
            }

            if(empty($authorized)){
                return json_encode($authorized);
            } else {
                $group->users()->attach($iIDUser, ['rank_id' => '4']); // Par défaut adhérent
                return json_encode($authorized);
            }
        }
    }

    public function userDelete(Request $request, $id)
    {

        $group = Group::findOrFail($id);
        $iIDUser = $request->input('user');
        $aUser = User::findOrFail($iIDUser);

        if(!empty($aUser) ){

            $authorized = false;
            if(Auth::user()->id == $aUser->id ) { $authorized = true; }
            elseif(Auth::user()->hasAnyRole(array('admin', 'moderator'))) { $authorized = true; }
            else {
                // Si l'utilisateur est administrateur du group, il peut le modifier
                $user_rank = Auth::user()->groups->where('id', $id)->first()->pivot->rank_id;
                if(!empty($user_rank) && $user_rank == '1'){
                    $authorized = true;
                }
            }

            if(empty($authorized)){
                return json_encode($authorized);
            } else {
                $group->users()->detach($iIDUser);
                return json_encode($authorized);
            }
        }
    }

    public function userUpdate(Request $request, $id)
    {

        $group = Group::findOrFail($id);

        $iIDUser = $request->input('user');
        $iIDRank = $request->input('rank');

        $aUser = User::findOrFail($iIDUser);
        $aRank = Rank::findOrFail($iIDRank);

        if(!empty($aUser) && !empty($aRank)){

            $authorized = false;
            if(Auth::user()->hasAnyRole(array('admin', 'moderator'))) { $authorized = true; }
            else {
                // Si l'utilisateur est administrateur du group, il peut le modifier
                $user_rank = Auth::user()->groups->where('id', $id)->first()->pivot->rank_id;
                if(!empty($user_rank) && $user_rank == '1'){
                    $authorized = true;
                }
            }

            if(empty($authorized)){
                return json_encode($authorized);
            } else {
                $group->users()->updateExistingPivot($iIDUser,['rank_id' => $iIDRank]);
                return json_encode($authorized);
            }
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {

        $name = $request->input('name');
        $state = $request->input('state');
        $country = $request->input('country', '76');
        $department = $request->input('department');

        // Statut
        if(Auth::user() && Auth::user()->hasAnyRole(array('admin', 'moderator')) && !empty($state) ){
            if ($state == 'no_accepted') { $groups = Group::whereNull('accepted_at'); } 
            elseif ($state == 'deleted') { $groups = Group::whereNotNull('deleted_at'); } 
        } 
        else { $groups = Group::whereNotNull('accepted_at'); }

        // Pays
        if(!empty($country)){
            $groups = $groups->where('country_id',$country);
        }

        // Nom
        if(!empty($name)){
            $groups = $groups->where('name', 'like', '%'.$name.'%');
        }

        // Département
        if(!empty($department)){
            $groups = $groups->where('zip_code', 'like', ''.$department.'%');
        }

        $groups = $groups->get();

        $countries = Country::get();
        $departments = Department::get();
        $data = compact('groups', 'countries', 'departments', 'name', 'state', 'country', 'department');
        return view('group.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        $departments = Department::get();
        return view('group.create', ['countries' => $countries, 'departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroup $request)
    {
        Group::create($request->all());
        return redirect()->route('groups.create')->withInput()->with('success', 'Votre association a été créée.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('group.show', ['group' => Group::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Country::get();
        $group = Group::findOrFail($id);

        $authorized = false;
        if(Auth::user()->hasAnyRole(array('admin', 'moderator'))) { $authorized = true; }
        else {
            // Si l'utilisateur est administrateur du group, il peut le modifier
            $user_rank = Auth::user()->groups->where('id', $id)->first()->pivot->rank_id;
            if(!empty($user_rank) && $user_rank == '1'){
                $authorized = true;
            }
        }

        if(empty($authorized)){
            return redirect(route('groups'));
        } else {
            return view('group.edit', [ 'countries' => $countries, 'group' => $group]); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $authorized = false;
        if(Auth::user()->hasAnyRole(array('admin', 'moderator'))) { $authorized = true; }
        else {
            // Si l'utilisateur est administrateur du group, il peut le modifier
            $user_rank = Auth::user()->groups->where('id', $id)->first()->pivot->rank_id;
            if(!empty($user_rank) && $user_rank == '1'){
                $authorized = true;
            }
        }

        if(empty($authorized)){
            return redirect(route('groups'));
        } else {
            $group = Group::findOrFail($id);
            $group->update($request->all());
            return redirect(route('group.edit', $id))
                ->with('success', 'Le profil de l\'association a été mis à jour.');
        }
    }

    /**
     * Accepte the groups.
     *
     * @param  int  $id
     * @return Response
     */
    public function accepted($id = NULL, Request $request)
    {
        if(empty($id)){
            if(!empty($request->has('id'))){
                $id = $request->input('id');
            }
        }
        var_dump($id);
        if(!empty($id)){
            $group = Group::findOrFail($id);
            $group->accepted_at = date('d/m/Y');
            $group->accepted_by = Auth::user()->id;
            $return = $group->update();   
            var_dump('2');       
        } else {
            $return = false;
        }

        return json_encode($return);
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
            $group = Group::findOrFail($id);
            $return = $group->delete();            
        } else {
            $return = false;
        }

        return json_encode($return);
    }
}
