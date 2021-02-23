<?php
namespace App\WebScraper\Sites\RightMove;

use App\WebScraper\Scraper;

class Scrape extends Scraper 
{
    /**
     * Base url
     *
     * @var string
     */
    const BASE_URL = 'https://www.rightmove.co.uk/house-prices.html';

    /**
     * Search button element
     *
     * @var string
     */
    const SEARCH_BUTTON_LIST_ELEMENT = 'housePrices';

    /**
     * @param string $url
     * @return int
     *
     * Get number of addresses
     */
    private function getSearchNumberAddresses(string $url) : string
    {

        return $this->getSearchPageJsonData($url, "{\"results", "window.__APP_CONFIG__")->results->resultCount;
    }

    /**
     * @param string $search
     * @param array null $filters
     * @return array
     *
     * Get Properties
     */
    public function getProperties(string $search, array $filters  = null) : array
    {

        //With more development, more than one form can be excecuted at a time.

        //Forms stdClass array
        $forms = [];

        $form = new \stdClass();
        $form->selectButton = self::SEARCH_BUTTON_LIST_ELEMENT;
        $form->form = [
            'searchLocation' => $search
        ];
        $forms[] = $form;

        //Ten years integer
        $ten_years_ago = strtotime('-10 year', time());

        //Search on https://www.rightmove.co.uk/house-prices.html
        $url = $this->submitSearch(self::BASE_URL, $forms);

        //Get number of addresses
        $number = $this->getSearchNumberAddresses($url);

        $properties = $this->paginate($url, $ten_years_ago);
        $properties = array_splice($properties, 0, 5);
        $properties['number_of_props'] = $number;

        return $properties;
    }

}
