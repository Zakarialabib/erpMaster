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
            $existingTableContent = $this->getExistingTableContent();

            $output = new ConsoleOutput();
            $progressBar = new ProgressBar($output, count($livewireFiles));
            $progressBar->start();

            $this->info('Extracting feature names from files...');

            foreach ($livewireFiles as $file) {
                $this->processFile($file, $existingTableContent, $progressBar);
            }

            $this->updateTableContent($existingTableContent);

            $progressBar->finish();
            $this->info("\nFeatures generated successfully!");

            return 0; // Command executed successfully
        } catch (Exception $e) {
            $this->error('An error occurred: '.$e->getMessage());

            return 1; // Command failed
        }
    }

    private function getLivewireFiles($directory = 'app/Livewire')
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

    private function getExistingTableContent()
    {
        $existingContent = file_get_contents(base_path('docs/guide/features.md'));
        $tableStartPos = strpos($existingContent, '| Features |');
        $tableEndPos = strpos($existingContent, '| --- |', $tableStartPos);
        $existingTableContent = substr($existingContent, $tableStartPos, $tableEndPos - $tableStartPos);

        return $existingTableContent;
    }

    private function processFile($file, &$existingTableContent, $progressBar)
    {
        $featureName = str_replace('.php', '', basename($file));
        $folderName = basename(dirname($file));
        $content = file_get_contents($file);
        $status = $this->getStatus($content);
        $coolness = $this->getCoolness($content);
        $methods = $this->getMethods($content);
        $methodsString = implode(', ', $methods);

        $existingTableContent .= "| $folderName/$featureName | $status | $coolness | $methodsString |\n";

        $progressBar->advance();
    }

    private function updateTableContent($newContent)
    {
        $existingContent = file_get_contents(base_path('docs/guide/features.md'));
        $tableStartPos = strpos($existingContent, '| Features |');
        $tableEndPos = strpos($existingContent, '| --- |', $tableStartPos);
        // | --- | --- | --- | --- |
        $existingContent = substr_replace($existingContent, $newContent, $tableStartPos, $tableEndPos - $tableStartPos);

        file_put_contents(base_path('docs/guide/features.md'), $existingContent);
    }

    private function getStatus($content)
    {
        if (strpos($content, 'done') !== false) {
            return 'done';
        } else {
            return 'in progress';
        }
    }

    private function getMethods($content)
    {
        $methods = [];
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if (strpos($trimmedLine, 'public function') === 0) {
                $method = trim(str_replace(['public function', '()'], '', $trimmedLine));
                $methods[] = $method;
            }
        }

        return $methods;
    }

    private function getCoolness($content)
    {
        if (strpos($content, 'cool') !== false) {
            return '🎉 :100:';
        } else {
            return '😐';
        }
    }
}
