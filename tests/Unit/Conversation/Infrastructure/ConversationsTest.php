<?php

use Conversation\Application\Handler\GetConversationHandler;
use Conversation\Application\Transform\TransformerGetConversationTest;
use Conversation\Domain\Contract\ConversationRepository;
use Conversation\Domain\UseCase\GetConversationUseCase;

it('get conversation by id', function () {
    $mongoRepository = Mockery::mock(ConversationRepository::class);
    $mongoRepository->shouldReceive('getById')
        ->andReturn(collect([
            (object)[
                'id' => 1,
                'group' => true,
                'details_group' => [
                    'name' => 'FIRST GROUP',
                    'admins' => [
                        ['id' => 1, 'name' => 'Pablo']
                    ]
                ],
                'participants' => [
                    ['id' => 1, 'name' => 'Pablo'],
                    ['id' => 2, 'name' => 'Ana']
                ],
                'messages' => [
                    ['id' => 1, 'message' => 'Hello friends!', 'sender' => ['id' => 1, 'name' => 'Pablo'], 'date' => '2025-04-24 18:32:00']
                ],
                'date_created' => '2025-04-24 18:00:00'
            ]]));

    $conversationId = 1;
    $conversation = (new GetConversationHandler(
        new GetConversationUseCase(
            $mongoRepository
        ),
        new TransformerGetConversationTest()
    ))->handle($conversationId);
    $conversation = json_decode($conversation->content(), true, 512, JSON_THROW_ON_ERROR);
    expect($conversation['conversation'][0]['id'])->toBe(1);
});

it('get conversation by id wrong', function () {
    $mongoRepository = Mockery::mock(ConversationRepository::class);
    $mongoRepository->shouldReceive('getById')->andReturn(collect());

    $conversationId = 25;
    $conversation = (new GetConversationHandler(
        new GetConversationUseCase(
            $mongoRepository
        ),
        new TransformerGetConversationTest()
    ))->handle($conversationId);
    $status = $conversation->status();

    expect($status)->toBe(404);

});
