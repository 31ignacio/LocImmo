<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitDefineAccessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'code'=>'required|exists:reset_code_passwords,code',
            'password' => 'required|min:6|same:confirme_password',
            'confirme_password'=>'required|same:password',

        ];
    }

    public function messages(){

        return[
            'code.required'=>'Le code est requis.',
            'code.exists'=>'Ce code saisir n\'est pas valide, consultez votre boite mail.',
            'password.required'=>'Le mot de passe es requis.',
            'password.min'=> 'Le mot de passe doit être supérieur à cinq (05) caractères.',
            'confirme_password'=> 'Confirmer mot de passe.',
            'password.same'=>'Les mots de passe ne correspondent pas.',
            'confirme_password.same'=>'Les mots de passe ne correspondent pas.',

        ];

    }
}
