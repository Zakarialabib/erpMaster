<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Category::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Warehouse::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Brand::class)->nullable()->constrained()->nullOnDelete();

            $table->string('name');
            $table->string('code')->nullable();
            $table->string('barcode_symbology')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('slug')->unique();
            $table->text('image')->nullable();
            $table->text('gallery')->nullable();
            $table->string('unit')->nullable();
            $table->integer('order_tax')->default(0);
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->tinyInteger('tax_type')->default(0);
            $table->text('embeded_video')->nullable();
            $table->json('subcategories')->nullable();
            $table->json('options')->nullable();
            $table->string('condition')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('best')->default(false);
            $table->boolean('hot')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
