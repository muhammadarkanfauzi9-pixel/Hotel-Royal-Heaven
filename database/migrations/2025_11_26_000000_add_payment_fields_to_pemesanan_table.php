<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            if (!Schema::hasColumn('pemesanan', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status_pemesanan');
            }
            if (!Schema::hasColumn('pemesanan', 'midtrans_transaction_id')) {
                $table->string('midtrans_transaction_id')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('pemesanan', 'payment_url')) {
                $table->string('payment_url')->nullable()->after('midtrans_transaction_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            if (Schema::hasColumn('pemesanan', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('pemesanan', 'midtrans_transaction_id')) {
                $table->dropColumn('midtrans_transaction_id');
            }
            if (Schema::hasColumn('pemesanan', 'payment_url')) {
                $table->dropColumn('payment_url');
            }
        });
    }
};
