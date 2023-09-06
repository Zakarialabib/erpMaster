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
        Schema::create('pagesettings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_sliders')->default(false);
            $table->tinyInteger('is_contact')->default(false);
            $table->tinyInteger('is_offer')->default(false);
            $table->tinyInteger('is_title')->default(true);
            $table->tinyInteger('is_description')->default(true);
            $table->tinyInteger('is_package')->default(false);
            $table->integer('section_order')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->string('bg_color')->nullable();
            $table->string('text_color')->nullable();
            $table->tinyInteger('darkMode')->nullable();
            $table->integer('font_size')->nullable();
            $table->json('custom_properties')->nullable();
            $table->string('status')->default(true);
            $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->foreignId('featured_banner_id')->nullable()->constrained('featured_banners')->nullOnDelete();
            $table->foreignId('language_id')->nullable()->constrained('languages')->nullOnDelete();
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
        Schema::dropIfExists('pagesettings');
    }
};
