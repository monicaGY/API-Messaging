<?php

namespace Conversation\Infrastructure\Entrypoint\Http;

use App\Http\Controllers\Controller;
use Conversation\Application\Handler\GetConversationHandler;
use Conversation\Application\Handler\GetConversationsHandler;
use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Application\Transformer\TransformerGetConversations;
use Conversation\Domain\UseCase\GetConversationsUseCase;
use Conversation\Domain\UseCase\GetConversationUseCase;
use Conversation\Infrastructure\Persistence\Mongo\MongoConversationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ConversationController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/v1/conversations",
     *     tags={"Conversation"},
     *     summary="Get all conversations",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="List conversations successfully obtained",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="conversations",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="integer", example=2),
     *                      @OA\Property(property="is_group", type="boolean", example=false),
     *                      @OA\Property(
     *                          property="participants",
     *                          type="array",
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="name", type="string", example="Sebastian García")
     *                          ),
     *
     *                      ),
     *                      @OA\Property(
     *                          property="date_created",
     *                          type="string",
     *                          format="date-time",
     *                          example="2025-04-24 18:00:00"
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     * )
     */
    public function index(): JsonResponse
    {
        return (new GetConversationsHandler(
            new GetConversationsUseCase(
                new MongoConversationRepository()
            ),
            new TransformerGetConversations()
        ))->handle();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get (
     *     path="/api/v1/conversations/{id}",
     *     tags={"Conversation"},
     *     summary="Get conversation by ID",
     *          security={{"bearerAuth":{}}},
     *          @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID conversation",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Conversation successfully obtained",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="conversation",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=2),
     *                      @OA\Property(
     *                          property="messages",
     *                          type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="message", type="string", example="Hello Juan!"),
     *                              @OA\Property(
     *                                  property="user",
     *                                  type="object",
     *                                  @OA\Property(property="id", type="integer", example=1),
     *                                  @OA\Property(property="name", type="string", example="Pablo")
     *                              ),
     *                              @OA\Property(property="date", type="string", format="date-time", example="2025-04-24 18:32:00")
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Conversación no encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Conversation not found")
     *          )
     *      ),
     *     @OA\Response(
     *           response=403,
     *           description="You are not part of this group"
     *       )
     * )
     */
    public function show(int $id): JsonResponse
    {
        return (new GetConversationHandler(
            new GetConversationUseCase(
                new MongoConversationRepository()
            ),
            new TransformerGetConversation()
        ))->handle($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
