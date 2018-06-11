<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Route;
use Illuminate\Support\Facades\Auth;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [
                'name' => 'required|max:255',
                'email' =>  'required|email|max:255',
            ];

        // Si c'est une modification
        if (!empty(Route::current()->parameters['id'])) {
            $user_id = Route::current()->parameters['id'];
            $rules['email'] = [ 'required', 'email', 'max:255', Rule::unique('users')->ignore($user_id) ] ;

            // Modification du mot de passe
            if(!empty($this->password)){
                $rules['password'] = ['required','string','min:6','confirmed'];                 
            }
        }
        // Si c'est un enregistrement
        else{
            $rules['email'] = [ 'required', 'email', 'max:255', 'unique:users' ] ;
            $rules['password'] = ['required','string','min:6','confirmed'];  
        }



        return $rules;
    }
}
