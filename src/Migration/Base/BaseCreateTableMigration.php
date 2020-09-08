<?php

namespace ZnCore\Db\Migration\Base;

use Illuminate\Database\Schema\Builder;
use ZnCore\Db\Db\Enums\DbDriverEnum;
use ZnCore\Db\Db\Helpers\Manager;

abstract class BaseCreateTableMigration extends BaseMigration
{

    protected $tableComment = '';
    protected $capsule;

    abstract public function tableSchema();

    public function __construct(Manager $capsule)
    {
        $this->capsule = $capsule;
    }

    public function getCapsule(): Manager
    {
        return $this->capsule;
    }

    public function up(Builder $schema)
    {
        $schema->create($this->tableNameAlias(), $this->tableSchema());
        if ($this->tableComment) {
            $this->addTableComment($schema);
        }
    }

    public function down(Builder $schema)
    {
        $schema->dropIfExists($this->tableNameAlias());
    }

    private function addTableComment(Builder $schema)
    {
        $connection = $schema->getConnection();
        $driver = $connection->getConfig('driver');
        $table = $this->tableNameAlias();
        $tableComment = $this->tableComment;
        $sql = '';
        if ($driver == DbDriverEnum::MYSQL) {
            $sql = "ALTER TABLE {$table} COMMENT = '{$tableComment}';";
        }
        if ($driver == DbDriverEnum::PGSQL) {
            $sql = "COMMENT ON TABLE {$table} IS '{$tableComment}';";
        }
        if ($sql) {
            $this->runSqlQuery($schema, $sql);
        }
    }

}