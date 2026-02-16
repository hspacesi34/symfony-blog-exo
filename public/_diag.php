<?php

header('Content-Type: application/json; charset=utf-8');

$env = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'prod';
$debug = filter_var($_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? '0', FILTER_VALIDATE_BOOL);

$checks = [
    'php_version' => PHP_VERSION,
    'php_version_ok_for_project' => version_compare(PHP_VERSION, '8.2.0', '>='),
    'sapi' => PHP_SAPI,
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? null,
    'script_filename' => $_SERVER['SCRIPT_FILENAME'] ?? null,
    'cwd' => getcwd(),
    'app_env_runtime' => $_SERVER['APP_ENV'] ?? getenv('APP_ENV') ?: null,
    'app_debug_runtime' => $_SERVER['APP_DEBUG'] ?? getenv('APP_DEBUG') ?: null,
    'app_env_effective' => $env,
    'app_debug_effective' => $debug,
    'required_extensions' => [
        'ctype' => extension_loaded('ctype'),
        'iconv' => extension_loaded('iconv'),
        'mbstring' => extension_loaded('mbstring'),
        'intl' => extension_loaded('intl'),
        'pdo_mysql' => extension_loaded('pdo_mysql'),
        'openssl' => extension_loaded('openssl'),
    ],
    'paths' => [
        'project_root' => dirname(__DIR__),
        'public_index_exists' => is_file(__DIR__ . '/index.php'),
        'autoload_runtime_exists' => is_file(dirname(__DIR__) . '/vendor/autoload_runtime.php'),
        'dotenv_local_php_exists' => is_file(dirname(__DIR__) . '/.env.local.php'),
        'var_exists' => is_dir(dirname(__DIR__) . '/var'),
        'var_cache_prod_exists' => is_dir(dirname(__DIR__) . '/var/cache/prod'),
        'var_log_exists' => is_dir(dirname(__DIR__) . '/var/log'),
        'var_sessions_exists' => is_dir(dirname(__DIR__) . '/var/sessions'),
    ],
    'writable' => [
        'var' => is_writable(dirname(__DIR__) . '/var'),
        'var_cache' => is_writable(dirname(__DIR__) . '/var/cache'),
        'var_cache_prod' => is_writable(dirname(__DIR__) . '/var/cache/prod'),
        'var_log' => is_writable(dirname(__DIR__) . '/var/log'),
        'var_sessions' => is_writable(dirname(__DIR__) . '/var/sessions'),
    ],
    'symfony_boot' => [
        'ok' => false,
    ],
    'symfony_request' => [
        'ok' => false,
    ],
];

try {
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $kernel = new \App\Kernel($env, $debug);
    $kernel->boot();
    $checks['symfony_boot'] = [
        'ok' => true,
    ];

    $request = \Symfony\Component\HttpFoundation\Request::create('/');
    $response = $kernel->handle($request);
    $checks['symfony_request'] = [
        'ok' => true,
        'status_code' => $response->getStatusCode(),
    ];

    $kernel->terminate($request, $response);
    $kernel->shutdown();
} catch (\Throwable $exception) {
    if ($checks['symfony_boot']['ok'] === false) {
        $checks['symfony_boot'] = [
            'ok' => false,
            'exception_class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];
    } else {
        $checks['symfony_request'] = [
            'ok' => false,
            'exception_class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];
    }
}

echo json_encode($checks, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
