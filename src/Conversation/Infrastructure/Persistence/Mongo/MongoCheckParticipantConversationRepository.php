<?php

namespace Conversation\Infrastructure\Persistence\Mongo;

use Conversation\Domain\Contract\CheckParticipantConversationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MongoCheckParticipantConversationRepository implements CheckParticipantConversationRepository
{
    private string $connection = 'mongodb';
    private const TABLE_CONVERSATIONS = 'conversations';

    public function execute($conversationId): bool
    {
        $result = DB::connection($this->connection)->table(self::TABLE_CONVERSATIONS)->raw(function ($collection) use ($conversationId){
            return $collection->aggregate([
                [
                    '$match' => [
                        '_id' => (int) $conversationId,
                        'participants.id' => Auth::id()
                    ]
                ]
            ]);
        })->toArray();

        return count($result) > 0;

    }
}
