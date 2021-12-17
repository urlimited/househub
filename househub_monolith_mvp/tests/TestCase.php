<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\Traits\CanConfigureMigrationCommands;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use CanConfigureMigrationCommands {
        CanConfigureMigrationCommands::migrateFreshUsing as protected parentMigrateFreshUsing;
    }

    protected bool $seed = true;

    protected function migrateFreshUsing(){
        return [
            ...$this->parentMigrateFreshUsing(),
            '--path' => './database/migrations/mvp'
        ];
    }
}
