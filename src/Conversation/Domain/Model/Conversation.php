<?php

namespace Conversation\Domain\Model;

use Conversation\Domain\ValueObject\Messages;

class Conversation
{
    public function __construct(
        private readonly int $id,
        private readonly Messages $messages,
    ){    }

    public function messages(): array
    {
        return $this->messages->values();
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'messages' => $this->messages->toArray()
        ];
    }
}
