<?php

namespace Conversation\Domain\UseCase;

use Conversation\Domain\Contract\ConversationRepository;

class GetConversationsUseCase
{
    public function __construct(
        private readonly ConversationRepository $repository
    ){    }

    public function execute()
    {
        return $this->repository->getAll();
    }
}
