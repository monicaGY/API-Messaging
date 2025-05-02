<?php

namespace Conversation\Domain\Service;

use Conversation\Domain\Contract\CheckParticipantConversationRepository;

class CheckParticipantConversation
{
    public function __construct(
        private readonly CheckParticipantConversationRepository $checkIsParticipant
    ){    }

    public function execute($conversationId): bool
    {
        return $this->checkIsParticipant->execute($conversationId);
    }
}
