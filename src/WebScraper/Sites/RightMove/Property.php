<?php

namespace App\WebScraper\Sites\RightMove;

class Property
{
    private $address;

    private $type;

    private $price;

    private $date_sold;

    public function __construct()
    {
        $this->prepareScrape($options);
    }

    private function prepareScrape(array $options) : void{
        foreach($options as $option){

        }
    }

}
