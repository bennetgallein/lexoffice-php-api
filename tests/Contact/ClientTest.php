<?php

namespace Clicksports\LexOffice\Tests\Contact;

use Clicksports\LexOffice\Contact\Client;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient {
    public function testGenerateUrl() {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['generateUrl']
        );

        $this->assertEquals(
            'contacts?page=0&size=100&direction=ASC&property=name',
            $stub->generateUrl(0)
        );
    }

    public function testGenerateUrlWithFilters() {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['generateUrl', 'setFilters']
        );

        $this->assertEquals(
            'contacts?page=0&size=100&direction=ASC&property=name&name=Bennet',
            $stub->setFilters(['name' => "Bennet"])->generateUrl(0)
        );
    }
}
