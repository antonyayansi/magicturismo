<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('datos_empresa')) {
            return;
        }

        if (Schema::hasColumn('datos_empresa', 'logo')) {
            DB::statement('ALTER TABLE datos_empresa MODIFY logo VARCHAR(255) NULL');
        }

        if (Schema::hasColumn('datos_empresa', 'favicon')) {
            DB::statement('ALTER TABLE datos_empresa MODIFY favicon VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        // Conserva nulls existentes.
    }
};
