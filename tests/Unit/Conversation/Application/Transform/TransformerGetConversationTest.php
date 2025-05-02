<?php

namespace Conversation\Application\Transform;

use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Domain\Model\Conversation;
use Conversation\Domain\ValueObject\Messages;
use Illuminate\Http\JsonResponse;
use JsonException;

class TransformerGetConversationTest extends TransformerGetConversation
{
    public function transform($conversations): JsonResponse
    {
        try {
            if(count($conversations) === 0){
                return JsonResponse::fromJsonString(
                    json_encode(
                        [
                            'message' => 'Conversation not found'
                        ], JSON_THROW_ON_ERROR),
                    404
                );

            }
            return JsonResponse::fromJsonString(
                json_encode(
                    [
                        'conversation' => $this->formatConversation($conversations)
                    ], JSON_THROW_ON_ERROR)
            );
        } catch (JsonException) {
            return JsonResponse::fromJsonString("[]");
        }
    }
    private function formatConversation($conversations)
    {
        return $conversations->map(function ($item) {
            return (new Conversation($item->id, new Messages($item->messages)))->toArray();
        });
    }

}
