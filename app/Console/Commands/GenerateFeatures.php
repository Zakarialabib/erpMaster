<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;


class GenerateFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:features';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    
    public function handle()
    {
        try {
            $livewireFiles = [];
            $livewireDirectories = glob('app/Livewire/*', GLOB_ONLYDIR);

            foreach ($livewireDirectories as $directory) {
                $livewireFiles = array_merge($livewireFiles, glob($directory . '/*.php'));
            }

            // Read the existing features.md file
            $existingContent = file_get_contents(base_path('docs/guide/features.md'));

            // Extract the existing table content
            $tableStartPos = strpos($existingContent, '| Features |');
            $tableEndPos = strpos($existingContent, '| --- |', $tableStartPos);
            $existingTableContent = substr($existingContent, $tableStartPos, $tableEndPos - $tableStartPos);

            $output = new ConsoleOutput();
            $progressBar = new ProgressBar($output, count($livewireFiles));
            $progressBar->start();

            $this->info("\Extract the feature name files!");
            foreach ($livewireFiles as $file) {
                // 
                $featureName = str_replace('.php', '', basename($file));    
                // Extract the folder name from the file path
                $folderName = basename(dirname($file));
                // Determine the status and coolness level based on your criteria
                $content = file_get_contents($file);
                $status = $this->getStatus($content);
                $coolness = $this->getCoolness($content);
                // Extract the methods from the controller file
                $methods = $this->getMethods($content);

                // Format the methods as a comma-separated string
                $methodsString = implode(', ', $methods);

                $existingTableContent .= "| $folderName/$featureName | $status | $coolness | $methodsString |\n";

                // Advance the progress bar
                $progressBar->advance();
            }

            file_put_contents(base_path('docs/guide/features.md'), $existingTableContent);

            $progressBar->finish();
            $this->info("\nFeatures generated successfully!");
            return 0; // Command executed successfully
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            return 1; // Command failed
        }
    }


        /**
     * Determine the status based on the content.
     *
     * @param string $content
     * @return string
     */
    private function getStatus($content)
    {
        // Example logic: Check if the file contains the word "done" in its content
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

    /**
     * Determine the coolness level based on the content.
     *
     * @param string $content
     * @return string
     */
    private function getCoolness($content)
    {
        // Example logic: Check if the file contains the word "cool" in its content
        if (strpos($content, 'cool') !== false) {
            return '🎉 :100:';
        } else {
            return '😐';
        }
    }

}
