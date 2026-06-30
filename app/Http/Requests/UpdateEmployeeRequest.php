<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => 'required|string|max:255',
            "last_name" => 'required|string|max:255',
            "email" => "required|string|email|max:255|unique:users,email",
            "phone_number"=> "required|string|unique:employees,phone_number",
            "department_id" => "required|integer|exists:departments,id",
            "hire_date" => "required|date_format:Y-m-d|before:today",
            "salary" => "nullable|numeric|min:0",
            "job_title" => "nullable|string|max:255",
            "status" => "required|in:active,inactive"
        ];
    }

    public function message(){
        return [
            'email.required' => 'Email is required.',
            'phone_number.required' => 'Phone number is required.'
        ];
    }
}
