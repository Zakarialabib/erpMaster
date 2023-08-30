<?php

declare(strict_types=1);

use App\Models\Product;
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
        Schema::create('product_warehouse', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Product::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Warehouse::class)->constrained()->restrictOnDelete();

            $table->integer('price');
            $table->integer('cost');
            $table->integer('qty');
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
        Schema::drop('product_warehouse');
    }
};
