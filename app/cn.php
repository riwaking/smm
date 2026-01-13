<?php
define('PATH', realpath('.'));
define('SUBFOLDER', false);
define('URL', 'https://' . ($_SERVER['HTTP_HOST'] ?? getenv('REPLIT_DEV_DOMAIN') ?: 'localhost:5000'));
define('STYLESHEETS_URL', '//' . ($_SERVER['HTTP_HOST'] ?? getenv('REPLIT_DEV_DOMAIN') ?: 'localhost:5000'));
date_default_timezone_set('UTC');

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);

$database_url = getenv('DATABASE_URL');
$db_config = [];

if ($database_url) {
    $parsed = parse_url($database_url);
    $db_config = [
        'driver'  => 'pgsql',
        'host'    => $parsed['host'] ?? 'localhost',
        'port'    => $parsed['port'] ?? 5432,
        'name'    => ltrim($parsed['path'] ?? '', '/'),
        'user'    => $parsed['user'] ?? '',
        'pass'    => $parsed['pass'] ?? '',
    ];
} else {
    $db_config = [
        'driver'  => 'pgsql',
        'host'    => getenv('PGHOST') ?: 'localhost',
        'port'    => getenv('PGPORT') ?: 5432,
        'name'    => getenv('PGDATABASE') ?: 'postgres',
        'user'    => getenv('PGUSER') ?: 'postgres',
        'pass'    => getenv('PGPASSWORD') ?: '',
    ];
}

return [
    'db' => $db_config
];
?>
