<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\OpenAi;
use Http\Client\Exception\RequestException;
use Symfony\Component\Console\Input\InputOption;

class DocsGen extends Command
{
    protected $signature = 'doc:concept';
    protected $description = 'Generate Markdown file with model concepts documentation';

    public function __construct(private readonly OpenAi $openAi)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('model', 'm', InputOption::VALUE_REQUIRED, 'The model for the concept');
        $this->addOption('all', null, InputOption::VALUE_NONE, 'Generate concepts for all models');
    }

    public function handle(): void
    {
        // If generating concepts for all models
        if ($this->option('all')) {
            $this->generateConceptsForAllModels();
        } else {
            $this->generateConceptForSingleModel();
        }
    }

    private function generateConceptForSingleModel(): void
    {
        $modelName = $this->getModelOption();
        $model = $this->loadModel($modelName);

        if (!$model) {
            return;
        }

        $this->generateConcept($modelName, $model);
    }

    private function generateConceptsForAllModels(): void
    {
        foreach ($this->getModelNames() as $modelName) {
            $model = $this->loadModel($modelName);

            if ($model) {
                $this->generateConcept($modelName, $model);
            }
        }

        $this->info("\nConcepts generated for all models.");
    }
    
    protected function getModelFilePath(string $modelName): string
    {
        // Get the full path of the model file
        return app_path("Models/{$modelName}.php");
    }

    private function getModelNames(): array
    {
        $modelPath = app_path('Models');
        $modelFiles = glob("{$modelPath}/*.php");

        return array_map(
            fn ($modelFile) => pathinfo($modelFile, PATHINFO_FILENAME),
            $modelFiles
        );
    }

    private function getModelOption(): string
    {
        $model = $this->option('model');

        if (!$model) {
            $model = $this->ask('Please provide the model');
        }

        return $model;
    }
    
    protected function loadModel(string $modelName)
    {
        $modelClass = "App\\Models\\{$modelName}";

        return class_exists($modelClass) ? new $modelClass : null;
    }

    protected function generateConcept(string $modelName, $model): void
    {
        // Get table name and model file path
        $tableName = $model->getTable();
        $modelFile = $this->getModelFilePath($modelName);

        if (!file_exists($modelFile)) {
            $this->error("Error: Model file not found for '{$modelName}'");
            return;
        }

        // Read the content of the model file
        $modelContent = file_get_contents($modelFile);

        // Define the prompt for AI generation
        $prompt = "Explain the concept of the model '{$modelName}' in the context of our ERP software management system.";
        $prompt .= "\nDescribe its general purpose, the use of relationships, and any relevant details about the architecture of the '{$tableName}' table.";
        $prompt .= "\nModel Content:\n";
        $prompt .= "```\n";
        $prompt .= $modelContent;
        $prompt .= "\n```\n";
        $prompt .= "\nResponse is between 1 or 2 paragraphs max.";

        try {
            // Define the context for AI generation
            $context = 'We are working on a Laravel project, using Livewire and React components. The project focuses on ERP and CRM functionalities, contributing to the education sector.';

            // Execute OpenAI to generate content based on the context and prompt
            $conceptContent = $this->openAi->execute($context, $prompt, 15000);

            // Generate Markdown file with the generated content
            $this->generateMarkdownFile($modelName, $conceptContent);
        } catch (RequestException $e) {
            $this->error('Error fetching AI-generated content: ' . $e->getMessage());
        }

        $this->info("\nConcept documentation generated successfully for model '{$modelName}'");
    }



    protected function generateMarkdownFile(string $modelName, string $content): void
    {
        // Specify the path for the Markdown file
        $filePath = base_path('docs/guide/concepts.md');

        // Read existing content or create an empty string if the file doesn't exist
        $existingContent = file_exists($filePath) ? File::get($filePath) : '';

        // Append the new content and update the file
        $updatedContent = $existingContent . "\n" . $content;
        File::put($filePath, $updatedContent);

        $this->info("Updated concept file for model '{$modelName}' with new content.");
    }
}
