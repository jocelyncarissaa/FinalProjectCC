<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('shipments', function (Blueprint $table) {
        $table->id();

        // Pemilik pesanan
        $table->foreignId('order_id')->constrained()->onDelete('cascade');

        // Status seperti Shopee
        $table->enum('status', [
            'pending',
            'processed',
            'on_delivery',
            'delivered'
        ])->default('pending');

        // Untuk tracking timeline
        $table->timestamp('processed_at')->nullable();
        $table->timestamp('shipped_at')->nullable();
        $table->timestamp('delivered_at')->nullable();

        $table->string('tracking_code')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
