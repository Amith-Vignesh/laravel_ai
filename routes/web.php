<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $response = Http::withToken(config('services.openai.secret'))
        ->post(
            'https://api.openai.com/v1/chat/completions',
            [
                "model" => "gpt-4o-mini",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "You are a helpful assistant."
                    ],
                    [
                        "role" => "user",
                        "content" => "Write a haiku that explains the concept of recursion."
                    ]
                ]
            ]
        )->json();

    // Dump the response for debugging
    dd($response);
});
