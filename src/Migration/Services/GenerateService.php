<?php

namespace ZnCore\Db\Migration\Services;

use ZnCore\Domain\Base\BaseService;
use ZnCore\Db\Migration\Interfaces\Repositories\GenerateRepositoryInterface;
use ZnCore\Db\Migration\Interfaces\Services\GenerateServiceInterface;
use ZnCore\Db\Migration\Scenarios\Render\CreateTableRender;
use ZnCore\Base\Helpers\ClassHelper;

class GenerateService extends BaseService implements GenerateServiceInterface
{

    public function __construct(GenerateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function generate(object $dto)
    {


        //if($dto->type == GenerateActionEnum::CREATE_TABLE) {
        $class = CreateTableRender::class;
        //}

        //dd($dto);
        $dto->attributes = [];

        $dto->attributes = [];

        $scenarioInstance = new $class;
        $scenarioParams = [
            'dto' => $dto,
        ];
        ClassHelper::configure($scenarioInstance, $scenarioParams);
        //$scenarioInstance->init();
        $scenarioInstance->run();

        //dd($dto);
    }

}

