<?php

namespace ZnCore\Db\Db\Facades;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Db\Db\Helpers\ConfigHelper;
use ZnCore\Db\Db\Helpers\DbHelper;

class DoctrineFacade
{

    public static function createConnection(): Connection
    {
        if(isset($_ENV['DATABASE_URL'])) {
            $dbconfig = ConfigHelper::parseDsn($_ENV['DATABASE_URL']);
        } else {
            $dbconfig = DotEnv::get('db');
        }
        $connectionConfig = [
            'dbname' => $dbconfig['database'] ?? $dbconfig['dbname'],
            'user' => $dbconfig['username'],
            'password' => $dbconfig['password'],
            'host' => $dbconfig['host'] ?? '127.0.0.1',
            'driver' => 'pdo_' . $dbconfig['driver'] ?? 'mysql',
            'charset' => 'utf8',
            'driverOptions' => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ],
        ];
        $config = new Configuration;
        $connection = DriverManager::getConnection($connectionConfig, $config);
        return $connection;
    }

}