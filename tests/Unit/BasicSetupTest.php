<?php

namespace MedianetDev\LaravelAuthApi\Tests\Unit;

use MedianetDev\LaravelAuthApi\Tests\TestCase;

class BasicSetupTest extends TestCase
{
    /** @test */
    public function check_if_tables_migrated()
    {
        /** @var \Illuminate\Support\Facades\DB $database */
        $database = app('db');

        // // get the parking_id and operator_id ready to be sent to entervo
        $result = $database->select('SELECT * FROM migrations WHERE migration = "2019_10_11_000001_create_linked_social_accounts_table";');

        $this->assertNotEmpty($result);
    }
}
