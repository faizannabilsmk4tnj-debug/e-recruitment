<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationPreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'hr' || $this->user()?->role === 'hr_master';
    }

    public function rules(): array
    {
        return [
            'notif_new_applicant' => ['sometimes', 'boolean'],
            'notif_interview_schedule' => ['sometimes', 'boolean'],
            'notif_vacancy_capacity' => ['sometimes', 'boolean'],
            'notif_vacancy_deadline' => ['sometimes', 'boolean'],
        ];
    }
}
