<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use ReflectionClass;
use ReflectionMethod;
use App\Services\OpenAi;

class AnalyzeCode extends Command
{
    protected $signature = 'analyze:code {file : The path to the file}';

    protected $description = 'Analyze code and provide recommendations for enhancements';

    public function __construct(private readonly OpenAi $openAi)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $file = $this->argument('file');

        if (!file_exists($file) || !is_readable($file)) {
            $this->error("File '{$file}' does not exist or is not readable.");
            return;
        }

        $this->info("Analyzing file '{$file}'...");

        $class = $this->getClassFromFile($file);

        if (!$class) {
            $this->error("No class found in the file.");
            return;
        }

        $methods = $this->getMethodsFromClass($class);

        if (empty($methods)) {
            $this->info("No methods found in the class.");
        } else {
            $this->info("Methods found in the class:");

            foreach ($methods as $method) {
                $this->line("- {$method}");
            }

            $prompt = $this->createAiPrompt($methods);

            try {
                $context = 'we are working on a laravel project, using livewire and such technoglies, the project is covering erp and crm business domain, so this md docs will hep imrpove education';

                $recommendations = $this->openAi->execute($context, $prompt, 2000);
                $this->info("\nRecommendations for enhancements:");
                $this->line($recommendations);
            } catch (RequestException $e) {
                $this->error('Error fetching AI-generated content: ' . $e->getMessage());
            }
        }
    }

    private function getClassFromFile(string $file): ?ReflectionClass
    {
        $content = file_get_contents($file);

        $namespace = $this->getNamespace($content);
        $class = $this->getClass($content);

        if (!$class) {
            return null;
        }

        $fullyQualifiedClassName = $namespace ? $namespace . '\\' . $class : $class;

        return new ReflectionClass($fullyQualifiedClassName);
    }

    private function getNamespace(string $content): ?string
    {
        preg_match('/namespace (.*);/', $content, $matches);

        return $matches[1] ?? null;
    }

    private function getClass(string $content): ?string
    {
        preg_match('/class (\w+)/', $content, $matches);

        return $matches[1] ?? null;
    }

    private function getMethodsFromClass(ReflectionClass $class): array
    {
        $methods = [];

        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methods[] = $method->getName();
        }

        return $methods;
    }

    private function createAiPrompt(array $methods): string
    {
        $prompt = "Analyze the following PHP code and provide recommendations for enhancements:\n";

        foreach ($methods as $method) {
            $prompt .= "\nMethod: {$method}\n";
            $prompt .= "// Add AI-generated context here if needed\n";
            $prompt .= "// You can ask the model about potential improvements for this method.\n";
        }

        return $prompt;
    }
}
