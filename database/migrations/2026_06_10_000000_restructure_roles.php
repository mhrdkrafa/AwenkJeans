<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Rename role 'admin' to 'karyawan'
     * - Add new 'administrator' role (superadmin)
     */
    public function up(): void
    {
        // Rename admin → karyawan
        DB::table('roles')->where('name', 'admin')->update(['name' => 'karyawan']);

        // Add administrator role if not exists
        $exists = DB::table('roles')->where('name', 'administrator')->exists();
        if (!$exists) {
            DB::table('roles')->insert([
                'name' => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename karyawan back to admin
        DB::table('roles')->where('name', 'karyawan')->update(['name' => 'admin']);

        // Remove administrator role
        DB::table('roles')->where('name', 'administrator')->delete();
    }
};
