<?php
namespace App\WebScraper;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class Scraper
{
    /**
     * @param string $url 
     * @param string $key_page_param
     *  @param string $param_value
     * @return string
     *
     * Get new page url
     */
    public function newPageUrl(string $url, string $key_page_param, string $param_value ) : string 
    {
        $url_components = parse_url($url); 

        parse_str($url_components['query'], $params); 

        $params[$key_page_param] = $param_value;

        $url_no_params = substr ($url, 0, strpos($url , '?') );
        $output = implode('&', array_map(
            function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
            $params,
            array_keys($params)
        ));
        $new_url = '';

        if (isset($params)) {
            $new_url = $url_no_params . '?' . $output;
        }else{
            $new_url = $url . '?' . $key_page_param . '=' . $param_value;
        }
        $new_url = str_replace('\'', '', $new_url);
        return $new_url;
    }

    /**
     * @param string $url
     * @param int $limit
     * @param array|null $return_data
     * @param int $page_num
     * @param int $number_of_pages
     * @return array
     *
     * Get properties from each page
     * Needs work so it works universally for sites
     */
    
    public function paginate(string $url,int $limit, array $return_data = [], int $page_num = 1, int $number_of_pages = 0) : array
    {
        //Check last page
        if($number_of_pages > 0 && $page_num > $number_of_pages){
            return isset($return_data) ? $return_data : [];
        }

        //Get next page url
        $new_url = $this->newPageUrl($url,'page', $page_num);
        
        //Json data for page
        $data = $this->getSearchPageJsonData($new_url, "{\"results", "window.__APP_CONFIG__");

        //Set number of pages if not set
        if($number_of_pages == 0){
            $number_of_pages = $data->pagination->last;
        }
        foreach ($data->results->properties as $key => $value) {
            if(count($return_data) == 5){
                return isset($return_data) ? $return_data : [];
            }
            $prop_data = $data->results->properties[$key];

                //Check if time is after 10 years
            if(isset($limit) && strtotime($prop_data->transactions[0]->dateSold) >= $limit){

                $number = str_replace('&pound;', '', $prop_data->transactions[0]->displayPrice);

                $return_data[] = [
                    $prop_data->address,
                    $prop_data->propertyType,
                    $number
                ];

            }
                
        }

        //Recursive call
        return $this->paginate($new_url, $limit, $return_data, $page_num + 1, $number_of_pages);
    }

    /**
     * @param string $url
     * @param array $forms
     * @return string
     *
     * Search via form submit
     */
    public function submitSearch(string $url, array $forms) : string{
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', $url);

        foreach ($forms as $key => $form) {
            $submit_form = $crawler->selectButton($form->selectButton)->form();
            foreach ($form->form as $key => $value) {
                $submit_form[$key] = $value;
            }
            $crawler = $browser->submit($submit_form);
        }
            //return url for effiency
        return $crawler->getUri();
    }

    /**
     * @param string $url
     * @param string $start
     * @param string $end
     * @return mixed
     *
     * Get json data on page
     */
    public function getSearchPageJsonData(string $url, string $start, string $end) {
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', $url);

        $text = substr ($crawler->text(), strpos($crawler->text() , $start) );
        $text = substr ($text, 0, strpos($text , $end) );
        return json_decode($text);
    }

}