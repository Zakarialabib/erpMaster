<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\DeviceModelType;
use App\Helpers;
use App\Models\Brand;
use App\Models\DeviceModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeCommand extends Command
{
    /** The name and signature of the console command. */
    protected $signature = 'scrape:devices';

    /** The console command description. */
    protected $description = 'This function scrapes mobile phone manufacturers and their devices from gsmarena.com';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle(): int
{
    try {
        $lastIndex = (int) file_get_contents('last_index.txt');

        $retryCount = 0;
        $maxRetries = 3;
        $retryDelay = 2000; // 2 seconds

        do {
            $sitemapSource = Http::timeout(60)->get('https://www.gsmarena.com/sitemap-phones.xml');
            $retryCount++;
            usleep($retryDelay);
        } while (!$sitemapSource->successful() && $retryCount < $maxRetries);

        if (!$sitemapSource->successful()) {
            $this->error('Failed to retrieve the sitemap. Please check your internet connection and try again.');
            return 1;
        }

        $xml = simplexml_load_string($sitemapSource->body());

        $progressbar = $this->output->createProgressBar(count($xml->url));
        $progressbar->start();

        $index = 0;

        foreach ($xml->url as $url) {
            if ($index < $lastIndex) {
                $index++;
                $progressbar->advance();

                continue;
            }

            if (
                !strpos($url->loc->__toString(), 'related.php') &&
                !strpos($url->loc->__toString(), '-3d-spin-') &&
                !strpos($url->loc->__toString(), '-pictures-')
            ) {

                // Fetch the URL contents using session management
                $httpSource = $this->fetchUrl((string) $url->loc);
                if ($httpSource === null) {
                    $this->line("URL already fetched in this session: {$url->loc->__toString()}. Skipping...");
                    $progressbar->advance();
                    continue;
                }

                if (!$httpSource->successful()) {
                    $this->error("Failed to fetch data for URL: {$url->loc->__toString()}. Skipping... (HTTP status code: {$httpSource->status()})");
                    $progressbar->advance();
                    continue;
                }

                if (!$httpSource->successful()) {
                    $this->error("Failed to fetch data for URL: {$url->loc->__toString()} - Skipping... (HTTP status code: {$httpSource->status()})");
                    $progressbar->advance();
                    continue;
                }

                $parser = str_get_html($httpSource->body());

                $name = $parser->find('[data-spec="modelname"]')[0]->plaintext ?? null;

                if ($name) {
                    $brandName = explode(' ', $name)[0] ?? null;

                    if ($brandName) {
                        $brand = Brand::firstOrCreate([
                            'name' => $brandName,
                            'slug' => Str::slug($brandName),
                        ]);

                        $specificationsDom = $parser->find('#specs-list table tr');

                        $specifications = [];
                        $lastGroup = null;
                        $lastSpec = null;

                        foreach ($specificationsDom as $row) {
                            $rowGroup = $this->clearText($row->find('th')[0]->plaintext ?? null);

                            if ( ! empty($rowGroup)) {
                                $lastGroup = $rowGroup;
                            }

                            $theSpec = $this->clearText($row->find('.ttl')[0]->plaintext ?? null);

                            if ( ! empty($theSpec)) {
                                $lastSpec = $theSpec;
                            } else {
                                $lastSpec = 'Additional';
                            }

                            if ($lastSpec) {
                                $info = $this->clearText($row->find('.nfo')[0]->plaintext ?? null);
                                $specKey = $this->getAvailableIndex($lastSpec, $specifications[$lastGroup] ?? []);
                                $specifications[$lastGroup][$specKey] = $info;
                            }
                        }

                        $device = DeviceModel::firstOrCreate([
                            'name'              => $name,
                            'image'             => Helpers::uploadImage($parser->find('.specs-photo-main img')[0]->src, $name,'device-models', 600) ?? 'default.jpg',
                            'code'              => Str::slug($name),
                            'slug'              => Str::slug($name),
                            'type'              => DeviceModelType::SMARTPHONE,
                            'brand_id'          => $brand->id,
                            'technical_details' => [
                                'released_at'        => $parser->find('[data-spec="released-hl"]')[0]->plaintext ?? null,
                                'body'               => $parser->find('[data-spec="body-hl"]')[0]->plaintext ?? null,
                                'os'                 => $parser->find('[data-spec="os-hl"]')[0]->plaintext ?? null,
                                'storage'            => $parser->find('[data-spec="storage-hl"]')[0]->plaintext ?? null,
                                'display_size'       => $parser->find('[data-spec="displaysize-hl"]')[0]->plaintext ?? null,
                                'display_resolution' => $parser->find('[data-spec="displayres-hl"]')[0]->plaintext ?? null,
                                'camera_pixels'      => $parser->find('.accent.accent-camera')[0]->plaintext ?? null,
                                'video_pixels'       => $parser->find('[data-spec="videopixels-hl"]')[0]->plaintext ?? null,
                                'ram'                => $parser->find('.accent.accent-expansion')[0]->plaintext ?? null,
                                'chipset'            => $parser->find('[data-spec="chipset-hl"]')[0]->plaintext ?? null,
                                'battery_size'       => $parser->find('.accent.accent-battery')[0]->plaintext ?? null,
                                'battery_type'       => $parser->find('[data-spec="battype-hl"]')[0]->plaintext ?? null,
                            ],
                            'features'         => null,
                            'specifications'   => $specifications,
                            'meta_title'       => __('CHRILIA Maroc').$name,
                            'meta_description' => __('CHRILIA Maroc - Find the best price in internet for electronics & gadgets'),
                        ]);

                        $device->save();
                    }
                }

                sleep(10);
            }

            file_put_contents('last_index.txt', $index);

            $progressbar->advance();

            $index++;
        }

        $progressbar->finish();

        return 0;
    } catch (\Exception $e) {
        $this->error('An error occurred during the scraping process: ' . $e->getMessage());
        return 1;
    }
}


    private function clearText(?string $text): string
    {
        if ($text === null) {
            return '';
        }

        $text = trim($text);

        return str_replace('&nbsp;', '', $text);
    }

    /** @param array $array */
    private function getAvailableIndex(string $arrayKey, array $array): string
    {
        $availableIndex = 1;

        while (array_key_exists($arrayKey, $array)) {
            $arrayKey = $arrayKey.'_'.$availableIndex;
            $availableIndex++;
        }

        return $arrayKey;
    }

    // Function to fetch the contents of a URL using session management
    public function fetchUrl($url) {
        // Check if the session key for the URL exists
        if (!isset($_SESSION[$url])) {
            // Create a new session key for the URL
            $_SESSION[$url] = true;
            
            // Make the HTTP request to fetch the URL
            $httpSource = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',
            ])->get($url);
            
            // Return the response
            return $httpSource;
        } else {
            // The URL has already been fetched in this session
            // You can choose to skip the request or return cached data if available
            // For simplicity, we'll return null in this example
            return null;
        }
    }

}
