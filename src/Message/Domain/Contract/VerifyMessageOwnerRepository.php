<?php

namespace Message\Domain\Contract;

interface VerifyMessageOwnerRepository
{
    public function execute($conversationId, $messageId): bool;
}
