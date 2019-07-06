<?php
/**
 * Created by PhpStorm.
 * User: Banji
 * Date: 06/07/2019
 * Time: 17:27
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends  WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}