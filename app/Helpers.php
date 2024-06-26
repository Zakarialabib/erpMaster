<?php

declare(strict_types=1);

namespace App;

use App\Enums\MenuPlacement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Section;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Helpers
{
    public static function getEcommerceProducts()
    {
        return Product::whereHas('warehouses', static function ($query): void {
            $query->where('is_ecommerce', true)
                ->where('qty', '>', 0);
        });
    }

    public static function getActiveCategories()
    {
        return Category::active()
            ->select('id', 'name')
            ->get();
    }

    public static function getActivePages()
    {
        return Page::active()
            ->select('id', 'title', 'slug')
            ->get();
    }

    public static function formatBytes($bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2).' '.$units[$pow];
    }

    public static function flagImageUrl($language_code)
    {
        return asset(sprintf('images/flags/%s.png', $language_code));
    }

    public static function formatDate($timestamp): string
    {
        return date('F j, Y, g:i a', $timestamp);
    }

    public static function getActiveBrands()
    {
        return Brand::active()
            ->select('id', 'name', 'slug')
            ->get();
    }

    public static function categoryName($category_id)
    {
        return Category::find($category_id)->name ?? '';
    }

    public static function warehouseName($warehouse_id)
    {
        return Warehouse::find($warehouse_id)->name;
    }

    public static function subcategoryName($subcategory_id)
    {
        return Subcategory::find($subcategory_id)->name;
    }

    public static function brandName($brand_id)
    {
        return Brand::find($brand_id)->name;
    }

    /** @return string|null */
    public static function productLink(mixed $product)
    {
        if ($product) {
            return route('front.product', $product->slug);
        }

        return null;
    }

    /**
     * Uploads an image from a URL and returns the file name.
     *
     * @param string $image_url The URL of the image to upload.
     * @param string $productName The name of the product.
     * @param int $size The size of the square to resize the image to.
     *
     * @return string|null The name of the uploaded file, or null if the upload failed.
     */
    public static function uploadImage($image_url, $productName): string
    {
        $opts = [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ];

        $context = stream_context_create($opts);

        $image = file_get_contents($image_url, false, $context);
        $name = Str::slug($productName).'-'.sprintf('%02d', 0).'.jpg';
        $path = public_path().'/images/products/'.$name;
        file_put_contents($path, $image);

        return $name;
    }

    /** @return array<string>|null */
    public static function uploadGallery(mixed $gallery): ?array
    {
        // Path cannot be empty
        if (empty($gallery)) {
            return null;
        }

        $gallery = explode(',', (string) $gallery);

        return array_map(static function ($image): string {
            $image = file_get_contents($image);
            $name = Str::random(10).'.jpg';
            $path = public_path().'/images/products/'.$name;
            file_put_contents($path, $image);

            return $name;
        }, $gallery);
    }

    /** @return mixed */
    public static function createCategory(mixed $category)
    {
        // Make sure $category is a string
        $category = implode('', $category);

        return Category::create([
            'name' => $category,
            'slug' => Str::slug($category, '-'),
        ])->id;
    }

    /**
     * @param mixed $subcategory
     *
     * @return mixed
     */
    public static function createSubcategories($subcategories, mixed $category): array
    {
        $subcategoryIds = [];

        foreach (explode(',', (string) $subcategories) as $subcategory) {
            $subcategoryModel = Subcategory::create([
                'name'        => trim($subcategory),
                'slug'        => Str::slug($subcategory, '-'),
                'category_id' => Category::where('name', $category)->first()->id,
                'language'    => '3',
            ]);
            $subcategoryIds[] = $subcategoryModel->id;
        }

        return $subcategoryIds;
    }

    /** @return mixed */
    public static function createBrand(mixed $brand)
    {
        // Make sure $brand is a string
        $brand = implode('', $brand);

        return Brand::create([
            'name' => $brand,
            'slug' => Str::slug($brand, '-'),
        ])->id;
    }

    public static function handleUpload($image, $width, $height, $productName): string
    {
        $imageName = Str::slug($productName).'-'.Str::random(5).'.'.$image->extension();

        $img = Image::make($image->getRealPath())->encode('webp', 85);

        // we need to resize image, otherwise it will be cropped
        if ($img->width() > $width) {
            $img->resize($width, null, static function ($constraint): void {
                $constraint->aspectRatio();
            });
        }

        if ($img->height() > $height) {
            $img->resize(null, $height, static function ($constraint): void {
                $constraint->aspectRatio();
            });
        }

        $watermark = Image::make(public_path('images/logo/logo.png'));
        $watermark->opacity(25);

        $watermark->width();
        $watermark->height();
        $img->insert($watermark, 'bottom-left', 20, 20)->resizeCanvas($width, $height, 'center', false, '#ffffff');

        $img->stream();

        Storage::disk('local_files')->put('products/'.$imageName, $img, 'public');

        return $imageName;
    }

    public static function getHeaderMenu()
    {
        return Menu::where('placement', MenuPlacement::HEADER)
            ->with('parent')
            ->orderBy('sort_order')
            ->get();
    }

    public static function getFooterSection1Menu()
    {
        return Menu::where('placement', MenuPlacement::FOOTER_SECTION_1)
            ->orderBy('sort_order')
            ->get();
    }

    public static function getFooterSection2Menu()
    {
        return Menu::where('placement', MenuPlacement::FOOTER_SECTION_2)
            ->orderBy('sort_order')
            ->get();
    }

    public static function getHeaderMobileMenu()
    {
        return Menu::where('placement', MenuPlacement::MOBILE_HEADER)
            ->orderBy('sort_order')
            ->get();
    }

    public static function getSidebarMenu()
    {
        return Menu::where('placement', MenuPlacement::SIDEBAR)
            ->orderBy('sort_order')
            ->get();
    }

    public static function getSectionByType($type)
    {
        return Section::where('type', $type)->active()->first();
    }

    public static function getSectionTitle($id)
    {
        $section = Section::where('id', $id)->first();

        if ($section) {
            return $section->title;
        }

        return '';
    }

    public static function getSection($id)
    {
        $section = Section::where('id', $id)->first();

        if ($section) {
            return $section;
        }

        return '';
    }
}
