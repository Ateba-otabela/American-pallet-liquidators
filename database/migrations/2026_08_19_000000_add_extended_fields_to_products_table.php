<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('condition')->nullable();
            $table->integer('number_of_units')->nullable();
            $table->decimal('estimated_retail_value', 10, 2)->nullable();
            $table->string('manifest_url')->nullable();
            $table->string('dimensions')->nullable();
            $table->integer('weight')->nullable(); // in lbs
            $table->text('damage_info')->nullable();
            $table->text('testing_info')->nullable();
            $table->string('pickup_location')->default('251 A St, Jeffersonville, IN 47130')->nullable();
            $table->text('shipping_info')->nullable();
            $table->decimal('estimated_shipping_cost', 10, 2)->nullable();
            $table->text('whats_included')->nullable();
            $table->text('whats_not_included')->nullable();
            $table->text('refund_conditions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'condition',
                'number_of_units',
                'estimated_retail_value',
                'manifest_url',
                'dimensions',
                'weight',
                'damage_info',
                'testing_info',
                'pickup_location',
                'shipping_info',
                'estimated_shipping_cost',
                'whats_included',
                'whats_not_included',
                'refund_conditions'
            ]);
        });
    }
};
