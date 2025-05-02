<?php

namespace Conversation\Application\Handler;

use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Domain\UseCase\GetConversationUseCase;
use Illuminate\Http\JsonResponse;

class GetConversationHandler
{
    public function __construct(
        private readonly GetConversationUseCase $getConversation,
        private readonly TransformerGetConversation $transformer
    ){    }
    public function handle(int $id): JsonResponse
    {
        return $this->transformer->transform(
            $this->getConversation->execute($id)
        );
    }



}
