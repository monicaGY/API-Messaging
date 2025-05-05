<?php

namespace Conversation\Domain\Model;

class ConversationDetails
{
    public function __construct(
        private readonly int $id,
        private readonly bool $isGroup,
        private readonly ?array $detailsGroup,
        private readonly string $dateCreated,
        private readonly array $participants,
    ){    }
    public function toArray(): array
    {
        $details = [
            'id' => $this->id,
            'is_group' => $this->isGroup,
            'participants' => $this->participants,
            'date_created' => $this->dateCreated,
        ];
        if($this->isGroup){
            $details['name_group'] = $this->detailsGroup['name'];
        }
        return $details;
    }

}
