<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ExportPaySalariesDataCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:export-pay-salaries-data');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'file_name' => 'blauwtrust',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('File generated successfully', $output);
        $this->assertStringContainsString('Path to file : public/paySalariesData/', $output);
    }
}