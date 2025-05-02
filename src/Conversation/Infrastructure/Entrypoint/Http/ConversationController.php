<?php

namespace Conversation\Infrastructure\Entrypoint\Http;

use App\Http\Controllers\Controller;
use Conversation\Application\Handler\GetConversationHandler;
use Conversation\Application\Transformer\TransformerGetConversation;
use Conversation\Domain\UseCase\GetConversationUseCase;
use Conversation\Infrastructure\Persistence\Mongo\MongoConversationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * @OA\PathItem(
     *     path="/api/v1/conversations"
     * )
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     *      )
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
