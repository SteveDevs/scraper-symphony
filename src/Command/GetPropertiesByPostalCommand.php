<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\WebScraper\Sites\RightMove\Scrape;

class GetPropertiesByPostalCommand extends Command
{

    protected static $defaultName = 'app:scrape-right-move-properties';
    protected function configure() : void{

        $this->setName('app:scrape-right-move-properties')
            ->setDescription('Scrape properties')
            ->addArgument('postal-code', InputArgument::OPTIONAL, 'Postal code');
            
            /*->addArgument('limit', InputArgument::OPTIONAL, 'Limit number of properties')
            ->addArgument('property_limit', InputArgument::OPTIONAL, 'Limit property number of properties');
            ->addArgument('limit_order', InputArgument::OPTIONAL, 'Limit order on properties');*/
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $return = ((new Scrape())->getProperties($input->getArgument('postal-code')));
        $output->writeln('<redt>Tomorrow will be snowing</redt>');
    }
}