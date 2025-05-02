<?php

namespace v1;

use Conversation\Infrastructure\Entrypoint\Http\ConversationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('/v1/conversations')
    ->group( function () {
        Route::get('/{id}', [ConversationController::class, 'show']);

        Route::post('/{id}/messages', [ConversationController::class, 'login']);
});
