<?php

declare(strict_types=1);

namespace App\Http\Requests;

class AppRequest extends DefaultRequest
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
            ];
        }

        return [
            'name' => 'required|string|max:255',
        ];
    }
}
