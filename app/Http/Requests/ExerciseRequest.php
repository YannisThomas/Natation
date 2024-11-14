<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'series' => 'nullable|integer|min:0|max:100',
            'weight' => 'nullable|integer|min:0|max:100',

        ];
    }
}
