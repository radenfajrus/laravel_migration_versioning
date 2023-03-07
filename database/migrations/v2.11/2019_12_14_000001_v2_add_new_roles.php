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
      Schema::table('roles', function (Blueprint $table) {
        $table->boolean('is_paid')->default(FALSE);
      });
      \Artisan::call("db:seed",["--class"=>"RoleSeederV2"]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      \Artisan::call("db:seed",["--class"=>"RoleSeederV2Rollback"]);
      Schema::table('roles', function (Blueprint $table) {
        $table->dropColumn('is_paid');
      });
    }
};
