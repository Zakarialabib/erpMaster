<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference');
            $table->integer('from_warehouse_id');
            $table->integer('to_warehouse_id');
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->integer('item');
            $table->double('total_qty');
            $table->double('total_tax');
            $table->double('total_cost');
            $table->double('total_amount');
            $table->double('shipping')->nullable();
            $table->string('document')->nullable();
            $table->integer('status');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('transfers');
    }
};
