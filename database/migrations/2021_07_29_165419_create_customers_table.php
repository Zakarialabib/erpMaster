<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CustomerGroup;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('password')->nullable();

            $table->foreignIdFor(CustomerGroup::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('wallet_id')->nullable()->constrained('wallets')->cascadeOnDelete();
            $table->boolean('status')->default(1);

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
        Schema::dropIfExists('customers');
    }
};
