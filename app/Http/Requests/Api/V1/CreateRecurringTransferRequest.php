<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRecurringTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'target_email' => [
                'required',
                'email',
                Rule::exists(User::class, 'email')->whereNot('id', $this->user()->id),
            ],
            'amount' => [
                'required',
                'integer',
                'min:1',
            ],
            'frequency' => [
                'required',
                'integer',
                'min:1',
            ],
            'reason' => [
                'string',
                'max:255',
            ],
            'start_at' => [
                'required',
                'date',
                'before:end_at',
            ],
            'end_at' => [
                'required',
                'date',
            ],
            'execute_now' => [
                'boolean',
            ],
        ];
    }

    public function getTarget(): User
    {
        return User::where('email', '=', $this->input('target_email'))->firstOrFail();
    }
}
