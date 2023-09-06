<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->string('reference');
            $table->foreignIdFor(Customer::class)->constrained('customers')->cascadeOnDelete();
            $table->foreignId('shipping_id')->nullable()->constrained('shippings')->nullOnDelete();
            $table->foreignId('packaging_id')->nullable()->constrained('packagings')->nullOnDelete();
            $table->integer('tax_percentage')->default(0);
            $table->integer('tax_amount')->default(0);
            $table->integer('discount_percentage')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->integer('shipping_amount')->default(0);
            $table->integer('total_amount');
            $table->integer('paid_amount');
            $table->integer('due_amount');
            $table->date('payment_date')->nullable();
            $table->string('status');
            $table->string('payment_status');
            $table->string('payment_method');
            $table->string('shipping_status')->nullable();
            $table->string('document')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
