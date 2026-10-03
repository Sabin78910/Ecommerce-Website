<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Normalize existing data (turn NULLs into 0)
        DB::table('addresses')->whereNull('isdefault')->update(['isdefault' => 0]);

        // 2) Make NOT NULL + DEFAULT 0
        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('isdefault')->default(0)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        // Best-effort rollback: allow NULL again and remove default
        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('isdefault')->nullable()->default(null)->change();
        });
    }
};

