<?php

namespace Fls\Uuidable\Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
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

    /**
     * @return void
     */
    protected function setUpDatabase()
    {
        $this->createTables([
            'alternative_dummy_models' => 'diuu',
            'dummy_models' => 'uuid',
        ]);
    }

    /**
     * @param array $tableNames
     * @return void
     */
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

    /**
     * @return void
     */
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class() extends Handler {
            public function __construct()
            {
            }

            public function report(\Exception $e)
            {
            }

            public function render($request, \Exception $exception)
            {
                throw $exception;
            }
        });
    }
}
