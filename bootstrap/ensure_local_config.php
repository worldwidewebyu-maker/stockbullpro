<?php

/**
 * PHPUnit uses sqlite :memory: for tests. If config:cache runs while those
 * env vars are active, Laravel keeps serving the test database locally.
 */
$configCache = __DIR__ . '/cache/config.php';

if (! is_file($configCache)) {
    return;
}

$configuration = @include $configCache;

if (! is_array($configuration)) {
    return;
}

$default = $configuration['database']['default'] ?? null;
$database = $configuration['database']['connections'][$default]['database'] ?? null;

if ($default === 'sqlite' && $database === ':memory:') {
    @unlink($configCache);
}
