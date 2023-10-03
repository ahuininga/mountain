<?php

declare(strict_types=1);

namespace App\Http\Requests;

class UrlRequest extends DefaultRequest
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
                'url' => 'sometimes|active_url|max:255',
                'main' => 'sometimes|boolean',
                'app_id' => 'prohibited',
            ];
        }

        return [
            'url' => 'required|active_url|max:255',
            'main' => 'sometimes|boolean',
            'app_id' => 'required|uuid',
        ];
    }
}
