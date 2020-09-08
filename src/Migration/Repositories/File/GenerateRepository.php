<?php

namespace ZnCore\Db\Migration\Repositories\File;

use ZnCore\Db\Migration\Entities\GenerateEntity;
use ZnCore\Db\Migration\Interfaces\Repositories\GenerateRepositoryInterface;

class GenerateRepository implements GenerateRepositoryInterface
{

    protected $tableName = 'migration_generate';

    public function getEntityClass(): string
    {
        return GenerateEntity::class;
    }
}
