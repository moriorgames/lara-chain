<?php

namespace Tests\Feature\TransactionsBoundedContext\Application;

use Tests\TestCase;

class GetAllTransactionsTest extends TestCase
{
    public function test_route_get_all_transaction_from_database_source()
    {
        $source = 'db';
        $response = $this->get('/transactions/' . $source)->decodeResponseJson();

        $this->assertEquals($source, $response->json('source'));
    }

    public function test_route_get_all_transaction_from_csv_source()
    {
        $source = 'csv';
        $response = $this->get('/transactions/' . $source)->decodeResponseJson();

        $this->assertEquals($source, $response->json('source'));
    }
}
