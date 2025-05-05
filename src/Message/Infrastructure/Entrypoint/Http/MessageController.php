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
use Message\Infrastructure\Entrypoint\Http\Request\MessageRequest;
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
     * @OA\Post(
     *     path="/api/v1/conversations/{id}/messages",
     *     tags={"Message"},
     *     summary="Add message by conversation ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID conversation",
     *           @OA\Schema(type="integer", example=1)
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"message"},
     *                  @OA\Property(property="message", type="string", example="Hello how are you?"),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *            response=200,
     *            description="Message edit",
     *            @OA\JsonContent(
     *                @OA\Property(
     *                    property="conversation",
     *                    type="array",
     *                    @OA\Items(
     *                        type="object",
     *                        @OA\Property(property="id", type="integer", example=1),
     *                        @OA\Property(
     *                            property="messages",
     *                            type="array",
     *                            @OA\Items(
     *                                type="object",
     *                                @OA\Property(property="id", type="integer", example=1),
     *                                @OA\Property(property="message", type="string", example="Hello how are you"),
     *                                @OA\Property(
     *                                    property="user",
     *                                    type="object",
     *                                    @OA\Property(property="id", type="integer", example=3),
     *                                    @OA\Property(property="name", type="string", example="Pablo")
     *                                ),
     *                                @OA\Property(property="date", type="string", format="date-time", example="2025-04-24 18:32:00")
     *                            )
     *                        )
     *                    )
     *                )
     *            )
     *        ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     * @OA\Response(
     *          response=403,
     *          description="You are not part of this group"
     *      )
     * )
     */
    public function store(MessageRequest $request, $conversationId): JsonResponse
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
     * @OA\Put(
     *     path="/api/v1/conversations/{id}/messages/{messageId}",
     *     tags={"Message"},
     *     summary="Edit a message in a conversation",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID conversation",
     *           @OA\Schema(type="integer", example=1)
     *       ),
     *     @OA\Parameter(
     *           name="messageId",
     *           in="path",
     *           required=true,
     *           description="ID message",
     *           @OA\Schema(type="integer", example=1)
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"message"},
     *                  @OA\Property(property="message", type="string", example="Hi where are you?"),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="Message edit",
     *           @OA\JsonContent(
     *               @OA\Property(
     *                   property="conversation",
     *                   type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(property="id", type="integer", example=1),
     *                       @OA\Property(
     *                           property="messages",
     *                           type="array",
     *                           @OA\Items(
     *                               type="object",
     *                               @OA\Property(property="id", type="integer", example=1),
     *                               @OA\Property(property="message", type="string", example="Hi where are you"),
     *                               @OA\Property(
     *                                   property="user",
     *                                   type="object",
     *                                   @OA\Property(property="id", type="integer", example=3),
     *                                   @OA\Property(property="name", type="string", example="Pablo")
     *                               ),
     *                               @OA\Property(property="date", type="string", format="date-time", example="2025-04-24 18:32:00")
     *                           )
     *                       )
     *                   )
     *               )
     *           )
     *       ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *           response=403,
     *           description="You are not part of this group"
     *       ),
     *     @OA\Response(
     *            response=403,
     *            description="Action not allowed: only the author of the message can edit it"
     *        )
     * )
     */
    public function update(MessageRequest $request, $conversationId, $messageId): JsonResponse
    {
        return (new UpdateMessageHandler(
            new UpdateMessageUseCase(
                new MongoMesssageRepository()
            ),
            new GetConversationUseCase(
                new MongoConversationRepository()
            ),
            new TransformerGetConversation()
        ))->handle($conversationId, $messageId, $request['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
