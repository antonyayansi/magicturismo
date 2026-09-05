<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class CmsBackupCommand extends Command
{
    protected $signature = 'cms:backup {--perf : Also write perf_before.txt timing home}';

    protected $description = 'Dump MySQL to storage/backups and write BACKUP_MANIFEST.txt';

    public function handle(): int
    {
        $dir = storage_path('backups');
        File::ensureDirectoryExists($dir);

        $ts = now()->format('Ymd_His');
        $file = $dir.'/backup_'.$ts.'.sql';

        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', 3306);
        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');

        $cmd = sprintf(
            'MYSQL_PWD=%s mysqldump -h%s -P%s -u%s %s > %s 2>%s',
            escapeshellarg($pass),
            escapeshellarg($host),
            escapeshellarg((string) $port),
            escapeshellarg($user),
            escapeshellarg($db),
            escapeshellarg($file),
            escapeshellarg($dir.'/mysqldump_err.log')
        );

        exec($cmd, $out, $code);

        if ($code !== 0 || ! File::exists($file) || File::size($file) < 100) {
            $this->warn('mysqldump failed or empty; falling back to PHP export.');
            $this->phpExport($file);
        }

        if (! File::exists($file) || File::size($file) < 50) {
            $this->error('Backup failed.');

            return self::FAILURE;
        }

        $size = File::size($file);
        $md5 = md5_file($file);
        $sha = hash_file('sha256', $file);
        $tables = substr_count(File::get($file), 'CREATE TABLE');

        $manifest = implode("\n", [
            'timestamp: '.$ts,
            'filepath: '.$file,
            'size_bytes: '.$size,
            'md5: '.$md5,
            'sha256: '.$sha,
            'tables_count: '.$tables,
            'created_at: '.now()->toIso8601String(),
        ])."\n";

        File::put($dir.'/BACKUP_MANIFEST.txt', $manifest);
        $this->info('Backup OK: '.$file.' ('.$size.' bytes, tables='.$tables.')');

        if ($this->option('perf')) {
            $this->measurePerf($dir.'/perf_before.txt');
        }

        return self::SUCCESS;
    }

    protected function phpExport(string $file): void
    {
        $tables = collect(DB::select('SHOW TABLES'))->map(fn ($r) => array_values((array) $r)[0]);
        $fh = fopen($file, 'w');
        fwrite($fh, "-- PHP fallback dump\nSET FOREIGN_KEY_CHECKS=0;\n\n");

        foreach ($tables as $table) {
            $create = DB::select('SHOW CREATE TABLE `'.$table.'`');
            $sql = array_values((array) $create[0])[1] ?? null;
            if ($sql) {
                fwrite($fh, "DROP TABLE IF EXISTS `{$table}`;\n{$sql};\n\n");
            }
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $vals = collect((array) $row)->map(function ($v) {
                    if ($v === null) {
                        return 'NULL';
                    }

                    return "'".str_replace(["\\", "'"], ["\\\\", "\\'"], (string) $v)."'";
                })->implode(', ');
                fwrite($fh, "INSERT INTO `{$table}` VALUES ({$vals});\n");
            }
            fwrite($fh, "\n");
        }

        fwrite($fh, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($fh);
    }

    protected function measurePerf(string $path): void
    {
        $url = rtrim(config('app.url'), '/').'/';
        $start = microtime(true);
        $queries = 0;
        DB::listen(function () use (&$queries) {
            $queries++;
        });

        try {
            $response = Http::timeout(30)->get($url);
            $status = $response->status();
        } catch (\Throwable $e) {
            $status = 'error: '.$e->getMessage();
        }

        $elapsed = round((microtime(true) - $start) * 1000, 2);
        File::put($path, "url: {$url}\nstatus: {$status}\ntime_ms: {$elapsed}\nqueries_note: local DB listen may be 0 for remote HTTP\nmeasured_at: ".now()->toIso8601String()."\n");
        $this->info("Perf written: {$elapsed}ms");
    }
}
