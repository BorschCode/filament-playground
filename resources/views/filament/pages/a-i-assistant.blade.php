<x-filament-panels::page>
    <div class="space-y-6">
        @php
            $neuronAI = app(\App\Services\NeuronAIService::class);
            $isConfigured = $neuronAI->isConfigured();
        @endphp

        @if (!$isConfigured)
            <x-filament::section>
                <x-slot name="heading">
                    Configuration Required
                </x-slot>

                <div class="text-sm space-y-2">
                    <p>Neuron AI is not configured. Please add one of these to your .env file:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li><strong>GEMINI_API_KEY</strong> - Google Gemini (Recommended - Free tier available)</li>
                        <li><strong>OPENAI_API_KEY</strong> - OpenAI GPT models</li>
                        <li><strong>ANTHROPIC_API_KEY</strong> - Anthropic Claude models</li>
                    </ul>
                </div>
            </x-filament::section>
        @else
            <x-filament::section>
                <x-slot name="heading">
                    Status: Active
                </x-slot>
                <div class="text-sm">
                    <p class="text-success-600 dark:text-success-400">
                        ✓ {{ $neuronAI->getConfigurationMessage() }}
                    </p>
                </div>
            </x-filament::section>
        @endif

        <x-filament::section>
            <x-slot name="heading">
                AI Task Analyzer
            </x-slot>

            <form wire:submit="analyzeTask" class="space-y-4">
                {{ $this->form }}

                <div class="flex gap-3">
                    <x-filament::button type="submit" :disabled="!$isConfigured">
                        Analyze Task
                    </x-filament::button>

                    @if ($aiResponse)
                        <x-filament::button type="button" color="gray" wire:click="clearResponse">
                            Clear
                        </x-filament::button>
                    @endif
                </div>
            </form>
        </x-filament::section>

        @if ($aiResponse)
            <x-filament::section>
                <x-slot name="heading">
                    AI Analysis
                </x-slot>

                <div class="prose dark:prose-invert max-w-none">
                    <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg whitespace-pre-wrap text-sm">
                        {{ $aiResponse }}
                    </div>
                </div>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
