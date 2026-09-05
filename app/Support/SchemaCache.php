<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SchemaCache
{
    protected static array $tables = [];

    public static function hasTable(string $table): bool
    {
        if (array_key_exists($table, self::$tables)) {
            return self::$tables[$table];
        }

        return self::$tables[$table] = Cache::remember('schema.table.'.$table, 3600, fn () => Schema::hasTable($table));
    }
}
