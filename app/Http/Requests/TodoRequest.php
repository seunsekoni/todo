<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;




class TodoRequest extends FormRequest
{
    /**
     * Return validation error response.
     *
     * @return \Illuminate\Http\Response
     */
    public static function validationErrorResponse($data, $errorCode = 422)
    {
        return response()->json([
            'success'   => false,
            'data'      => $data,
            'message'   => 'Failed validation.'
        ], $errorCode);
    }

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
            'todo' => 'required|min:3',
            'completed' => 'integer|in:0,1'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {

        return [
            'todo.required' => 'Todo field cannot be empty',
            'todo.min' => 'The Todo field cannot be less than 3 characters',
            'completed.integer' => 'Completed field must be an integer value betwen 0 and 1',
            'completed.in' => 'Completed field must be an integer value betwen 0 and 1'
        ];
    }

    protected function failedValidation(Validator $validator)
    {   
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
    
}
