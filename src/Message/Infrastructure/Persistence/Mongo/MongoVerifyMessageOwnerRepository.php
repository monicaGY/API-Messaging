<?php

namespace Message\Infrastructure\Persistence\Mongo;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Message\Domain\Contract\VerifyMessageOwnerRepository;

class MongoVerifyMessageOwnerRepository implements VerifyMessageOwnerRepository
{
    private string $connection = 'mongodb';
    private const TABLE_CONVERSATIONS = 'conversations';

    public function execute($conversationId, $messageId): bool
    {
        $result = DB::connection($this->connection)->table(self::TABLE_CONVERSATIONS)->raw(function ($collection) use ($conversationId, $messageId){
            return $collection->aggregate([
                [
                    '$match' => [
                        '_id' => (int) $conversationId,
                        'messages' => [
                            '$elemMatch' => [
                                'id' => (int) $messageId,
                                'sender.id' => Auth::id(),
                            ],
                        ],
                    ]
                ]
            ]);
        })->toArray();

        return count($result) > 0;
    }
}
