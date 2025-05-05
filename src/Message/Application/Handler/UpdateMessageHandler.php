<?php

namespace Message\Application\Handler;

use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Domain\UseCase\GetConversationUseCase;
use Illuminate\Http\JsonResponse;
use Message\Domain\UseCase\UpdateMessageUseCase;

class UpdateMessageHandler
{
    public function __construct(
        private readonly UpdateMessageUseCase $updateMessage,
        private readonly GetConversationUseCase $getConversation,
        private readonly TransformerGetConversation $transformer,
    ){    }

    public function handle($conversationId, $messageId, $message): JsonResponse
    {
        $this->updateMessage->execute($conversationId, $messageId, $message);
        return $this->transformer->transform($this->getConversation->execute($conversationId));
    }

}
