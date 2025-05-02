<?php

namespace Message\Domain\UseCase;

use Message\Domain\Contract\MesssageRepository;

class UpdateMessageUseCase
{
    public function __construct(
        private readonly MesssageRepository $repository
    ){    }
    public function execute($id, $messageId, $message): void
    {
        $this->repository->update($id, $messageId, $message);
    }

}
