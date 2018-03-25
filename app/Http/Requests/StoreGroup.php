<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroup extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'name' => 'required|max:255',
                'rna' => 'required|max:255',
                'founding_date' => 'required|date_format:d/m/Y|before:today',
                'email' =>  'nullable|email',
                'phone' =>  'max:255',
                'address' => 'max:500',
                'zip_code' => 'required|digits:5',
                'city' => 'required|alpha|max:255',
                'country_id' => 'required',
                'about' => 'max:500',
            ];
    }
}
