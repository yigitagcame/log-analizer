<?php
namespace App\Tests\Service;

use App\Services\FileReaderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FileReaderServiceTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /** @test */
    public function a_file_can_be_read()
    {
        $fileName = 'storage/logs.log';
        $file = new FileReaderService($fileName);

        $this->assertIsString($file->read());
        $this->assertIsArray($file->readByLine());
    }
}
