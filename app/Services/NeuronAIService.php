<?php

namespace App\Services;

use App\TaskAnalyzerAgent;
use NeuronAI\Chat\Messages\UserMessage;

class NeuronAIService
{
    public function analyzeTask(string $taskDescription): array
    {
        try {
            $agent = TaskAnalyzerAgent::make();

            $response = $agent->chat(
                new UserMessage("Analyze this task and provide: 1) breakdown of sub-tasks, 2) estimated hours, 3) required skills, 4) potential challenges. Task: {$taskDescription}")
            );

            return [
                'success' => true,
                'content' => $response->getContent(),
                'raw_response' => $response,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'content' => null,
            ];
        }
    }

    public function chat(string $message, ?TaskAnalyzerAgent $agent = null): array
    {
        try {
            $agent = $agent ?? TaskAnalyzerAgent::make();

            $response = $agent->chat(
                new UserMessage($message)
            );

            return [
                'success' => true,
                'content' => $response->getContent(),
                'agent' => $agent,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'content' => null,
            ];
        }
    }

    public function isConfigured(): bool
    {
        return ! empty(config('services.gemini.api_key'))
            || ! empty(config('services.openai.api_key'))
            || ! empty(config('services.anthropic.api_key'));
    }

    public function getConfigurationMessage(): string
    {
        if ($this->isConfigured()) {
            $provider = 'Unknown';
            if (config('services.gemini.api_key')) {
                $provider = 'Google Gemini';
            } elseif (config('services.anthropic.api_key')) {
                $provider = 'Anthropic Claude';
            } elseif (config('services.openai.api_key')) {
                $provider = 'OpenAI';
            }

            return "Neuron AI is configured and ready to use with {$provider}.";
        }

        return 'Neuron AI is not configured. Please set GEMINI_API_KEY, OPENAI_API_KEY, or ANTHROPIC_API_KEY in your .env file.';
    }

    public function getActiveProvider(): ?string
    {
        if (config('services.gemini.api_key')) {
            return 'Gemini';
        }

        if (config('services.anthropic.api_key')) {
            return 'Anthropic';
        }

        if (config('services.openai.api_key')) {
            return 'OpenAI';
        }

        return null;
    }
}
