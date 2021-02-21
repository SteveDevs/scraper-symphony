<?php

namespace App\Command;

use Symfony\Component\Console\Command;
use App\WebScraper\Sites\RightMove\Scrape;

class GetPropertiesByPostalCommand extends Command
{

    protected static $defaultName = 'app:scrape-right-move-properties';
    protected function configure(){

        $this->setDescription('Scrape properties')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Limit number of properties');
            ->addArgument('limit', InputArgument::OPTIONAL, 'Limit number of properties');
    }

    protected function execute(InputInterface $input, OutputInterface $output){


        $output->writeln('<redt>Tomorrow will be snowing</redt>');
    }
}