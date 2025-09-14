<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'phone_number'    => 'required|string|unique:users,phone_number,' . auth()->id(),
            'email'           => 'required|email|unique:users,email,' . auth()->id(),
            // 'address'         => 'string',
            'gender'          => 'required|in:male,female,unspecified',
            'country'         => 'required|string|max:255',
            'city'            => 'required|string|max:255',
            'password'        => 'nullable|string|min:8|max:10|confirmed',
            'additional_info' => '',
            'image'           => 'string|max:255',
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
