<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('device_models', static function (Blueprint $table): void {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('code');
            $table->string('type');

            $table->json('technical_details')->nullable();
            $table->json('features')->nullable();
            $table->json('specifications')->nullable();

            $table->string('meta_description')->nullable();
            $table->string('meta_title')->nullable();

            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_models');
    }
};
