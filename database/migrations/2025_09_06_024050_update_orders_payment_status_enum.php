<?php
// Create this file: database/migrations/2025_09_06_000001_update_orders_payment_status_enum.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // For MySQL, we need to use raw SQL to modify enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending', 'unpaid', 'paid', 'failed', 'refunded') DEFAULT 'pending'");
        
        // Add session_id column if it doesn't exist
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'session_id')) {
                $table->string('session_id')->nullable()->after('notes');
            }
        });
    }

    public function down()
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('unpaid', 'paid') DEFAULT 'unpaid'");
        
        // Drop session_id column
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'session_id')) {
                $table->dropColumn('session_id');
            }
        });
    }
};