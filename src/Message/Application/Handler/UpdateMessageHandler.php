<?php

namespace Message\Application\Handler;

use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Domain\UseCase\GetConversationUseCase;
use Illuminate\Http\JsonResponse;
use Message\Domain\UseCase\UpdateMessageUseCase;
use Message\Infrastructure\Entrypoint\Http\Request\UpdateMessageRequest;

class UpdateMessageHandler
{
    public function __construct(
        private readonly UpdateMessageUseCase $updateMessage,
        private readonly GetConversationUseCase $getConversation,
        private readonly TransformerGetConversation $transformer,
    ){    }

    public function handle($conversationId, UpdateMessageRequest $message): JsonResponse
    {
        $this->updateMessage->execute($conversationId, $message['id'], $message['message']);
        return $this->transformer->transform($this->getConversation->execute($conversationId));
    }

}
