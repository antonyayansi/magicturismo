<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'site:backup {--dir=storage/app/backups}';

    protected $description = 'Crea un respaldo SQL verificable de la base de datos actual';

    public function handle(): int
    {
        $dir = base_path($this->option('dir'));
        File::ensureDirectoryExists($dir);

        $stamp = now()->format('Ymd_His');
        $path = $dir.'/backup_'.$stamp.'.sql';

        $database = config('database.connections.mysql.database');
        $tables = collect(DB::select('SHOW TABLES'))
            ->map(fn ($row) => array_values((array) $row)[0])
            ->values();

        $handle = fopen($path, 'w');
        if ($handle === false) {
            $this->error('No se pudo crear el archivo de respaldo.');

            return self::FAILURE;
        }

        fwrite($handle, "-- Magic Journeys Peru backup\n");
        fwrite($handle, "-- Database: {$database}\n");
        fwrite($handle, '-- Created: '.now()->toDateTimeString()."\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        $tableCounts = [];

        foreach ($tables as $table) {
            $create = DB::select("SHOW CREATE TABLE `{$table}`");
            $createSql = array_values((array) $create[0])[1] ?? '';
            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n{$createSql};\n\n");

            $rows = DB::table($table)->get();
            $tableCounts[$table] = $rows->count();

            foreach ($rows as $row) {
                $values = collect((array) $row)->map(function ($value) {
                    if ($value === null) {
                        return 'NULL';
                    }

                    return "'".str_replace(["\\", "'"], ["\\\\", "\\'"], (string) $value)."'";
                })->implode(', ');

                $columns = collect(array_keys((array) $row))
                    ->map(fn ($col) => "`{$col}`")
                    ->implode(', ');

                fwrite($handle, "INSERT INTO `{$table}` ({$columns}) VALUES ({$values});\n");
            }

            fwrite($handle, "\n");
        }

        fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($handle);

        $checksum = hash_file('sha256', $path);
        File::put($path.'.sha256', $checksum.'  '.basename($path)."\n");

        $manifest = [
            'created_at' => now()->toIso8601String(),
            'database' => $database,
            'file' => basename($path),
            'bytes' => filesize($path),
            'sha256' => $checksum,
            'tables' => $tableCounts,
            'total_rows' => array_sum($tableCounts),
        ];
        File::put($path.'.json', json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info("Respaldo creado: {$path}");
        $this->info('SHA256: '.$checksum);
        $this->info('Tablas: '.$tables->count().' | Filas: '.$manifest['total_rows']);

        return self::SUCCESS;
    }
}
