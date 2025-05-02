<?php

namespace Conversation\Domain\ValueObject;


use Message\Domain\Model\Message;
use Message\Domain\ValueObject\User;

class Messages
{
    /**
     * @var Message[]
     */
    private array $messages;
    public function __construct(array $messages){
        $this->messages = array_map(function($message){
            $user = $message['sender'];
            return new Message(
                $message['id'],
                $message['message'],
                new User($user['id'], $user['name']),
                $message['date']
            );
        },$messages);
    }
    public function values(): array
    {
        return $this->messages;
    }
    public function toArray(): array
    {
        return array_map(function($message){
            return $message->toArray();
        },$this->messages);
    }
}
