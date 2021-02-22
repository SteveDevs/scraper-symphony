<?php
namespace App\WebScraper;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Acme\Client;
use Symfony\Component\DomCrawler\Link;

class Scraper
{
    //TODO to increase retriv al speed
    private function filterPageResults($json, array $filters, $limit){

    }


    public function paginate(string $url,int $limit, array $return_data = null, int $page_num = 1, int $number_of_pages = 0) : array{

        //Check last page
        if($number_of_pages > 0 && $page_num > $number_of_pages){
            return isset($return_data) ? $return_data : [];
        }

        $url_components = parse_url($url); 
        // Display result
  
        // Use parse_str() function to parse the 
        // string passed via URL 
        parse_str($url_components['query'], $params); 

        $params['page'] = $page_num;

        $url_no_params = substr ($url, 0, strpos($url , '?') );
        $output = implode('&', array_map(
            function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
            $params,
            array_keys($params)
        ));

        //$pos = strpos($output, '&');
        $new_url = '';

        if (isset($params)) {
            $new_url = $url_no_params . '?' . $output;
        }else{
            $new_url = $url . '?page=' . $page_num;
        }
        //test if paginate end
       
        $data = $this->getSearchPageJsonData($new_url, "{\"results", "window.__APP_CONFIG__");

        if($number_of_pages == 0){
            $number_of_pages = $data->pagination->last;
        }
        
        foreach ($data->results->properties as $key => $value) {
           $prop_data = $data->results->properties[$key];
           
            if(isset($limit) && strtotime($prop_data->transactions[0]->dateSold) >= $limit){

                $return_data[] = [
                    $prop_data->address,
                    $prop_data->propertyType,
                    $prop_data->transactions[0]->displayPrice
                ];
  
            }else{
                return isset($return_data) ? $return_data : [];
            }
            
        }
        return $this->paginate($new_url, $limit, $return_data, $page_num + 1, $number_of_pages);
    }

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

    public function filterOnSelect(string $url, array $filters) : string{
            /*$browser = new HttpBrowser(HttpClient::create());
            $crawler = $browser->request('GET', $url);

            foreach ($filters as $key => $filter) {

                $submit_filter = $crawler->selectButton($key)->form();

                $submit_filter->select($filter);
                $crawler = $browser->submit($submit_filter);
            }
            //return url
            return $crawler->getUri();*/
        }

        public function getSearchPageJsonData(string $url, string $start, string $end) {
            $browser = new HttpBrowser(HttpClient::create());
            $crawler = $browser->request('GET', $url);

            $text = substr ($crawler->text(), strpos($crawler->text() , $start) );
            $text = substr ($text, 0, strpos($text , $end) );

            return json_decode($text);
        }

    }