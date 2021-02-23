<?php
namespace App\Tests\WebScraper\Sites\RightMove;

use App\WebScraper\Sites\RightMove\Scrape;
use PHPUnit\Framework\TestCase;

class ScrapeTest extends TestCase
{

    const JSON_TEST = '{"0":["Apartment 3502, The Heron, 5, Moor Lane, London, Greater London EC2Y 9BB","Flat","7,600,000"],"1":["Flat 4801, 2, Principal Place, London, Greater London EC2A 2FG","Flat","6,398,060"],"2":["Flat 4401, 2, Principal Place, London, Greater London EC2A 2FG","Flat","5,500,000"],"3":["Flat 4601, 2, Principal Place, London, Greater London EC2A 2FG","Flat","5,495,370"],"4":["Apartment 3303, The Heron, 5, Moor Lane, London, Greater London EC2Y 9AP","Flat","5,050,000"],"number_of_props":"2,905"}';

    public function testGetProperties()
    {
        $scrape = new Scrape();

        $properties = $scrape->getProperties('EC2');

        $this->assertEquals(self::JSON_TEST, json_encode($properties));
    }
}