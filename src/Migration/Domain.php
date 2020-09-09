<?php

namespace ZnCore\Db\Migration;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'migration';
    }


}

