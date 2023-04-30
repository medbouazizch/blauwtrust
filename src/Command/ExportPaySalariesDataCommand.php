<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Service\GeneratePaySalariesData;

#[AsCommand(
    name: 'app:export-pay-salaries-data',
    description: 'Export Pay Salaries Data',
    aliases: ['app:export-pay-salaries-data'],
    hidden: false
)]
class ExportPaySalariesDataCommand extends Command
{

    public function __construct(private GeneratePaySalariesData $generatePaySalariesData)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file_name', InputArgument::REQUIRED, 'File Name?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = $input->getArgument('file_name');
        $output->writeln(['Export Pay Salaries Data In Progress']);
        $this->generatePaySalariesData->generatePaySalariesFile($fileName);
        $output->writeln(['File generated successfully']);
        $output->writeln(['Path to file : public/paySalariesData/'.$fileName.'.csv']);

        return Command::SUCCESS;
    }
}