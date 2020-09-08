<?php

namespace ZnCore\Db\Migration\Base;

use Illuminate\Database\Schema\Builder;
use ZnCore\Db\Db\Traits\TableNameTrait;

abstract class BaseMigration
{

    use TableNameTrait;

    protected function runSqlQuery(Builder $schema, $sql)
    {
        $connection = $schema->getConnection();
        $rawSql = $connection->raw($sql);
        $connection->select($rawSql);
    }

}