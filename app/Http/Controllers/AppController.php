<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppController extends Controller
{

    public function index()
    {
        return view('chat');
    }

    public function chat(Request $request)
    {
        $validated = $request->validate([
            'boss_name' => 'string|max:255',
            'company_name' => 'string|max:255',
            'boss_gender' => 'in:male,female,other',
            'message' => 'required|string'
        ]);

        $prompt = $this->buildPrompt($request->all());
        $response = $this->generateResponse($prompt);

        return response()->json($response);
    }

    public function buildPrompt(array $data): string
    {
        $prompt = "You are a helpful assistant that creates overly flattering social media posts about bosses. 
                  Create a funny but professional LinkedIn/Facebook post that 'oils' the boss in a humorous way.
                  Boss's name: {$data['boss_name']}
                  Company: {$data['company_name']}
                  Gender: {$data['boss_gender']}
                  Occasion: {$data['message']}
                  Make it appropriately exaggerated but still professional enough to be posted on social media.";

        return $prompt;
    }

    public function generateResponse(string $prompt): string
    {
        if (!env('OPENAI_API_KEY')) {
            throw new Exception('OpenAI API key not configured');
        }

        $response = Http::timeout(30)->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        if (!$response->successful()) {
            throw new Exception('OpenAI API error: ' . $response->body());
        }

        $data = $response->json();
        return $data['choices'][0]['message']['content'] ?? 'Sorry, no response from AI.';
    }

}