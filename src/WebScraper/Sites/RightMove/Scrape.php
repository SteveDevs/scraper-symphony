<?php
namespace App\WebScraper\Sites\RightMove;

use App\WebScraper\AbstractScrape;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class Scrape extends AbstractScrape 
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

    const number_search_element = '.section .sort-bar-results';

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

    public function __construct(array $urls)
    {
        $this->urls = $urls;
    }

    public function getSearchNumberAddresses($url) : int{
        $crawler = new Crawler($url);
        $crawler->filter($this->number_search_element);
        return intval($crawler);
    }


    private function getProperties($url, $forms, $filters  = null){
        /*
            address, type of property and price of 5 most expensive properties sold in the last 10 years
        */
        $url = $this->submitSearch($url, $forms);
        $this->filterOnSelect(string $url, array $filters);

        $client = new Client();
        $client->request('GET', $url);

        $this->paginate($client, 'propertyCard-content', NULL, []);
    }

}
