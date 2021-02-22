<?php
namespace App\WebScraper\Sites\RightMove;

use App\WebScraper\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\CssSelector\CssSelectorConverter;

class Scrape extends Scraper 
{

    const property_elements = [
        'address' => '.propertyCard > a',
        'type' => '.propertyType',
        'price' => 'div > div.transaction-table-container > table > tbody > tr > td.price',
        'date_sold' => 'td.date-sold'
    ];

    const base_url = 'https://www.rightmove.co.uk/house-prices.html';

    const search_button_list_element = 'housePrices';

    const number_search_element = '.sort-bar-results';

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
        return intval($this->getSearchPageJsonData($url, "{\"results", "window.__APP_CONFIG__")->results->resultCount);
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

        //$filters = ['sortBy' => 'DEED_DATE'];

        $number = $this->getSearchNumberAddresses($url);
        
        //$url = $this->filterOnSelect($url, $filters);
        //var_dump($url);
        //exit();

        $properties = $this->paginate($url, $ten_years_ago);
        var_dump(count($properties));
        exit();
    }

}
