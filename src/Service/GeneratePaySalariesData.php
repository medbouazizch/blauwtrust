<?php
namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
class GeneratePaySalariesData
{
    const PRIME = 'prime';
    const SALAIRE = 'salaire';
    
    public function __construct(private PaySalariesService $paySalariesService)
    {
    }

    public function getData(): array
    {
        $month = date('m');
        $headers = [['Month name','Salary payment date','Bonus payment date']];
        $rows = [];
        
        for ($m = $month; $m <= 12; $m++) {
          $rows[] = [date("F", mktime(0, 0, 0, $m, 10)) ,$this->paySalariesService->getPaySalariesDateByType($m, $this::SALAIRE)->format('d/m/Y'), $this->paySalariesService->getPaySalariesDateByType($m + 1, $this::PRIME)->format('d/m/Y')];
        }
        return array_merge($headers,$rows);
    }

    public function generatePaySalariesFile(string $fileName): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $writer = new Writer\Csv($spreadsheet);

        $rows = $this->getData();
        $sheet->fromArray($rows,'A1');
        $response =  new StreamedResponse(
            function () use ($writer,$fileName) {
                $writer->save('public/paySalariesData/'.$fileName.'.csv');
            }
        );

        return $response->send();
    }
}