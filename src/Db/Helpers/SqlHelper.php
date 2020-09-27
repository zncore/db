<?php

namespace ZnCore\Db\Db\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Db\Db\Enums\DbDriverEnum;

class SqlHelper
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

}