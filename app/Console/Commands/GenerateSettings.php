<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Helper\ProgressBar;

class GenerateSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a list of setting names and save them to an MD file';

    protected $documentedSettings = [];

    /** Execute the console command. */
    public function handle(): void
    {
        $settingUsages = $this->findSettingUsages();
        $output = $this->output;

        $progressBar = new ProgressBar($output, count($settingUsages));
        $progressBar->start();

        $content = "# Setting Documentation\n\n";

        foreach ($settingUsages as $settingUsage) {
            $settingName = $settingUsage['name'];

            // Check if this setting has already been documented
            if ( ! in_array($settingName, $this->documentedSettings)) {
                $this->documentedSettings[] = $settingName;

                $settingDescription = $settingUsage['description'];

                $content .= "- Setting: `{$settingName}`\n";
            }

            $progressBar->advance();
        }

        $this->generateMarkdownFile($content);
        $progressBar->finish();
        $this->info("\nSetting documentation generated successfully!");
    }

    protected function findSettingUsages(): array
    {
        $files = $this->getPhpFilesInAppAndResources();

        $settingUsages = [];

        foreach ($files as $file) {
            $content = file_get_contents($file);

            // Use regular expressions to find settings() calls and extract setting names
            preg_match_all('/settings\(\'(.*?)\'\)/', $content, $matches);

            if ( ! empty($matches[1])) {
                foreach ($matches[1] as $settingName) {
                    $settingUsages[] = [
                        'name' => $settingName,
                    ];
                }
            }
        }

        return $settingUsages;
    }

    protected function getPhpFilesInAppAndResources(): array
    {
        $appAndResourcesDirectories = [
            app_path(),
            resource_path(),
        ];

        $phpFiles = [];

        foreach ($appAndResourcesDirectories as $directory) {
            $finder = new \Symfony\Component\Finder\Finder();
            $finder->files()->in($directory)->name('*.php');

            foreach ($finder as $file) {
                $phpFiles[] = $file->getPathname();
            }
        }

        return $phpFiles;
    }

    protected function generateMarkdownFile(string $content): void
    {
        $filePath = base_path('docs/guide/settings.md');
        File::put($filePath, $content);
    }
}
