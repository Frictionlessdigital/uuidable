<?php

namespace Fls\Uuidable\Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PHPUnit\Framework\Attributes\PreCondition;

abstract class TestCase extends OrchestraTestCase
{
    #[PreCondition()]
    protected function prepareTests(): void
    {
        $this->setUpDatabase();
    }

    /**
     * Set up the environment.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        tap($app['config'], function ($config) {
            $config->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
            $config->set('database.default', 'sqlite');
            $config->set('database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        });
    }

    protected function setUpDatabase()
    {
        $this->createTables([
            'alternative_dummy_models' => 'diuu',
            'dummy_models' => 'uuid',
        ]);
    }

    protected function createTables(array $tableNames)
    {
        collect($tableNames)->each(function (string $field, string $tableName) {
            Schema::create($tableName, function (Blueprint $table) use ($field) {
                $table->id();
                $table->uuid($field);
                $table->timestamps();
                $table->softDeletes();
            });
        });
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class() extends Handler
        {
            public function __construct() {}

            public function report(\Exception $e) {}

            public function render($request, \Exception $exception)
            {
                throw $exception;
            }
        });
    }
}
