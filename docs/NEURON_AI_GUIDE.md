# Neuron AI Integration Guide

This guide will help you get started with Neuron AI in your Laravel application.

## 📦 What is Neuron AI?

Neuron AI is a PHP framework for creating and orchestrating AI Agents. It allows you to integrate AI capabilities into your Laravel application with support for:

- Multiple LLM providers (OpenAI, Anthropic, Gemini, Ollama, etc.)
- Agent-based architecture with memory
- Tool calling and function execution
- RAG (Retrieval Augmented Generation)
- Structured output
- MCP (Model Context Protocol) connector
- Multi-agent workflows

## 🚀 Quick Start

### Step 1: Set Up API Keys

Add your AI provider API keys to your `.env` file:

```env
# For OpenAI
OPENAI_API_KEY=sk-your-api-key-here

# For Anthropic Claude
ANTHROPIC_API_KEY=your-anthropic-key-here

# Optional: For monitoring with Inspector
INSPECTOR_INGESTION_KEY=your-inspector-key
```

### Step 2: Create Your First Agent

We've already created a sample `TaskAnalyzerAgent` for you. Here's how to use it:

```php
use App\TaskAnalyzerAgent;
use NeuronAI\Chat\Messages\UserMessage;

$agent = TaskAnalyzerAgent::make();

$response = $agent->chat(
    new UserMessage("Analyze this task: Build a REST API for user management")
);

echo $response->getContent();
```

### Step 3: Create a New Agent

You can create additional agents using the Neuron command:

```bash
vendor/bin/sail php vendor/bin/neuron make:agent YourAgentName
```

## 💡 Example Use Cases

### 1. Task Analysis Agent (Already Created)

```php
use App\TaskAnalyzerAgent;
use NeuronAI\Chat\Messages\UserMessage;

$agent = TaskAnalyzerAgent::make();

$response = $agent->chat(
    new UserMessage("Break down this feature: User authentication with 2FA")
);

echo $response->getContent();
// Output: Detailed breakdown with sub-tasks and time estimates
```

### 2. Customer Support Agent

Create a new agent:
```bash
vendor/bin/sail php vendor/bin/neuron make:agent CustomerSupportAgent
```

Update `app/CustomerSupportAgent.php`:
```php
<?php

namespace App;

use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\OpenAI\OpenAI;
use NeuronAI\SystemPrompt;

class CustomerSupportAgent extends Agent
{
    protected function provider(): AIProviderInterface
    {
        return new OpenAI(
            key: config('services.openai.api_key'),
            model: 'gpt-4o-mini',
        );
    }

    public function instructions(): string
    {
        return (string) new SystemPrompt(
            background: [
                'You are a helpful customer support agent for a SaaS CRM application.',
                'You assist users with questions about clients, projects, tasks, and billing.',
            ],
            role: 'Customer Support Specialist',
        );
    }
}
```

### 3. Data Analysis Agent with Database Tools

```php
<?php

namespace App;

use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\Anthropic\Anthropic;
use NeuronAI\SystemPrompt;
use NeuronAI\Tools\Toolkits\MySQL\MySQLToolkit;

class DataAnalystAgent extends Agent
{
    protected function provider(): AIProviderInterface
    {
        return new Anthropic(
            key: config('services.anthropic.api_key'),
            model: 'claude-3-5-sonnet-20241022',
        );
    }

    protected function instructions(): string
    {
        return (string) new SystemPrompt(
            background: [
                'You are a data analyst expert.',
                'You can query the database to answer questions about business metrics.',
            ]
        );
    }

    protected function tools(): array
    {
        return [
            MySQLToolkit::make(
                \DB::connection('mongodb')->getPdo()
            ),
        ];
    }
}
```

Usage:
```php
$response = DataAnalystAgent::make()->chat(
    new UserMessage("How many clients do we have?")
);

echo $response->getContent();
// The agent will query the database and provide the answer
```

### 4. Structured Output Example

Extract structured data from natural language:

```php
use App\TaskAnalyzerAgent;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\StructuredOutput\SchemaProperty;

class TaskBreakdown
{
    #[SchemaProperty(description: 'The task title')]
    public string $title;

    #[SchemaProperty(description: 'Estimated hours')]
    public int $estimatedHours;

    #[SchemaProperty(description: 'Priority level')]
    public string $priority;

    #[SchemaProperty(description: 'Required skills', type: 'array')]
    public array $skills;
}

$task = TaskAnalyzerAgent::make()->structured(
    new UserMessage("Implement OAuth2 authentication with Google"),
    TaskBreakdown::class
);

echo "Title: {$task->title}\n";
echo "Hours: {$task->estimatedHours}\n";
echo "Priority: {$task->priority}\n";
echo "Skills: " . implode(', ', $task->skills);
```

## 🔧 Advanced Features

### Memory Management

Agents automatically maintain conversation history:

```php
$agent = TaskAnalyzerAgent::make();

// First message
$agent->chat(new UserMessage("My name is John"));

// Second message - agent remembers the context
$response = $agent->chat(new UserMessage("What's my name?"));
echo $response->getContent();
// Output: "Your name is John"
```

### RAG (Retrieval Augmented Generation)

Create a RAG system for document-based Q&A:

```bash
vendor/bin/sail php vendor/bin/neuron make:rag DocumentChatBot
```

### Monitoring with Inspector

Enable monitoring by setting the `INSPECTOR_INGESTION_KEY` in your `.env` file. This will allow you to:

- Track agent execution timeline
- Debug LLM decisions
- Monitor token usage
- Analyze performance

## 📚 Available Providers

Neuron AI supports multiple LLM providers:

- **OpenAI**: GPT-4, GPT-4o, GPT-3.5-turbo
- **Anthropic**: Claude 3.5 Sonnet, Claude 3 Opus, Claude 3 Haiku
- **Google**: Gemini Pro, Gemini Pro Vision
- **Ollama**: Run models locally (Llama 2, Mistral, etc.)
- **Azure OpenAI**: Enterprise OpenAI deployments
- **Mistral AI**: Mistral models
- **Deepseek**: Deepseek models
- **Grok (X.AI)**: Grok models

## 🎯 Best Practices

1. **Use Environment Variables**: Always store API keys in `.env`, never in code
2. **Choose the Right Model**:
   - Use smaller models (gpt-4o-mini, claude-3-haiku) for simple tasks
   - Use larger models (gpt-4o, claude-3.5-sonnet) for complex reasoning
3. **Implement Error Handling**: Wrap agent calls in try-catch blocks
4. **Monitor Costs**: Enable Inspector to track token usage
5. **Test Prompts**: Iterate on your system prompts to get better results

## 📖 Resources

- [Official Neuron AI Documentation](https://docs.neuron-ai.dev/)
- [Laravel Tutorial (YouTube)](https://www.youtube.com/watch?v=oSA1bP_j41w)
- [Example Project](https://github.com/neuron-core/laravel-travel-agent)
- [Fast Learning by Video](https://docs.neuron-ai.dev/overview/fast-learning-by-video)

## 🤝 Contributing

If you create useful agents or patterns, consider sharing them with the team!

## 🐛 Troubleshooting

**Issue**: "API key not found" error
- **Solution**: Make sure you've set `OPENAI_API_KEY` or `ANTHROPIC_API_KEY` in your `.env` file

**Issue**: Agent responses are slow
- **Solution**: Consider using a smaller, faster model or implement caching

**Issue**: Agent doesn't remember context
- **Solution**: Make sure you're reusing the same agent instance for a conversation

---

**Happy AI Building! 🤖**
