<?php

namespace ZnCore\Db\Fixture\Libs;

interface FixtureInterface
{

    public function load();
    public function unload();
    public function deps();

}
