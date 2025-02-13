<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExerciseRequest extends FormRequest
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
            'name' => 'unique:exercises,name|required|string|max:30',
            'description' => 'string|max:1000',
            'duration' => 'nullable|integer|min:0|max:100',
            'repetitions' => 'nullable|integer|min:0|max:100',
            'weight' => 'nullable|integer|min:0|max:100',
            'category_id' => 'required|integer|min:0|max:100',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
