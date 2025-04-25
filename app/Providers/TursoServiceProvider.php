<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use PDO;

class TursoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('db.connector.turso', function () {
            return new class {
                public function connect(array $config)
                {
                    $dsn = str_replace('libsql://', 'sqlite:', $config['url']);
                    $options = [
                        PDO::ATTR_CASE => PDO::CASE_NATURAL,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
                        PDO::ATTR_STRINGIFY_FETCHES => false,
                    ];

                    try {
                        return new PDO($dsn, null, null, $options);
                    } catch (\Exception $e) {
                        throw new \Exception("Could not connect to Turso database: " . $e->getMessage());
                    }
                }
            };
        });

        Connection::resolverFor('turso', function ($connection, $database, $prefix, $config) {
            return new Connection($connection, $database, $prefix, $config);
        });
    }

    public function boot()
    {
        //
    }
} 