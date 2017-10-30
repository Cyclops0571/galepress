<?php

$dbName = "admin_galepress";
$dbUserName = "admin_gpuser";
$dbPassword = "tu4ydebyr";
$dbNameTicket = 'galepress_ticket';
$dbUsernameTicket = 'galepress_ticket';
$dbPasswordTicket = ':Ekt4eca';

if (Laravel\Request::env() == ENV_LOCAL) {
    $dbName = "galepress";
    $dbUserName = "homestead";
    $dbPassword = "secret";
    $dbNameTicket = 'galepress_ticket';
    $dbUsernameTicket = 'root';
    $dbPasswordTicket = '';
}

return array(
    'profile' => true,
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'mysql',
    'connections' => array(
        'sqlite' => array(
            'driver' => 'sqlite',
            'database' => 'application',
            'prefix' => '',
        ),
        'mysql' => array(
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => $dbName,
            'username' => $dbUserName,
            'password' => $dbPassword,
            'charset' => 'utf8',
            'prefix' => '',
        ),
        'galepress_ticket' => array(
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => $dbNameTicket,
            'username' => $dbUsernameTicket,
            'password' => $dbPasswordTicket,
            'charset' => 'utf8',
            'prefix' => '',
        ),
        'pgsql' => array(
            'driver' => 'pgsql',
            'host' => '127.0.0.1',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ),
        'sqlsrv' => array(
            'driver' => 'sqlsrv',
            'host' => '127.0.0.1',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'prefix' => '',
        ),
    ),
    'redis' => array(

        'default' => array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 0
        ),
    ),
);
