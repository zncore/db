# Развертывание базы данных

Зайти в папку `bin`:

    cd vendor/zncore/db/bin

Выполнить миграции:

    php console db:migrate:up --withConfirm=0

Выполнить иморт демо-данных в БД для разработки:

    php console db:fixture:import --withConfirm=0

Команды выполнятся без подтверждений.
