<?php

declare(strict_types=1);

namespace App;

use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\Anthropic\Anthropic;
use NeuronAI\Providers\Gemini\Gemini;
use NeuronAI\Providers\OpenAI\OpenAI;
use NeuronAI\SystemPrompt;

class TaskAnalyzerAgent extends Agent
{
    protected function provider(): AIProviderInterface
    {
        // Auto-detect which provider is configured
        if (config('services.gemini.api_key')) {
            return new Gemini(
                key: config('services.gemini.api_key'),
                model: 'gemini-2.0-flash-exp',
            );
        }

        if (config('services.anthropic.api_key')) {
            return new Anthropic(
                key: config('services.anthropic.api_key'),
                model: 'claude-3-5-sonnet-20241022',
            );
        }

        if (config('services.openai.api_key')) {
            return new OpenAI(
                key: config('services.openai.api_key'),
                model: 'gpt-4o-mini',
            );
        }

        throw new \Exception('No AI provider configured. Please set GEMINI_API_KEY, ANTHROPIC_API_KEY, or OPENAI_API_KEY in your .env file.');
    }

    public function instructions(): string
    {
        return (string) new SystemPrompt(
            background: [
                'You are a project management AI assistant specializing in task analysis.',
                'You help teams analyze tasks, estimate time, and provide actionable insights.',
            ],
            role: 'Task Analyzer',
            examples: [
                [
                    'input' => 'Analyze this task: Implement user authentication',
                    'output' => 'This task involves: 1) Setting up auth middleware, 2) Creating login/register forms, 3) Password hashing, 4) Session management. Estimated time: 8-12 hours for a senior developer.',
                ],
            ],
        );
    }
}
