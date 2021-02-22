<?php
namespace App\WebScraper\Sites\RightMove;

use App\WebScraper\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\CssSelector\CssSelectorConverter;

class Scrape extends Scraper 
{
    const types = [
        'detached',
        'flat',
        'semi-detached',
        'terraced',
        'other'
    ];

    const property_elements = [
        'address' => '.propertyCard > a',
        'type' => '.propertyType',
        'price' => 'div > div.transaction-table-container > table > tbody > tr > td.price',
        'date_sold' => 'td.date-sold'
    ];

    const base_url = 'https://www.rightmove.co.uk/house-prices.html';

    const search_button_list_element = 'housePrices';

    const number_search_element = '#content > div.sold-prices-content-wrapper > div.sold-prices-content > div.results > div.results-filters > div.sort-bar > div.section.sort-bar-results';

    //check if inactive
    const number_search_pagination_element = '.pagination .pagination-next';

    const propertyCard_content = 'propertyCard-content';

    const pages = [
        'searched_page' => [
            'filtering' => [
                'submit_search' => '',
                'radius' => 'radius',
                'soldIn' => 'soldIn',
                'propertyType' => 'propertyType',
                'tenure' => 'tenure',
                'sortBy' => 'sortBy',
            ],
        ]
    ];

    private function getSearchNumberAddresses(string $url) : int{
        $crawler = new Crawler($url);
        $converter = new CssSelectorConverter();

        $crawler = $crawler->filterXPath($converter->toXPath(self::number_search_element));
        var_dump($crawler);
        exit();
        return intval($crawler);
    }


    public function getProperties($search, $filters  = null){
        /*
            address, type of property and price of 5 most expensive properties sold in the last 10 years
        */

        //With more development, more than one form can be excecuted at a time.
        $forms = [];

        $form = new \stdClass();
        $form->selectButton = self::search_button_list_element;
        $form->form = [
            'searchLocation' => $search
        ];
        $forms[] = $form;

        $ten_years_ago = strtotime('-10 year', time());

        $url = $this->submitSearch(self::base_url, $forms);

        $filters = ['sortBy' => 'DEED_DATE'];

        $number = $this->getSearchNumberAddresses($url);
        
        $url = $this->filterOnSelect($url, $filters);
        var_dump($url);
        exit();

        $client = new Client();
        $client->request('GET', $url);

        $this->paginate($client, 'propertyCard-content', NULL, []);
    }

}
