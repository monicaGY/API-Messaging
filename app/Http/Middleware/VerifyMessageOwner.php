<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Message\Domain\UseCase\VerifyMessageOwnerUseCase;
use Message\Infrastructure\Persistence\Mongo\MongoVerifyMessageOwnerRepository;
use Symfony\Component\HttpFoundation\Response;

class VerifyMessageOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $conversationId = $request->route('id');
        $messageId = $request->route('messageId');

        $isMessageOwner = (new VerifyMessageOwnerUseCase(
            new MongoVerifyMessageOwnerRepository()
        ))->execute($conversationId, $messageId);

        if(!$isMessageOwner){
            return response()->json(['error' => 'Action not allowed: only the author of the message can edit it'], 403);
        }

        return $next($request);
    }
}
