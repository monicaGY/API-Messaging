<?php

namespace Message\Infrastructure\Persistence\Mongo;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Message\Domain\Contract\MesssageRepository;

class MongoMesssageRepository implements MesssageRepository
{
    private string $connection = 'mongodb';
    private const TABLE_CONVERSATIONS = 'conversations';

    public function update($conversationId, $messageId, $message): void
    {
        DB::connection($this->connection)->table(self::TABLE_CONVERSATIONS)->raw(function ($collection) use ($conversationId, $messageId, $message) {
            return $collection->updateOne(
                [
                    '_id' => (int) $conversationId,
                    'messages.id' => (int) $messageId,
                    'messages.sender.id' => Auth::id(),
                ],
                [
                    '$set' => [
                        'messages.$.message' => $message,
                    ]
                ]
            );
        });
    }

    public function add($conversationId, $message): void
    {
        $messageId = $this->getMessageId($conversationId);
        DB::connection($this->connection)
            ->table(self::TABLE_CONVERSATIONS)
            ->where('_id', (int) $conversationId)
            ->push('messages', [
                'id' => $messageId + 1,
                'message' => $message,
                'sender' => [ 'id' => Auth::id(), 'name' => Auth::user()['name']],
                'date' => (new Carbon())->format('Y-m-d H:i:s'),
            ]);
    }
    private function getMessageId(int $conversationId): int
    {
        $messages =  DB::connection($this->connection)
            ->table(self::TABLE_CONVERSATIONS)
            ->select('messages')
            ->where('_id', $conversationId)
            ->get();
        if(count($messages) === 0){
            return 1;
        }
        $lastMessage  = collect($messages[0]->messages)->sortByDesc('id')->first();
        return $lastMessage['id'];
    }
}
