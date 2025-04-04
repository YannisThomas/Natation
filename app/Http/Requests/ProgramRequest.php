<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'required|exists:users,id',
            'exercise_id' => 'required|array|min:1',
            'exercise_id.*' => 'exists:exercises,id',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Le nom du programme est obligatoire.',
            'start_date.required' => 'La date de début est obligatoire.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.after' => 'La date de fin doit être postérieure à la date de début.',
            'user_id.required' => 'Vous devez sélectionner un athlète.',
            'user_id.exists' => 'L\'athlète sélectionné n\'existe pas.',
            'exercise_id.required' => 'Vous devez sélectionner au moins un exercice.',
            'exercise_id.min' => 'Vous devez sélectionner au moins un exercice.',
            'exercise_id.*.exists' => 'Un des exercices sélectionnés n\'existe pas.',
        ];
    }
}
