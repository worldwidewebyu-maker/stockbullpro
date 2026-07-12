<?php

$configCache = __DIR__ . '/cache/config.php';

if (! is_file($configCache)) {
    return;
}

$envFile = dirname(__DIR__) . '/.env';

if (is_file($envFile)) {
    $envContents = file_get_contents($envFile);

    if (preg_match('/^APP_ENV\s*=\s*([^\s#]+)/m', $envContents, $match)
        && trim($match[1], "\"'") === 'local') {
        @unlink($configCache);

        return;
    }
}

$configuration = @include $configCache;

if (! is_array($configuration)) {
    return;
}

$default = $configuration['database']['default'] ?? null;
$database = $configuration['database']['connections'][$default]['database'] ?? null;

$isPoisonedTestConfig = ($default === 'sqlite' && $database === ':memory:')
    || $database === 'stockbullpro_test';

if ($isPoisonedTestConfig) {
    @unlink($configCache);
}
