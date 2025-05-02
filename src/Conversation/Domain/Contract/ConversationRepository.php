<?php

namespace Conversation\Domain\Contract;

interface ConversationRepository
{
    public function getById(int $id);
}
