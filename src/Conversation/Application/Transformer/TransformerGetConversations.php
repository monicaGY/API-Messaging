<?php

namespace Conversation\Application\Transformer;

use Illuminate\Http\JsonResponse;

class TransformerGetConversations
{
    public function transfom($conversations): JsonResponse
    {
        return response()->json(
            ['conversations' => $this->formatConversation($conversations)]
        );
    }
    private function formatConversation($conversations)
    {
        return $conversations->map(function ($item) {
            return $item->toArray();
        });
    }

}
