<?php
namespace App\Service;
use DateTime;

class PaySalariesService
{
    const PRIME = 'prime';
    const SALAIRE = 'salaire';
    
    function getPaySalariesDateByType(int $m,string $type): DateTime
    {
    $day = '15/'.$m.'/'. date('Y') ;
    $date = DateTime::createFromFormat('d/m/Y', $day);
    $date = $this::SALAIRE === $type  ? $date->modify('last day of this month') : $date;

    if (true === $this->dayIsWeekEnd($date)){
        return $this::PRIME === $type ? $date->modify('next wednesday') : $date->modify('last Friday');
    }
    return	$date;
    }

    function dayIsWeekEnd(DateTime $day): bool
    {
    $weekend = array('Saturday','Sunday');
    return in_array($day->format('l'),$weekend);
    }
}