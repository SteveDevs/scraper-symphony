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
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        /*
            address, type of property and price of 5 most expensive properties sold in the last 10 years
        */

        $properties = ((new Scrape())->getProperties($input->getArgument('postal-code')));
        $output->writeln('Properties:');
        $output->writeln('Number of properties: ' . $properties['number_of_props']);
        
        $output->writeln('');
        unset($properties['number_of_props']);
        foreach ($properties as $property) {
            $output->writeln('Address: ' . $property[0]);
            $output->writeln('Type: ' . $property[1]);
            $output->writeln('Price: ' . chr(163) . number_format($property[2], 2));
            $output->writeln('');
        }
        return 1;
    }
}