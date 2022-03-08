<?php
namespace App\Tests\Service;

use App\Services\HttpLogCounterService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HttpLogCounterServiceTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /** @test */
    public function full_fields_logs_can_be_counted()
    {
        $fileName = 'storage/logs.log';
        $fields = [
          'serviceNames' => ['USER-SERVICE','INVOICE-SERVICE'],
          'startDate' => '17/Aug/2018:09:21:53 +0000',
          'endDate' => '18/Aug/2018:10:33:59 +0000',
          'statusCode' => 201
        ];
        
        $httpLogCounter = new HttpLogCounterService($fields, $fileName);

        $count = $httpLogCounter->count();

        $this->assertIsInt($count);
        $this->assertEquals(15, $count);
    }

    /** @test */
    public function missing_fields_logs_can_be_counted()
    {
        $fileName = 'storage/logs.log';
        $fields = [
              'serviceNames' => ['INVOICE-SERVICE']
            ];
            
        $httpLogCounter = new HttpLogCounterService($fields, $fileName);
    
        $count = $httpLogCounter->count();
    
        $this->assertIsInt($count);
        $this->assertEquals(6, $count);
    }
}
