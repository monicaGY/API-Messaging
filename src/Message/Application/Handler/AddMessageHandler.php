<?php

namespace Message\Application\Handler;

use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Domain\UseCase\GetConversationUseCase;
use Illuminate\Http\JsonResponse;
use Message\Domain\UseCase\AddMessageUseCase;

class AddMessageHandler
{
    public function __construct(
        private readonly AddMessageUseCase $addMessage,
        private readonly GetConversationUseCase $getConversation,
        private readonly TransformerGetConversation $transformer,
    ){    }

    public function handle($request, $conversationId): JsonResponse
    {
        $this->addMessage->execute($conversationId, $request['message']);
        return $this->transformer->transform($this->getConversation->execute($conversationId));
    }


}
