<?php

namespace ZnCore\Db\Db\Enums;

use ZnCore\Base\Domain\Base\BaseEnum;

class DbDriverEnum extends BaseEnum
{

    const MYSQL = 'mysql';
    const PGSQL = 'pgsql';
    const SQLITE = 'sqlite';
    const SQLSRV = 'sqlsrv';

}