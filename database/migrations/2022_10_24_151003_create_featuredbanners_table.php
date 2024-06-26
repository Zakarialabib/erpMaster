<?php

declare(strict_types=1);

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
        Schema::create('featured_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->string('link')->nullable();
            $table->text('embeded_video')->nullable();
            $table->foreignId('language_id')->nullable()->constrained('languages')->cascadeOnDelete();
            $table->foreignUuid('product_id')->nullable()->constrained('products')->cascadeOnDelete();
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
        Schema::dropIfExists('featured_banners');
    }
};
