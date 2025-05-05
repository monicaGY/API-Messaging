<?php

namespace Conversation\Application\Handler;

use Conversation\Application\Transformer\TransformerGetConversations;
use Conversation\Domain\UseCase\GetConversationsUseCase;
use Illuminate\Http\JsonResponse;

class GetConversationsHandler
{
    public function __construct(
        private readonly GetConversationsUseCase $getConversations,
        private readonly TransformerGetConversations $transformer,
    ){    }

    public function handle(): JsonResponse
    {
        return $this->transformer->transfom($this->getConversations->execute());
    }
}
