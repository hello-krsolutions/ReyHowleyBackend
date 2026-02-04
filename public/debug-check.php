<?php
/**
 * Debug Script - Helps identify early Laravel bootstrap errors
 * Access via: https://reyhowley.com/debug-check.php
 * DELETE THIS FILE AFTER DEBUGGING
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Check</h1>";
echo "<pre>";

// Check PHP version
echo "PHP Version: " . phpversion() . "\n\n";

// Check if required extensions are loaded
$required_extensions = ['pdo_mysql', 'mbstring', 'json', 'openssl', 'tokenizer', 'xml', 'ctype', 'bcmath', 'gd'];
echo "Extension Check:\n";
foreach ($required_extensions as $ext) {
    echo "  - $ext: " . (extension_loaded($ext) ? "OK" : "MISSING") . "\n";
}
echo "\n";

// Check .env file
echo ".env file exists: " . (file_exists(__DIR__ . '/../.env') ? 'Yes' : 'No') . "\n";
if (file_exists(__DIR__ . '/../.env')) {
    $env_content = file_get_contents(__DIR__ . '/../.env');
    preg_match('/APP_DEBUG=(.*)/m', $env_content, $matches);
    echo "APP_DEBUG value: " . ($matches[1] ?? 'NOT FOUND') . "\n";
    preg_match('/APP_KEY=(.*)/m', $env_content, $matches);
    echo "APP_KEY set: " . (!empty($matches[1]) ? 'Yes' : 'No') . "\n";
    preg_match('/DB_HOST=(.*)/m', $env_content, $matches);
    echo "DB_HOST: " . ($matches[1] ?? 'NOT FOUND') . "\n";
    preg_match('/DB_DATABASE=(.*)/m', $env_content, $matches);
    echo "DB_DATABASE: " . ($matches[1] ?? 'NOT FOUND') . "\n";
}
echo "\n";

// Try to load Laravel and catch any errors
echo "Attempting Laravel Bootstrap...\n";
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "  - Autoloader: OK\n";

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "  - Bootstrap: OK\n";

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "  - HTTP Kernel: OK\n";

    // Try database connection
    try {
        $app->make('db')->connection()->getPdo();
        echo "  - Database Connection: OK\n";
    } catch (Exception $e) {
        echo "  - Database Connection: FAILED\n";
        echo "    Error: " . $e->getMessage() . "\n";
    }

    // Check modules table
    try {
        $modules = \App\Models\Module::active()->get();
        echo "  - Modules Table: OK (Found " . $modules->count() . " active modules)\n";
    } catch (Exception $e) {
        echo "  - Modules Table: FAILED\n";
        echo "    Error: " . $e->getMessage() . "\n";
    }

} catch (Throwable $e) {
    echo "\n*** LARAVEL BOOTSTRAP ERROR ***\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "\nStack Trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
echo "<p>DELETE THIS FILE AFTER DEBUGGING!</p>";
