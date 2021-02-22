<?php
namespace App\WebScraper;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Acme\Client;
use Symfony\Component\DomCrawler\Link;

class Scraper
{

    public function paginate(Client $client, string $paginate_element_collect, $paginate_end_element = null, array $return_html) : string{

        $crawler = new Crawler($url);
        $return_html[] = $crawler->filter($paginate_element_collect);

        $link = $client->selectLink($paginate_element)->link();
        $client->click($link);

        //test if paginate end
        if($link->getUri() != ''){
            return $this->paginate($client, $paginate_element_collect, $paginate_end_element, $return_html);
        }
        var_dump($return_html);
        exit();
        if(isset($paginate_end_element)){
            //end($return_html);
        }
        return $return_html;
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
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', $url);
        foreach ($filters as $key => $filter) {
            var_dump($filters);
            exit();
            $submit_filter = $crawler->selectButton($key)->form();
            $submit_filter->select($value);
            $crawler = $browser->submit($submit_filter);
        }
        //return url
        return $crawler->getUri();
    }

}