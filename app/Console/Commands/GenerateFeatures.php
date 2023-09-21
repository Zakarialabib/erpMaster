<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GenerateFeatures extends Command
{
    protected $signature = 'generate:features';

    protected $description = 'Generate features table in Markdown format';

    public function handle()
    {
        try {
            $livewireFiles = $this->getLivewireFiles();

            $output = new ConsoleOutput();
            $progressBar = new ProgressBar($output, count($livewireFiles));
            $progressBar->start();

            $this->info('Extracting feature names from files...');

            $tableContent = "| Controller/Path | Methods |\n| --- | --- |\n";

            foreach ($livewireFiles as $file) {
                $this->processFile($file, $tableContent, $progressBar);
            }

            $markdownContent = "---\ntitle: Features\nlang: en-US\n---\n\n# Livewire Features\n\n".$tableContent;

            $this->saveTableContentToFile($markdownContent);

            $progressBar->finish();
            $this->info("\nFeatures generated successfully!");

            return 0; // Command executed successfully
        } catch (Exception $exception) {
            $this->error('An error occurred: '.$exception->getMessage());

            return 1; // Command failed
        }
    }

    private function processFile($file, string &$tableContent, ProgressBar $progressBar): void
    {
        $featureName = str_replace('.php', '', basename((string) $file));
        $folderName = basename(dirname((string) $file));
        $content = file_get_contents($file);
        $methods = $this->getMethods($content);
        $methodsString = implode(', ', $methods);

        $tableContent .= "| {$folderName}/{$featureName} | {$methodsString} |\n";

        $progressBar->advance();
    }

    private function saveTableContentToFile(string $content): void
    {
        $fileName = 'features.md';
        file_put_contents(base_path('docs/guide/'.$fileName), $content);
    }

    /** @return mixed[] */
    private function getLivewireFiles($directory = 'app/Livewire'): array
    {
        $livewireFiles = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $livewireFiles[] = $file->getPathname();
            }
        }

        return $livewireFiles;
    }

    /** @return string[] */
    private function getMethods(string|bool $content): array
    {
        $methods = [];
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if (str_starts_with($trimmedLine, 'public function')) {
                $method = trim(str_replace(['public function', '()'], '', $trimmedLine));
                $methods[] = $method;
            }
        }

        return $methods;
    }
}
