<?php

namespace App\Command;

use Symfony\Component\Console\Command;
use App\WebScraper\Sites\RightMove\Scrape;

class GetPropertiesByPostalCommand extends Command
{

    protected static $defaultName = 'app:scrape-right-move-properties';
    protected function configure(){

        $this->setDescription('Scrape properties')
            ->addArgument('postal-code', InputArgument::OPTIONAL, 'Postal code');
            /*->addArgument('limit', InputArgument::OPTIONAL, 'Limit number of properties')
            ->addArgument('property_limit', InputArgument::OPTIONAL, 'Limit property number of properties');
            ->addArgument('limit_order', InputArgument::OPTIONAL, 'Limit order on properties');*/
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        ((new Scrape())->getProperties($this->getArgument('postal-code')));
        $output->writeln('<redt>Tomorrow will be snowing</redt>');
    }
}