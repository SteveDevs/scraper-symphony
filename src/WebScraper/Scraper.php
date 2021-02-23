<?php
namespace App\WebScraper;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class Scraper
{
    /**
     * @param string $url
     * @param string $page_num
     * @param string $key_page_param
     * @return string
     *
     * Get next page url
     */
    public function getNextPageUrl(string $url, string $page_num, string $key_page_param) : string 
    {
        $url_components = parse_url($url); 

        parse_str($url_components['query'], $params); 

        $params[$key_page_param] = $page_num;

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
            $new_url = $url . '?' . $key_page_param . '=' . $page_num;
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
    
    public function paginate(string $url,int $limit, array $return_data = null, int $page_num = 1, int $number_of_pages = 0) : array
    {
        //Check last page
        if($number_of_pages > 0 && $page_num > $number_of_pages){
            return isset($return_data) ? $return_data : [];
        }

        //Get next page url
        $new_url = $this->getNextPageUrl($url, $page_num, 'page');

        //Json data for page
        $data = $this->getSearchPageJsonData($new_url, "{\"results", "window.__APP_CONFIG__");

        //Set number of pages if not set
        if($number_of_pages == 0){
            $number_of_pages = $data->pagination->last;
        }

        //If on first page
        if($page_num == 1){
            foreach ($data->results->properties as $key => $value) {
                $prop_data = $data->results->properties[$key];

                //Check if time is after 10 years
                if(isset($limit) && strtotime($prop_data->transactions[0]->dateSold) >= $limit){

                    $number = str_replace('&pound;', '', $prop_data->transactions[0]->displayPrice);
                    $number = (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT);

                    $return_data[] = [
                        $prop_data->address,
                        $prop_data->propertyType,
                        $number
                    ];

                }else{
                    //Return properties sorted
                    usort($return_data, function($a, $b){
                        if ($a[2] == $b[2]) return 0;
                        return ($a[2] > $b[2]) ? -1: 1;
                    });
                    $return_data = array_splice($return_data, 0, 5);
                    return isset($return_data) ? $return_data : [];
                }
                
            }

            /*
                Sort properties on first page to be used for compare 
                with th rest of the pages if more pages exist
            */
            usort($return_data, function($a, $b){
                if ($a[2] == $b[2]) return 0;
                return ($a[2] > $b[2]) ? -1: 1;
            });

            //Cut propers to top 6
            $return_data = array_splice($return_data, 0, 6);
        }else{

            //After first page

            foreach ($data->results->properties as $key => $value) {
                $prop_data = $data->results->properties[$key];

                 //If date of propety if futher back than 10 years
                 if(isset($limit) && strtotime($prop_data->transactions[0]->dateSold) >= $limit){

                    //Remove &pound from number
                    $number = str_replace('&pound;', '', $prop_data->transactions[0]->displayPrice);
                    
                    //Convert number to int
                    $number = (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT);

                    //Swap/splice index edit top prices from top to bottom
                    $change_index = 6;
                    if($return_data[5][2] < $number){
                        $change_index = 5;
                        if($return_data[4][2] < $number){
                            $change_index = 4;
                            if($return_data[3][2] < $number){
                                $change_index = 3;
                                if($return_data[2][2] < $number){
                                    $change_index = 2;
                                    if($return_data[1][2] < $number){
                                        $change_index = 1;
                                        if($return_data[0][2] < $number){

                                            $change_index = 0;
                                        } 
                                    }
                                }

                            }
                        }
                    }
                    //Check if need to swap
                    if($change_index < 6){
                        $inserted = array( [
                            $prop_data->address,
                            $prop_data->propertyType,
                            $number
                        ]);

                        //Swap
                        array_splice( $return_data, $change_index, 0, $inserted );
                    }

                }else{

                    //Properties within ten years reached
                    return isset($return_data) ? $return_data : [];
                }

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