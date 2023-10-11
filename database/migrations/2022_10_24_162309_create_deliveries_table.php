<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference');
            $table->foreignUuid('sale_id')->nullable()->constrained('sales')->onDelete('cascade');
            $table->foreignUuid('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->foreignId('shipping_id')->nullable()->constrained('shippings')->onDelete('cascade');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('address');
            $table->string('delivered_by')->nullable();
            $table->string('recieved_by')->nullable();
            $table->string('document')->nullable();
            $table->string('note')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
