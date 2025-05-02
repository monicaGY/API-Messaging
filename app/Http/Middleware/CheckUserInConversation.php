<?php

namespace App\Http\Middleware;

use Closure;
use Conversation\Domain\Service\CheckParticipantConversation;
use Conversation\Infrastructure\Persistence\Mongo\MongoCheckParticipantConversationRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserInConversation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $conversationId = $request->route('conversationId');

        $isParticipant = (new CheckParticipantConversation(
            new MongoCheckParticipantConversationRepository()
        ))->execute($conversationId);

        if(!$isParticipant){
            return response()->json(['error' => 'You are not part of this group'], 403);
        }

        return $next($request);
    }
}
