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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('customer_phone')->nullable()->after('customer_name');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint
            $table->foreignId('user_id')->nullable()->change(); // Make it nullable
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add it back
            
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->string('image')->nullable()->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_phone', 'image']);
            
            // To be safe when rolling back, we won't strictly enforce making user_id non-nullable 
            // if there's null data, but we define the constraint again.
            // $table->foreignId('user_id')->nullable(false)->change(); 
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('customer_phone');
        });
    }
};
