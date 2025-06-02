<?php

namespace Conversation\Infrastructure\Persistence\Mongo;

use Conversation\Domain\Contract\ConversationRepository;
use Conversation\Domain\Model\Conversation;
use Conversation\Domain\Model\ConversationDetails;
use Conversation\Domain\ValueObject\Messages;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class  MongoConversationRepository implements ConversationRepository
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

    public function getAll(): Collection
    {
        $result = DB::connection($this->connection)
            ->table(self::TABLE_CONVERSATION)
            ->raw(function ($collection) {
                return $collection->aggregate([[
                    '$match' => [
                        'participants.id' => Auth::id()
                    ]
                ]])->toArray();
            });

        return collect($result)->map(fn ($item) => $this->createConversationDetails($item));
    }
    private function createConversationDetails($item): ConversationDetails
    {
        return new ConversationDetails(
            $item['_id'],
            $item['group'],
            (array) ($item['details_group'] ?? []),
            $item['date_created'],
            (array)$item['participants']
        );
    }
}
