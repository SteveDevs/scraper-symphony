<?php
namespace App\Tests\WebScraper\Sites\RightMove;

use App\WebScraper\Sites\RightMove\Scrape;
use PHPUnit\Framework\TestCase;

class ScrapeTest extends TestCase
{

    const BASE_URL = 'https://www.rightmove.co.uk/house-prices.html';

    const SEARCH_BUTTON_LIST_ELEMENT = 'housePrices';

    const JSON_TEST = '{"0":["Apartment 3502, The Heron, 5, Moor Lane, London, Greater London EC2Y 9BB","Flat",7600000],"1":["Flat 4801, 2, Principal Place, London, Greater London EC2A 2FG","Flat",6398060],"2":["Flat 4401, 2, Principal Place, London, Greater London EC2A 2FG","Flat",5500000],"3":["Flat 4601, 2, Principal Place, London, Greater London EC2A 2FG","Flat",5495370],"4":["Flat 3403, 5, Moor Lane, London, Greater London EC2Y 9BB","Flat",4450000],"number_of_props":"2,905"}';

    public function testGetProperties()
    {
        $scrape = new Scrape();

        $properties = $scrape->getProperties('EC2');

        $this->assertEquals(self::JSON_TEST, json_encode($properties));
    }
}