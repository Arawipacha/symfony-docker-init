<?php

declare(strict_types=1);

namespace App\Tests\Projects\List\Infrastructure\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetProjectsListerControllerTest extends WebTestCase
{
    public function test_should_return_list_projects_controller(): void
    {
        $client = static::createClient();
        $client->request('GET', "/projects-lister");

        $response = $client->getResponse();
        $content = $response->getContent();
        self::assertSame(200, $response->getStatusCode());
        self::assertJson($content);

        $data = json_decode($content, true);
        dd($data);
        //self::assertArrayHasKey('id', $data[0]);
        //self::assertArrayHasKey('name', $data[0]);


        //self::assertEquals(1, $data[0]['id']);

    }
}
