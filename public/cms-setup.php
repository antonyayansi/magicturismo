<?php

/**
 * One-time CMS setup. Delete this file after it succeeds.
 */
$expected = 'mjsetup2026ok';
$key = $_GET['key'] ?? '';

if (!hash_equals($expected, $key)) {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}

$lock = __DIR__.'/../storage/app/cms-setup.lock';
if (is_file($lock)) {
    echo 'Ya se ejecutó. Elimina public/cms-setup.php';
    exit;
}

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain; charset=utf-8');

echo "PHP ".PHP_VERSION."\n\n";
echo "=== migrate --force ===\n";
$kernel->call('migrate', ['--force' => true]);
echo $kernel->output();

echo "\n=== db:seed CmsContentSeeder ===\n";
$kernel->call('db:seed', ['--class' => 'CmsContentSeeder', '--force' => true]);
echo $kernel->output();

echo "\n=== cache:clear ===\n";
$kernel->call('cache:clear');
echo $kernel->output();

file_put_contents($lock, date('c').' PHP '.PHP_VERSION."\n");
@unlink(__FILE__);

echo "\nListo. El instalador se eliminó solo.\n";
