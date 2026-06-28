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
        Schema::table('product_views', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('user_id');
            $table->string('ip_address', 45)->nullable()->after('session_id');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->string('page_type', 20)->default('product')->after('user_agent');
        });

        // Make product_id nullable separately to support catalog-level views
        Schema::table('product_views', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_views', function (Blueprint $table) {
            $table->dropColumn(['session_id', 'ip_address', 'user_agent', 'page_type']);
        });

        Schema::table('product_views', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
        });
    }
};
