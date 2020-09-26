<?php

namespace ZnCore\Db\Fixture\Libs;

use ZnCore\Db\Fixture\Helpers\FixtureFactoryHelper;

abstract class DataWithCollectionFixture extends DataFixture
{

    abstract public function count(): int;

    abstract public function collection(): array;

    abstract public function callback($index, FixtureFactoryHelper $fixtureFactory): array;

    public function load()
    {
        $collection = $this->collection();
        $fixture = new FixtureFactoryHelper;
        $fixture->setCount($this->count());
        $fixture->setStartIndex(count($collection) + 1);
        $fixture->setCallback([$this, 'callback']);
        return array_merge($collection, $fixture->generateCollection());
    }
}
