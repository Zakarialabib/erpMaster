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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->json('description');
            $table->string('image')->nullable();
            $table->string('type')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->tinyInteger('is_sliders')->default(false);
            $table->tinyInteger('is_contact')->default(false);
            $table->tinyInteger('is_offer')->default(false);
            $table->tinyInteger('is_title')->default(true);
            $table->tinyInteger('is_description')->default(true);
            $table->tinyInteger('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
