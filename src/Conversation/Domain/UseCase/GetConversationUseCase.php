<?php

namespace Conversation\Domain\UseCase;

use Conversation\Domain\Contract\ConversationRepository;

class GetConversationUseCase
{
    public function __construct(
        private readonly ConversationRepository $repository
    ){    }
    public function execute(int $id)
    {
        return $this->repository->getById($id);
    }

}
