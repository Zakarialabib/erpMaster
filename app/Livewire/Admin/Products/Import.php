<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Jobs\ImportJob;
use App\Jobs\ProductJob;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Helpers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Import extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $listeners = [
        'importModal', 'import',
        'importUpdates',
    ];

    public $file;

    public $sheetLink;

    public $importModal = null;

    public function render(): View|Factory
    {
        return view('livewire.admin.products.import');
    }

    public function downloadSample(): BinaryFileResponse
    {
        return Storage::disk('exports')->download('products_import_sample.xls');
    }

    public function importModal()
    {
        abort_if(Gate::denies('product access'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->importModal = true;
    }

    public function importUpdates()
    {
        abort_if(Gate::denies('product access'), 403);

        if ($this->file->extension() === 'xlsx' || $this->file->extension() === 'xls') {
            $filename = time().'-product.'.$this->file->getClientOriginalExtension();
            $this->file->storeAs('products', $filename);

            ImportJob::dispatch($filename);

            $this->alert('success', __('Product imported successfully!'));
        } else {
            $this->alert('error', __('File is a '.$this->file->extension().' file.!! Please upload a valid xls/csv file..!!'));
        }

        $this->importModal = false;
    }

    public function import()
    {
        abort_if(Gate::denies('product access'), 403);

        if ($this->file->extension() === 'xlsx' || $this->file->extension() === 'xls') {
            $filename = time().'-product.'.$this->file->getClientOriginalExtension();
            $this->file->storeAs('products', $filename);

            ProductJob::dispatch($filename);

            $this->alert('success', __('Product imported successfully!'));
        } else {
            $this->alert('error', __('File is a '.$this->file->extension().' file.!! Please upload a valid xls/csv file..!!'));
        }

        $this->importModal = false;
    }

    // public function import(): void
    // {
    //     $this->validate([
    //         'import_file' => [
    //             'required',
    //             'file',
    //         ],
    //     ]);

    //     Product::import(new ProductImport(), $this->file('import_file'));

    //     $this->alert('success', __('Products imported successfully'));

    //     $this->importModal = false;
    // }

    public function googleSheetImport()
    {
        $response = Http::get($this->sheetLink);

        $data = json_decode($response->getBody(), true);

        foreach ($data as $index => $row) {
            $product = Product::where('name', $row[0])->first();

            $warehouseId = $row['warehouse'];

            if ($product === null) {
                $product = Product::create([
                    'name'          => $row['name'],
                    'description'   => $row['description'],
                    'slug'          => Str::slug($row['name'], '-').'-'.Str::random(5),
                    'code'          => $row['code'] ?? Str::random(10),
                    'category_id'   => Category::where('name', $row['category'])->first()->id ?? Helpers::createCategory(['name' => $row['categery']])->id ?? null,
                    'subcategories' => ! empty($row['subcategories']) ? Subcategory::whereIn('name', explode(',', $row[7]))->pluck('id')->toArray() : [],
                    'brand_id'      => Brand::where('name', $row['brand'])->first()->id ?? Helpers::createBrand(['name' => $row[8]]),
                    'image'         => Helpers::uploadImage($row['code'], $row['name']) ?? 'default.jpg',
                    // 'gallery' => getGalleryFromUrl($row[7]) ?? null,
                    'meta_title'       => Str::limit($row['name'], 60),
                    'meta_description' => Str::limit($row['description'], 160),
                    'status'           => 0,
                ]);
                $product->warehouses()->attach($row['warehouse'], [
                    'qty'         => $row['quantity'],
                    'price'       => $row['price'],
                    'cost'        => $row['cost'],
                    'old_price'   => $row['old_price'] ?? null,
                    'stock_alert' => $row['stock_alert'] ?? null,
                    // ... other product warehouse attributes ...
                ]);
            }

            $warehouseData = [
                'qty'         => $row['quantity'],
                'price'       => $row['price'],
                'cost'        => $row['cost'],
                'old_price'   => $row['old_price'] ?? null,
                'stock_alert' => $row['stock_alert'] ?? null,
                // ... other product warehouse attributes ...
            ];
            $product->warehouses()->updateExistingPivot($warehouseId, $warehouseData);

            return null;
        }
    }
}
