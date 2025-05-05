<?php

namespace Conversation\Domain\Contract;

interface ConversationRepository
{
    public function getAll();
    public function getById(int $id);
}
