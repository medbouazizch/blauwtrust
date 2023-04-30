<?php
namespace App\Tests\Unit\Export;

use App\Service\PaySalariesService;
use PHPUnit\Framework\TestCase;
use DateTime;

class PaySalariesServiceTest extends TestCase
{
    private function getDateFromString(string $date): DateTime
    {
        return DateTime::createFromFormat('d/m/Y', $date)->setTime(0,0);
    }

    public function testDayIsWeekEnd(
    )
    {
        $paySalariesService = new PaySalariesService();
        $this->assertEquals(false,$paySalariesService->dayIsWeekEnd($this->getDateFromString('28/04/2023')));
        $this->assertEquals(true,$paySalariesService->dayIsWeekEnd($this->getDateFromString('30/04/2023')));
    }

    public function testGetPaySalariesDate(
    )
    {
        $paySalariesService = new PaySalariesService();
        $paySalariesDate = $this->getDateFromString('28/04/2023');
        $payPrimeDate = $this->getDateFromString('19/04/2023');

        $this->assertEquals($paySalariesDate, $paySalariesService->getPaySalariesDateByType(4, 'salaire'));
        $this->assertEquals($payPrimeDate, $paySalariesService->getPaySalariesDateByType(4, 'prime'));
    }

}
