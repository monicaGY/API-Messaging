<?php

namespace Conversation\Application\Transformer;

use Conversation\Domain\Model\Conversation;
use Conversation\Domain\ValueObject\Messages;
use Illuminate\Http\JsonResponse;

class TransformerGetConversation
{
    public function transform($conversations): JsonResponse
    {
        if(count($conversations) === 0) {
            return response()->json([
                'message' => 'Conversation not found'
            ], 404 );

        }
        return response()->json([
            'conversation' => $this->formatConversation($conversations)
        ]);
    }
    private function formatConversation($conversations)
    {
        return $conversations->map(function ( $item) {
            return (new Conversation(
                $item->id,
                new Messages($item->messages)
            ));
        });
    }
}
