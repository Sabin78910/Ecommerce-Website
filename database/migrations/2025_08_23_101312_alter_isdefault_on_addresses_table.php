<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1) Backfill any NULLs to 0
        DB::statement("UPDATE addresses SET isdefault = 0 WHERE isdefault IS NULL");

        // 2) Enforce NOT NULL + DEFAULT 0 (MySQL/MariaDB)
        DB::statement("ALTER TABLE addresses MODIFY isdefault TINYINT(1) NOT NULL DEFAULT 0");
    }

    public function down(): void
    {
        // Roll back to nullable, no default (adjust if your old schema differed)
        DB::statement("ALTER TABLE addresses MODIFY isdefault TINYINT(1) NULL DEFAULT NULL");
    }
};

