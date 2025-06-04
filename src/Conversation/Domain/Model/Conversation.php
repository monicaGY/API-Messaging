<?php

namespace Conversation\Domain\Model;

use Conversation\Domain\ValueObject\Messages;
use Illuminate\Support\Facades\Auth;

class Conversation
{
    public function __construct(
        private readonly int $id,
        private readonly Messages $messages,
        private readonly bool $isGroup,
        private readonly ?array $detailsGroup,
        private readonly array $participants,
    ){    }

    public function messages(): array
    {
        return $this->messages->values();
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sender' => $this->sender(),
            'receiver' => $this->receiver(),
            'messages' => $this->messages->toArray()
        ];
    }
    public function receiver(): string
    {
        if($this->isGroup){
            return $this->detailsGroup['name'];
        }

        $receiver = array_values(array_filter($this->participants, fn ($participant) => $participant['id'] !== Auth::id()));
        return $receiver[0]['name'];
    }
    public function sender(): array
    {
        $sender = array_values(array_filter($this->participants, fn ($participant) => $participant['id'] === Auth::id()));
        return $sender[0];
    }
}
