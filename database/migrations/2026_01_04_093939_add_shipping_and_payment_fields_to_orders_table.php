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
        Schema::table('orders', function (Blueprint $table) {
            $table->text('shipping_address')->nullable()->after('customer_contact');
            $table->string('shipping_method')->default('jnt')->after('shipping_address')->comment('jnt atau pickup');
            $table->unsignedBigInteger('shipping_cost')->default(0)->after('shipping_method');
            $table->string('payment_method')->default('transfer')->after('shipping_cost')->comment('transfer, cash, dll');
            $table->text('payment_info')->nullable()->after('payment_method')->comment('Informasi rekening atau instruksi pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_address',
                'shipping_method',
                'shipping_cost',
                'payment_method',
                'payment_info',
            ]);
        });
    }
};
