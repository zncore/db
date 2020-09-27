<?php

namespace ZnCore\Db\Migration\Interfaces;

use Illuminate\Database\Schema\Builder;

interface MigrationInterface
{

    public function up(Builder $schema);

    public function down(Builder $schema);
}
