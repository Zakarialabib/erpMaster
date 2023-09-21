<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Product;
use Automattic\WooCommerce\Client;
use DOMDocument;
use Exception;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mimey\MimeTypes;
use App\Helpers;

class SyncProductWooCommerce implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $wooClient;

    /**
     * @param $consumer_sec
     * @param $site_url
     * @param $consumer_key
     * @param $current_page
     */
    public function __construct(public $site_url, public $consumer_key, public $consumer_sec, public $current_page)
    {
    }

    public function handle(): void
    {
        $this->wooClient = new Client($this->site_url, $this->consumer_key, $this->consumer_sec);
        @set_time_limit(900);
        @ini_set('max_execution_time', 900);
        @ini_set('default_socket_timeout', 900);
        $this->saveProducts();
    }

    protected function saveProducts()
    {
        $products = $this->wooClient->get('products', [
            'page'     => $this->current_page,
            'per_page' => 10,
        ]);
        $newProducts = [];

        foreach ($products as $product) {
            $images = [];

            foreach ($product->images as $image) {
                $images[] = $this->getImage($image->src);
            }

            $categories = [];

            foreach ($product->categories as $category) {
                if ($slug) {
                    $categories[] = $slug->reference_id;
                } else {
                    $newCategory = app(ProductCategoryInterface::class)->createOrUpdate([
                        'name'        => $category->name,
                        'parent_id'   => $category->parent ?? 0,
                        'description' => $category->description ?? '',
                        'order'       => $category->menu_order ?? 0,
                        'image'       => $category->image ?? '',
                    ]);

                    $categories[] = $newCategory->id;
                }
            }

            $newProducts[$product->slug] = [
                'name'        => $product->name,
                'description' => $product->short_description,
                'content'     => $product->short_description,
                // 'price'       => $product->price,
                'categories' => array_unique($categories),
                'image'      => $images[rand(0, count($images) - 1)],
                'images'     => json_encode($images),
            ];

            $newProduct = Product::createOrUpdate($newProducts[$product->slug]);
        }
    }

    protected function getImage($image)
    {
        if ( ! empty($image)) {
            $info = pathinfo((string) $image);

            try {
                $contents = file_get_contents($image);
            } catch (Exception) {
                return $image;
            }

            if ($contents === '' || $contents === false) {
                return $image;
            }

            $path = '/tmp';

            if ( ! File::isDirectory($path)) {
                File::makeDirectory($path, 0755);
            }

            $path .= '/'.$info['basename'];
            file_put_contents($path, $contents);

            $mimeType = (new MimeTypes())->getMimeType(File::extension($image));

            $fileUpload = new UploadedFile($path, $info['basename'], $mimeType, null, true);

            $result = Helpers::handleUpload($fileUpload, 0, 'products');

            File::delete($path);

            if ($result['error'] === false) {
                $image = $result['data']->url;
            }
        }

        return $image;
    }

    protected function changeImageInContent($content)
    {
        $htmlDom = new DOMDocument();
        libxml_use_internal_errors(true);
        @$htmlDom->loadHTML($content);
        $imageTags = $htmlDom->getElementsByTagName('img');

        foreach ($imageTags as $imageTag) {
            if (str_contains(parse_url((string) $this->site_url, PHP_URL_HOST), $imageTag->getAttribute('src'))) {
                $newImage = $this->getImage($imageTag->getAttribute('src'));
                $content = str_replace($imageTag->getAttribute('src'), $newImage, (string) $content);
            }
        }

        return $content;
    }
}
