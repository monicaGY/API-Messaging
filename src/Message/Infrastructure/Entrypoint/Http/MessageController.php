<?php

namespace Message\Infrastructure\Entrypoint\Http;

use App\Http\Controllers\Controller;
use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Domain\UseCase\GetConversationUseCase;
use Conversation\Infrastructure\Persistence\Mongo\MongoConversationRepository;
use Illuminate\Http\JsonResponse;
use Message\Application\Handler\AddMessageHandler;
use Message\Application\Handler\UpdateMessageHandler;
use Message\Domain\UseCase\AddMessageUseCase;
use Message\Domain\UseCase\UpdateMessageUseCase;
use Message\Infrastructure\Entrypoint\Http\Request\AddMessageRequest;
use Message\Infrastructure\Entrypoint\Http\Request\UpdateMessageRequest;
use Message\Infrastructure\Persistence\Mongo\MongoMesssageRepository;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddMessageRequest $request, $conversationId): JsonResponse
    {
        return (new AddMessageHandler(
            new AddMessageUseCase(
                new MongoMesssageRepository()
            ),
            new GetConversationUseCase(
                new MongoConversationRepository()
            ),
            new TransformerGetConversation()
        ))->handle($request, $conversationId);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, $conversationId): JsonResponse
    {
        return (new UpdateMessageHandler(
            new UpdateMessageUseCase(
                new MongoMesssageRepository()
            ),
            new GetConversationUseCase(
                new MongoConversationRepository()
            ),
            new TransformerGetConversation()
        ))->handle($conversationId, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
