<?php

namespace v1;

use Conversation\Infrastructure\Entrypoint\Http\ConversationController;
use Illuminate\Support\Facades\Route;
use Message\Infrastructure\Entrypoint\Http\MessageController;

Route::middleware('auth:sanctum')
    ->prefix('/v1/conversations')
    ->group( function () {
        Route::get('/{id}', [ConversationController::class, 'show']);


        Route::prefix('{conversationId}/messages')
            ->middleware('conversation.check.user')
            ->group( function () {
                Route::post('/', [MessageController::class, 'store']);
                Route::put('/{messageId}', [MessageController::class, 'update']);
            });


});
