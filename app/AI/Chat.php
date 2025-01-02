<?php

namespace App\AI;

use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class Chat
{

    protected array $messages = [];


    /**
     * Sets the system message for the chat.
     *
     * @param  string  $message
     * @return static
     */
    public function systemMessage(string $message): static
    {
        // Add the system message to the chat log.
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $message
        ];

        return $this;
    }


    /**
     * Sends a message to the OpenAI chat and returns the response.
     *
     * @param  string  $message
     * @return string|null
     */
    public function send(string $message): ?string
    {
        // Add the user's message to the chat log.
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        // Make the request to the OpenAI API.
        $response = OpenAI::chat()->create([
            "model" => "gpt-4o",
            "store" => true,
            "messages" => $this->messages
        ])->choices[0]->message->content;

        // If the response is not null, add it to the chat log.
        if ($response) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response
            ];
        }

        // Return the response.
        return $response;
    }


    /**
     * A convenience method for sending a message to the chat.
     *
     * @param  string  $message
     * @return string|null
     */
    public function reply(string $message): ?string
    {
        return $this->send($message);
    }


    /**
     * Get the messages in the chat.
     *
     * @return array
     */
    public function messages()
    {

        return $this->messages;
    }
}
