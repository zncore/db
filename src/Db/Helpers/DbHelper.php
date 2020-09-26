<?php

namespace ZnCore\Db\Db\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Env\DotEnvHelper;
use ZnCore\Db\Db\Enums\DbDriverEnum;

// todo: перенести в zncore/db
class DbHelper
{

    static function generateRawTableName(string $tableName): string {
        $items = explode('.', $tableName);
        return '"' . implode('"."', $items) . '"';
    }

    static function isHasSchemaInTableName(string $tableName): bool {
        return strpos($tableName, '.') !== false;
    }

    static function extractSchemaFormTableName(string $tableName): string {
        $tableName = str_replace('"', '', $tableName);
        return explode('.', $tableName)[0];
    }

    static function buildConfigForPdo(array $config): array
    {
        if ($config['driver'] == DbDriverEnum::SQLITE) {
            return [
                'dsn' => 'sqlite:' . $config['dbname'],
            ];
        } else {
            $dsnArray[] = "{$config['driver']}:host={$config['host']}";
            foreach ($config as $configName => $configValue) {
                if (!empty($configValue) && !in_array($configName, ['driver', 'host', 'username', 'password'])) {
                    $dsnArray[] = "$configName=$configValue";
                }
            }
            return [
                "username" => $config['username'] ?? '',
                "password" => $config['password'] ?? '',
                "dsn" => implode(';', $dsnArray),
            ];
        }
    }

    static function getConfigFromEnv()
    {
        if (!empty($_ENV['DATABASE_URL'])) {
            $connections['default'] = DbHelper::parseDsn($_ENV['DATABASE_URL']);
        } else {
            $config = DotEnvHelper::get('db');
            $isFlatConfig = !is_array(ArrayHelper::first($config));
            if ($isFlatConfig) {
                $connections['default'] = $config;
            } else {
                $connections = $config;
            }
        }
        foreach ($connections as &$connection) {
            $connection = self::prepareConfig($connection);
        }
        return $connections;
    }

    private static function prepareConfig($connection)
    {

        $connection['driver'] = $connection['driver'] ?? $connection['connection'];
        $connection['dbname'] = $connection['dbname'] ?? $connection['database'];

        $connection['host'] = $connection['host'] ?? '127.0.0.1';
        $connection['driver'] = $connection['driver'] ?? 'mysql';

        if (!empty($connection['dbname'])) {
            $connection['dbname'] = rtrim($connection['dbname'], '/');
        }

        unset($connection['database']);
        unset($connection['connection']);

        return $connection;
    }

    static function parseDsn($dsn)
    {
        $dsnConfig = parse_url($dsn);
        $dsnConfig = array_map('rawurldecode', $dsnConfig);
        $connectionCofig = [
            'driver' => ArrayHelper::getValue($dsnConfig, 'scheme'),
            'host' => ArrayHelper::getValue($dsnConfig, 'host', '127.0.0.1'),
            'dbname' => trim(ArrayHelper::getValue($dsnConfig, 'path'), '/'),
            'username' => ArrayHelper::getValue($dsnConfig, 'user'),
            'password' => ArrayHelper::getValue($dsnConfig, 'pass'),
        ];
        return $connectionCofig;
    }

}