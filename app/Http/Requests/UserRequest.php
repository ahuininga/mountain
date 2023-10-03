<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UserRequest extends DefaultRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if ($this->isUpdate()) {
            return [
                'name' => 'sometimes|string|max:255',
                'email' => [
                    'sometimes',
                    Rule::unique('users')->ignore($this->user()->id),
                    'max:255',
                ],
                'password' => 'sometimes|string|max:255',
            ];
        }

        return [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|max:255',
        ];
    }
}
