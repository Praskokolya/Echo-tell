<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'name' => 'required|string|max:16|unique:users,name', 
            'email' => 'required|email|max:30|unique:users,email', 
            'password' => 'required|string|min:8', 
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name is required.',
            'name.max' => 'The name cannot be longer than 16 characters.',
            'email.required' => 'The email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'The email cannot be longer than 30 characters.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters long.',
        ];
    }
    
}

