<?php

namespace Message\Domain\Model;

use Message\Domain\ValueObject\User;

class Message
{
    public function __construct(
        private readonly int $id,
        private readonly string $message,
        private readonly User $user,
        private readonly string $date,
    ){    }
    public function toArray(): array {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'user' => $this->user->toArray(),
            'date' => $this->date,
        ];
    }
}
