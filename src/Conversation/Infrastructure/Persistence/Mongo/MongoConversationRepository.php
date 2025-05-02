<?php

namespace Conversation\Infrastructure\Persistence\Mongo;

use Conversation\Domain\Contract\ConversationRepository;
use Conversation\Domain\Model\Conversation;
use Conversation\Domain\ValueObject\Messages;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MongoConversationRepository implements ConversationRepository
{
    private string $connection = 'mongodb';
    private const TABLE_CONVERSATION = 'conversations';
    public function getById(int $id): Collection
    {
        return DB::connection($this->connection)
            ->table(self::TABLE_CONVERSATION)
            ->select('_id', 'messages')
            ->where('_id', $id)
            ->get()->map(fn ($item) => $this->createConversation($item));
    }
    private function createConversation($item): Conversation
    {
        return new Conversation(
            $item->id,
            new Messages($item->messages)
        );
    }

}
