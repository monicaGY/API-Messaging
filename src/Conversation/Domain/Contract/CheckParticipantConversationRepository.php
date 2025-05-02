<?php

namespace Conversation\Domain\Contract;

interface CheckParticipantConversationRepository
{
    public function execute($conversationId) : bool;

}
