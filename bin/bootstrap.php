<?php

use Symfony\Component\Console\Application;
use ZnCore\Db\Db\Capsule\Manager;

/**
 * @var Application $application
 */

$eloquentConfigFile = $_ENV['ELOQUENT_CONFIG_FILE'];
$capsule = new Manager(null, $eloquentConfigFile);

// --- Fixture ---

use ZnCore\Db\Fixture\Commands\ImportCommand;
use ZnCore\Db\Fixture\Commands\ExportCommand;
use ZnCore\Db\Fixture\Services\FixtureService;
use ZnCore\Db\Fixture\Repositories\DbRepository;
use ZnCore\Db\Fixture\Repositories\FileRepository;

// создаем сервис "Фикстуры" с внедрением двух репозиториев
$fixtureService = new FixtureService(new DbRepository($capsule), new FileRepository($eloquentConfigFile));

// создаем и объявляем команду "Экспорт фикстур"
$exportCommand = new ExportCommand(ExportCommand::getDefaultName(), $fixtureService);
$application->add($exportCommand);

// создаем и объявляем команду "Импорт фикстур"
$importCommand = new ImportCommand(ImportCommand::getDefaultName(), $fixtureService);
$application->add($importCommand);

// --- Migration ---

use ZnCore\Db\Migration\Services\MigrationService;
use ZnCore\Db\Migration\Services\GenerateService;
use ZnCore\Db\Migration\Repositories\File\GenerateRepository;
use ZnCore\Db\Migration\Repositories\HistoryRepository;
use ZnCore\Db\Migration\Repositories\SourceRepository;
use ZnCore\Db\Migration\Commands\UpCommand;
use ZnCore\Db\Migration\Commands\DownCommand;
use ZnCore\Db\Migration\Commands\GenerateCommand;

$migrationService = new MigrationService(new SourceRepository($eloquentConfigFile), new HistoryRepository($capsule));
$generateService = new GenerateService(new GenerateRepository);

// создаем и объявляем команду "UP"
$upCommand = new UpCommand(UpCommand::getDefaultName(), $migrationService);
$application->add($upCommand);

// создаем и объявляем команду "Down"
$downCommand = new DownCommand(DownCommand::getDefaultName(), $migrationService);
$application->add($downCommand);

// создаем и объявляем команду "Generate"
$downCommand = new GenerateCommand(GenerateCommand::getDefaultName(), $generateService);
$application->add($downCommand);

// --- Db ---

use ZnCore\Db\Db\Commands\DeleteAllTablesCommand;

// создаем и объявляем команду "deleteAllTables"
$deleteAllTablesCommand = new DeleteAllTablesCommand(DeleteAllTablesCommand::getDefaultName(), $fixtureService);
$application->add($deleteAllTablesCommand);
