<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Helper\ProgressBar;
use App\Services\OpenAi;
use Http\Client\Exception\RequestException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ConceptGenerator extends Command
{
    protected $signature = 'generate:concept';
    protected $description = 'Generate Markdown file with model concepts documentation';

    public function __construct(private readonly OpenAi $openAi)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->addOption('model', 'm', InputOption::VALUE_REQUIRED, 'The model for the concept');
    }

    /**
     * Get the 'model' option or prompt the user if it's not provided.
     */
    private function getModelOption(): string
    {
        $model = $this->option('model');

        if (!$model) {
            $model = $this->ask('Please provide the model');
        }

        return $model;
    }

    public function handle(): void
    {
        $modelName = $this->getModelOption();

        $model = $this->loadModel($modelName);

        if (!$model) {
            $this->error("Model '{$modelName}' not found.");
            return;
        }

        $output = $this->output;

        $content = "# Model Concepts Documentation\n\n";

        // Use OpenAI to generate a model description
        $modelDescription = $this->generateModelDescription($model);

        $content .= "## {$modelName} Model\n\n";
        $content .= "{$modelDescription}\n\n";

        $prompt = $this->createAiPrompt($modelName, $model);
        $this->info("\nGenerating concept for model '{$modelName}'...");

        try {
            $conceptContent = $this->fetchAiGeneratedContent($prompt);
            $this->generateMarkdownFile($modelName, $conceptContent);
        } catch (RequestException $e) {
            $this->error('Error fetching AI-generated content: ' . $e->getMessage());
            return;
        }


        $this->info("\nConcept documentation generated successfully for model '{$modelName}'");
    }

    protected function loadModel(string $modelName)
    {
        $modelClass = 'App\\Models\\' . $modelName;

        if (class_exists($modelClass)) {
            return new $modelClass;
        }

        return null;
    }

    protected function generateModelDescription($modelName): string
    {
        return "This is the documentation for the {$modelName} module.";
    }

    protected function createAiPrompt(string $modelName, $model): string
    {
        $tableName = $model->getTable();
        $modelFile = $this->getModelFilePath($modelName);

        if (!file_exists($modelFile)) {
            return "Error: Model file not found for '{$modelName}'";
        }

        $modelContent = file_get_contents($modelFile);

        $prompt = "Explain the concept of the model '{$modelName}' in the context of our ERP software management system.";
        $prompt .= "\nDescribe its general purpose, the use of relationships, and any relevant details about the architecture of the '{$tableName}' table.";
        $prompt .= "\nModel Content:\n";
        $prompt .= "```\n";
        $prompt .= $modelContent;
        $prompt .= "\n```\n";
        $prompt .= "\nResponse is between 1 or 2 paragraph max.";

        return $prompt;
    }

    protected function getModelFilePath(string $modelName): string
    {
        $modelPath = app_path('Models');
        $modelFile = "{$modelPath}/{$modelName}.php";

        return $modelFile;
    }

    /**
     * Fetch AI-generated content using the provided prompt.
     *
     * @param  string  $prompt  The AI prompt
     * @return string The AI-generated content
     *
     * @throws RequestException
     */
    private function fetchAiGeneratedContent(string $prompt): string
    {
        return $this->openAi->execute($prompt, 2000);
    }

    protected function generateMarkdownFile(string $modelName, string $content): void
    {
        // File path for the concept file
        $filePath = base_path('docs/guide/concepts.md');

        // Read existing content
        $existingContent = file_exists($filePath) ? File::get($filePath) : '';

        // Append the new content
        $updatedContent = $existingContent . "\n" . $content;

        // Write back to the file
        File::put($filePath, $updatedContent);

        $this->info("Updated concept file for model '{$modelName}' with new content.");
    }
}
