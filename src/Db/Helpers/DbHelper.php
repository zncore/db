<?php

namespace ZnCore\Db\Db\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Db\Db\Enums\DbDriverEnum;

class DbHelper
{

    public static function encodeDirection($direction)
    {
        $directions = [
            SORT_ASC => 'asc',
            SORT_DESC => 'desc',
        ];
        return $directions[$direction];
    }

}