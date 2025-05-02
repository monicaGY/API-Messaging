<?php

namespace Message\Infrastructure\Entrypoint\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class AddMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string|min:1|max:255',
        ];
    }
}
