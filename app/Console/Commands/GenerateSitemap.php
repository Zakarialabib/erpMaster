<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /** The name and signature of the console command. */
    protected $signature = 'sitemap:generate';

    /** The console command description. */
    protected $description = 'Generate the sitemap.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->generateSitemapIndex();
        $this->generatePagesSitemap();
        $this->generateProductsSitemap();
        $this->generateBrandsSitemap();
        $this->generateSubcategoriesSitemap();
    }

    protected function generateSitemapIndex(): void
    {
        $sitemapIndex = SitemapIndex::create()
            ->add('/products_sitemap.xml')
            ->add('/brands_sitemap.xml')
            ->add('/pages_sitemap.xml')
            ->add('/subcategories_sitemap.xml');
        $sitemapIndex->writeToFile(public_path('sitemap.xml'));
    }

    protected function generatePagesSitemap(): void
    {
        $sitemap = Sitemap::create()
            ->add(
                Url::create('/')
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(1.0)
            )
            ->add(
                Url::create(route('front.catalog'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.9)
            )
            ->add(
                Url::create(route('front.brands'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.8)
            )
            ->add(
                Url::create(route('front.categories'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.7)
            )
            ->add(
                Url::create(route('front.about'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.6)
            )
            ->add(
                Url::create(route('front.contact'))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setPriority(0.5)
            );

        $sitemap->writeToFile(public_path('pages_sitemap.xml'));
    }

    protected function generateProductsSitemap(): void
    {
        $sitemap = Sitemap::create();
        Product::select('id', 'slug', 'updated_at')->active()->get()->each(static function (Product $product) use ($sitemap): void {
            $sitemap->add(Url::create('catalog/'.$product->slug)
                ->setLastModificationDate($product->updated_at));
        });
        $sitemap->writeToFile(public_path('products_sitemap.xml'));
    }

    protected function generateBrandsSitemap(): void
    {
        $sitemap = Sitemap::create();
        Brand::select('id', 'slug', 'updated_at')->get()->each(static function (Brand $brand) use ($sitemap): void {
            $sitemap->add(Url::create('/marque/'.$brand->slug)
                ->setLastModificationDate($brand->updated_at));
        });
        $sitemap->writeToFile(public_path('brands_sitemap.xml'));
    }

    protected function generateSubcategoriesSitemap(): void
    {
        $sitemap = Sitemap::create();

        Subcategory::select('id', 'slug', 'updated_at')->get()->each(static function (Subcategory $subcategory) use ($sitemap): void {
            $sitemap->add(Url::create('/categorie/'.$subcategory->slug));
        });

        $sitemap->writeToFile(public_path('subcategories_sitemap.xml'));
    }
}
