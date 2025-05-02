<?php

namespace Message\Domain\ValueObject;

class User
{
    public function __construct(
        private readonly int    $id,
        private readonly string $name,
    ){    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
