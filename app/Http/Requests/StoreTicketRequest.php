<?php


namespace App\Http\Requests;

use App\Enums\TicketSeverity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'severity' => ['required', new Enum(TicketSeverity::class)],
            'department_id' => ['required', 'exists:departments,id'],
        ];
    }
}