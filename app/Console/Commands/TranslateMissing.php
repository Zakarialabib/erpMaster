<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\OpenAi;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use KKomelin\TranslatableStringExporter\Core\UntranslatedStringFinder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class TranslateMissing extends Command
{
    protected $signature = 'translate:missing';
    protected $description = 'Translate missing words in language files using AI';

    public function __construct(
        private readonly UntranslatedStringFinder $untranslatedStringFinder,
        private readonly OpenAi $openAi
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $language = $this->ask('Please provide the language code');

        // Find untranslated strings
        $untranslatedStrings = $this->untranslatedStringFinder->find($language);

        if ($untranslatedStrings === false || empty($untranslatedStrings)) {
            $this->info("No untranslated strings found for language '{$language}'.");

            return;
        }

        $this->info('Found '.count($untranslatedStrings)." untranslated strings for language '{$language}':");

        foreach ($untranslatedStrings as $untranslatedString) {
            // Use OpenAI to generate translations
            try {
                $translation = $this->fetchAiGeneratedTranslation($language, $untranslatedString);
                $this->info("Original: {$untranslatedString}\nTranslation: {$translation}\n");

                // Update the language file with the translation
                $this->updateLanguageFile($language, $untranslatedString, $translation);
            } catch (RequestException $e) {
                $this->error("Error fetching AI-generated translation for '{$untranslatedString}': ".$e->getMessage());
            }
        }

        $this->info('Translation process complete.');
    }

    /**
     * Fetch AI-generated translation for a string.
     *
     * @param string $language
     * @param string $untranslatedString
     * @return string
     *
     * @throws RequestException
     */
    private function fetchAiGeneratedTranslation(string $language, string $untranslatedString): string
    {
        // Modify this based on how your OpenAi service is structured
        $prompt = "You are a translator. Your job is to translate the following text to the language from en to {$language}, Limit response word-for-word or phrase-for-phrase translation.\n";
        $prompt .= "untranslated String: {$untranslatedString}";

        $context = "Translate the following text from en to $language, ensuring you return only the translated content without added quotes or any other extraneous details. Importantly, any word prefixed with the symbol ':' should remain unchanged";

        return $this->openAi->execute($context, $prompt, 2000);
    }

    /**
     * Update the language file with the translation.
     *
     * @param string $language
     * @param string $originalString
     * @param string $translation
     */
    private function updateLanguageFile(string $language, string $originalString, string $translation): void
    {
        $languageFilePath = base_path("lang/{$language}.json");

        if (File::exists($languageFilePath)) {
            // Read existing translations
            $translations = json_decode(File::get($languageFilePath), true);

            // Update the translation for the original string
            Arr::set($translations, $originalString, $translation);

            // Write back to the file
            File::put($languageFilePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->info("Updated language file for '{$language}' with new translation.");
        } else {
            $this->error("Language file not found for '{$language}'.");
        }
    }
}
