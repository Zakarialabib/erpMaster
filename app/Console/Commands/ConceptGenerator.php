<?php

namespace App\Console\Commands;

use App\Services\KoboldAIService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\OpenAi;
use Http\Client\Exception\RequestException;
use Symfony\Component\Console\Input\InputOption;

class ConceptGenerator extends Command
{
    protected $signature = 'generate:concept';
    protected $description = 'Generate Markdown file with model concepts documentation';

    public function __construct(
        private readonly OpenAi $openAi,
        private readonly KoboldAIService $koboldAIService,
    )
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
            $this->error("Model '{$modelName}' not found.");
            return;
        }

        $this->generateConcept($modelName, $model);
    }

    private function generateConceptsForAllModels(): void
    {
        $modelPath = app_path('Models');
        $modelFiles = glob("{$modelPath}/*.php");

        foreach ($modelFiles as $modelFile) {
            $modelName = pathinfo($modelFile, PATHINFO_FILENAME);
            $model = $this->loadModel($modelName);

            if ($model) {
                $this->generateConcept($modelName, $model);
            }
        }

        $this->info("\nConcepts generated for all models.");
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
        $modelClass = 'App\\Models\\' . $modelName;

        if (class_exists($modelClass)) {
            return new $modelClass;
        }

        return null;
    }

    protected function generateModelDescription(string $modelName): string
    {
        return "This is the documentation for the {$modelName} module.";
    }

    protected function generateConcept(string $modelName, $model): void
    {
        $tableName = $model->getTable();
        $modelFile = $this->getModelFilePath($modelName);

        if (!file_exists($modelFile)) {
            $this->error("Error: Model file not found for '{$modelName}'");
            return;
        }

        $modelContent = file_get_contents($modelFile);

        $prompt = "Explain the concept of the model '{$modelName}' in the context of our ERP software management system.";
        $prompt .= "\nDescribe its general purpose, the use of relationships, and any relevant details about the architecture of the '{$tableName}' table.";
        $prompt .= "\nModel Content:\n";
        $prompt .= "```\n";
        $prompt .= $modelContent;
        $prompt .= "\n```\n";
        $prompt .= "\nResponse is between 1 or 2 paragraphs max.";

        $context = 'We are working on a laravel project, using livewire and such technologies, the project is covering erp and crm business domain, so this md docs will help improve education';
      
        $response = $this->koboldAIService->processUserMessage($prompt, $context);    
        // $conceptContent = $this->openAi->execute($context, $prompt, 15000);

        $this->generateMarkdownFile($modelName, $response);

        $this->info("\nConcept documentation generated successfully for model '{$modelName}'");
    }

    protected function getModelFilePath(string $modelName): string
    {
        return app_path("Models/{$modelName}.php");
    }

    protected function generateMarkdownFile(string $modelName, string $content): void
    {
        $filePath = base_path('docs/guide/concepts.md');
        $existingContent = file_exists($filePath) ? File::get($filePath) : '';
        $updatedContent = $existingContent . "\n" . $content;
        File::put($filePath, $updatedContent);

        $this->info("Updated concept file for model '{$modelName}' with new content.");
    }
}
