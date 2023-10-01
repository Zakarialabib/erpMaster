<?php

declare(strict_types=1);

use App\Models\CashRegister;
use App\Models\Customer;
use App\Models\User;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->string('reference');
            $table->foreignIdFor(Customer::class)->nullOnDelete();
            $table->foreignIdFor(User::class)->cascadeOnDelete();
            $table->foreignIdFor(Warehouse::class)->nullable()->cascadeOnDelete();
            $table->foreignIdFor(CashRegister::class)->nullable()->cascadeOnDelete();

            $table->integer('tax_percentage')->default(0);
            $table->integer('tax_amount')->default(0);
            $table->integer('discount_percentage')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->integer('shipping_amount')->default(0);
            $table->double('total_amount');
            $table->double('paid_amount');
            $table->double('due_amount');
            $table->date('payment_date')->nullable();
            $table->string('status');
            $table->integer('payment_status')->default(0);
            $table->string('payment_method');
            $table->integer('shipping_status')->default(0);
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
        Schema::dropIfExists('sales');
    }
};
