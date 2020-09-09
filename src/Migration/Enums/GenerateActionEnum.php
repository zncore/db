<?php

namespace ZnCore\Db\Migration\Enums;

use ZnCore\Domain\Base\BaseEnum;

class GenerateActionEnum extends BaseEnum
{

    const CREATE_TABLE = 'create table';
    const ADD_COLUMN = 'add column';

}