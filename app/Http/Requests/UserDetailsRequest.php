<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'quotes_id' => 'required|exists:quotes,id',
            'selected_language' => 'required|string|in:Assamese,Bengali,Bodo,Dogri,Gujarati,Hindi,Kannada,Kashmiri,Konkani,Maithili,Malayalam,Manipuri (Meitei),Marathi,Nepali,Odia (Oriya),Punjabi,Sanskrit,Santali,Tamil,Telugu,English',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name must not exceed 255 characters',
            'age.required' => 'Age is required',
            'age.min' => 'Age must be at least 1',
            'location.required' => 'Location is required',
            'location.max' => 'Location must not exceed 255 characters',
            'selected_language.required' => 'Language selection is required',
            'selected_language.in' => 'Selected language is not available',
        ];
    }
}
