<?php

namespace App\Http\Controllers;

use App\AI\Chat;
use Throwable;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return string
     *
     * This is the main function of this controller. It will take the message from the request,
     * send it to the OpenAI API and return the response.
     *
     * If the Free tier limit of the OpenAI API has been reached, it will return an error message.
     *
     * @throws Throwable
     */
    public function __invoke(Request $request): string
    {
        // Create a new instance of the Chat class
        $chat = new Chat();

        try {

            // Get the response from the AI
            return $chat->send($request->post('content'));
        } catch (Throwable $e) {

            // If the free tier limit has been reached, return an error message
            return "Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.";
        }
    }
}
