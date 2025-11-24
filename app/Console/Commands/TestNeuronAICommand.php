<?php

namespace App\Console\Commands;

use App\Services\NeuronAIService;
use Illuminate\Console\Command;

class TestNeuronAICommand extends Command
{
    protected $signature = 'neuron:test {prompt? : The prompt to send to the agent}';

    protected $description = 'Test Neuron AI TaskAnalyzerAgent';

    public function handle(NeuronAIService $neuronAI): int
    {
        if (! $neuronAI->isConfigured()) {
            $this->error('⚠️  No API key configured!');
            $this->line('');
            $this->line('Please set one of these in your .env file:');
            $this->line('  - GEMINI_API_KEY=your-gemini-key-here (Recommended - Free tier available)');
            $this->line('  - OPENAI_API_KEY=sk-your-key-here');
            $this->line('  - ANTHROPIC_API_KEY=your-key-here');
            $this->line('');
            $this->info('📖 See docs/NEURON_AI_GUIDE.md for more information');

            return self::FAILURE;
        }

        $provider = $neuronAI->getActiveProvider();
        $this->info("🤖 Using {$provider} AI provider...");

        $prompt = $this->argument('prompt') ?? $this->ask(
            'What task would you like the AI to analyze?',
            'Build a user authentication system with 2FA'
        );

        $this->info('🤖 Sending to Neuron AI agent...');
        $this->line('');

        $result = $neuronAI->analyzeTask($prompt);

        if ($result['success']) {
            $this->line('<fg=green>✓ Response from AI:</>');
            $this->line('');
            $this->line($result['content']);
            $this->line('');

            return self::SUCCESS;
        }

        $this->error('❌ Error: '.$result['error']);
        $this->line('');
        $this->line('Make sure your API key is valid and you have internet connectivity.');

        return self::FAILURE;
    }
}
