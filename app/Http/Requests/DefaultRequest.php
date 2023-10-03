<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class DefaultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    abstract public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    abstract public function rules(): array;

    /**
     * Determine if request is an update of an existing record.
     */
    public function isUpdate(): bool
    {
        if ($this->getMethod() === 'PUT' || $this->getMethod() === 'PATCH') {
            //nothing to update
            if (empty($this->all())) {
                abort(400, __('validation.empty_request'));
            }

            return true;
        }

        return false;
    }
}
