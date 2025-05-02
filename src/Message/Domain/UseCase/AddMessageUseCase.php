<?php

namespace Message\Domain\UseCase;

use Message\Domain\Contract\MesssageRepository;

class AddMessageUseCase
{
    public function __construct(
        private readonly MesssageRepository $repository
    ){    }
    public function execute($conversationId, $message): void
    {
        $this->repository->add($conversationId, $message);
    }

}
