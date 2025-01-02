<?php

namespace App\Console\Commands;

use App\AI\Chat;
use Illuminate\Console\Command;
use function Laravel\Prompts\{text, info, intro, outro, spin};


class ChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a chat with OpenAI';

    /**
     * Execute the console command.
     *
     * This method initiates a chat session with OpenAI, allowing the user
     * to ask questions and receive responses. It continues to prompt the
     * user for further questions until the user chooses to stop.
     */
    public function handle()
    {
        // Prompt the user to input their initial question for the AI.
        $question = text(
            label: 'What is your question for AI?',
            required: true
        );

        // Create a new instance of the Chat class.
        $chat = new Chat();

        // Send the initial question to the AI and display the response.
        $response = spin(fn() => $chat->send($question), 'Sending Request...');
        info($response);

        // Continuously prompt the user for additional questions.
        while ( ($question = text('Do you want to respond?')) !== 'no' && $question !== 'n' && $question !== 'No' && $question !== 'N' && $question !== 'nO' && $question !== 'NO' && $question !== "" ) {

            // Send the follow-up question to the AI and display the response.
            $response = spin(fn() => $chat->send($question), 'Sending Request...');
            info($response);
        }

        // Conclude the chat session.
        outro('Goodbye!');
    }
}
