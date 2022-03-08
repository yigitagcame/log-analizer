<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnalyticsControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function the_count_endpoint_works_well_with_valid_parameters()
    {
        $validInputs = $this->validInputs();
        
        $client = static::createClient();

        $client->request('GET', '/count', $validInputs);

        $this->assertResponseIsSuccessful();

        $this->assertArrayHasKey('counter', json_decode($client->getResponse()->getContent(), true));
    }

    /**
     * @test
     */
    public function the_service_names_field_can_validate_properly()
    {
        $validInputs = $this->validInputs();
        $validInputs['serviceNames'] = 'USER-SERVICE';

        $client = static::createClient();
        $client->request('GET', '/count', $validInputs);

        $this->assertResponseStatusCodeSame(400);
    }

    protected function validInputs()
    {
        return [
          'serviceNames' => ['USER-SERVICE','INVOCE-SERVICE'],
          'startDate' => '18/Aug/2018:10:33:59 +0000',
          'endDate' => '18/Aug/2018:10:33:59 +0000',
          'statusCode' => 201
        ];
    }
}
