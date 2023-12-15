<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;
use App\Models\User;
use App\Models\Shipping;

return new class() extends Migration
{
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
            $table->foreignIdFor(User::class)->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Shipping::class)->nullable()->constrained('shippings')->cascadeOnDelete();
            $table->integer('tax_amount')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->double('total_amount');
            $table->string('status');
            $table->integer('shipping_status')->default(0);
            $table->integer('payment_status')->default(0);
            $table->string('payment_method');
            $table->date('payment_date')->nullable();
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
