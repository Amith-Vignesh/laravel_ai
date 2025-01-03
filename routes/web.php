<?php

use App\AI\Chat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

//Example Route to use OpenAI
Route::get('/', function () {

    $chat = new Chat();

    $haiku = $chat
        ->systemMessage('You are a AI for laravel concepts, Skilled in explaining complex programming ')
        ->send('write a haiku about ai');

    $haiku2 = $chat->reply('Good, give me much longer than a haiku');

    return view('welcome', ['response' => $haiku2]);
});

Route::get('/chat', function () {
    return view('chat');
});

Route::post('/openai', [ChatController::class, '__invoke']);
