<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'hr' || $this->user()?->role === 'hr_master';
    }

    public function rules(): array
    {
        return [
            'language' => ['required', Rule::in(['id', 'en'])],
        ];
    }
}
