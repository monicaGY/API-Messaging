<?php

namespace Message\Infrastructure\Entrypoint\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer', //innecesario
            'message' => 'required|string|min:1|max:255',
        ];
    }
}
