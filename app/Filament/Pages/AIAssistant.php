<?php

namespace App\Filament\Pages;

use App\Services\NeuronAIService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AIAssistant extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static string $view = 'filament.pages.a-i-assistant';

    protected static ?string $navigationGroup = 'Tools';

    protected static ?string $title = 'AI Task Analyzer';

    protected static ?int $navigationSort = 100;

    public ?string $taskDescription = '';

    public ?string $aiResponse = null;

    public bool $isLoading = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('taskDescription')
                    ->label('Task Description')
                    ->placeholder('Enter a task description for AI analysis...')
                    ->helperText('Example: "Implement user authentication with 2FA and password reset"')
                    ->rows(3)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function analyzeTask(): void
    {
        $data = $this->form->getState();

        if (empty($data['taskDescription'])) {
            Notification::make()
                ->title('Please enter a task description')
                ->warning()
                ->send();

            return;
        }

        $neuronAI = app(NeuronAIService::class);

        if (! $neuronAI->isConfigured()) {
            Notification::make()
                ->title('AI Not Configured')
                ->body('Please set OPENAI_API_KEY or ANTHROPIC_API_KEY in your .env file.')
                ->danger()
                ->send();

            return;
        }

        $this->isLoading = true;

        try {
            $result = $neuronAI->analyzeTask($data['taskDescription']);

            if ($result['success']) {
                $this->aiResponse = $result['content'];

                Notification::make()
                    ->title('Analysis Complete')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Error')
                    ->body($result['error'])
                    ->danger()
                    ->send();
            }
        } finally {
            $this->isLoading = false;
        }
    }

    public function clearResponse(): void
    {
        $this->aiResponse = null;
        $this->taskDescription = '';
        $this->form->fill();
    }
}
