<?php

namespace Message\Domain\UseCase;

use Message\Domain\Contract\VerifyMessageOwnerRepository;

class VerifyMessageOwnerUseCase
{
    public function __construct(
        private readonly VerifyMessageOwnerRepository $repository
    ){    }
    public function execute($conversationId, $messageId): bool
    {
        return $this->repository->execute($conversationId, $messageId);
    }

}
