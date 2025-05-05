<?php

namespace v1;

use Conversation\Infrastructure\Entrypoint\Http\ConversationController;
use Illuminate\Support\Facades\Route;
use Message\Infrastructure\Entrypoint\Http\MessageController;

Route::middleware('auth:sanctum')
    ->prefix('/v1/conversations')
    ->group( function () {

        Route::prefix('{id}')
            ->middleware('conversation.check.user')
            ->group( function () {
                Route::get('/', [ConversationController::class, 'show']);

                Route::prefix('messages')
                ->group( function () {
                    Route::post('/', [MessageController::class, 'store']);
                    Route::middleware('verify.message.owner')
                        ->put('/{messageId}', [MessageController::class, 'update']);
                });
        });
});
