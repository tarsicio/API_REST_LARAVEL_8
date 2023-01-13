<?php
/** 
 * Venezuela, Enero 2023
 * Realizado por 
 * @author Tarsicio Carrizales <telecom.com.ve@gmail.com>
 * @copyright 2023 Tarsicio Carrizales
 * @version 1.0.0
 * @since 2023-01-01
 * @license MIT
*/
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class RegisterUser extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'name'     => 'min:8|max:40|required|string',
            'username' => 'min:8|max:40|required|string|unique:users',
            'email'    => 'required|email|max:90|unique:users',
            'password' => 'required|min:8|max:15'
            //'terms'    => 'required'
        ];        
    }

    public function messages(){
        return [
            'name.required' => trans('validacion_froms.user.name_required'),
            'name.min' => trans('validacion_froms.user.name_min'),
            'name.max' => trans('validacion_froms.user.name_max'),
            'username.required' => trans('validacion_froms.user.username_required'),
            'username.min' => trans('validacion_froms.user.username_min'),
            'username.max' => trans('validacion_froms.user.username_max'),
            'username.unique' => trans('validacion_froms.user.username_unique'),
            'email.required' => trans('validacion_froms.user.email_required'),
            'email.max' => trans('validacion_froms.user.email_max'),
            'email.unique' => trans('validacion_froms.user.email_unique'),
            'password.required' => trans('validacion_froms.user.password_required'),
            'password.min' => trans('validacion_froms.user.password_min'),
            'password.max' => trans('validacion_froms.user.password_max')
            //'terms.required' => trans('validacion_froms.user.terms_required'),
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = (new ValidationException($validator))->errors();
        $error = [
                'code'    => 400,
                'status'  => 'error',
                'dato'    => $errors,
                'message' => 'Datos errador, por favor verifique'
            ];
        throw new HttpResponseException(
            response()->json($error,400)
        );        
    }
}
