<?php

namespace Message\Domain\Contract;

interface MesssageRepository
{
    public function update($conversationId, $messageId, $message);
    public function add($conversationId, $message);

}
