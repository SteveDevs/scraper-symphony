<?php
namespace App\WebScraper;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Acme\Client;
use Symfony\Component\DomCrawler\Link;

abstract class AbstractScrape
{

    public function doRangeScrape(array $urls, array $elements_range) : array{
        $crawler = new Crawler($html);
        
    }

    public function doScrape(array $urls, array $elements){

    }

    public function searchValueConditionOnPage(string $url, string $element, string $value) : string{
        $html = '<html>
<body>
    <span id="article-100" class="article">Article 1</span>
    <span id="article-101" class="article">Article 2</span>
    <span id="article-102" class="article">Article 3</span>
</body>
</html>';

$crawler = new Crawler();
$crawler->addHtmlContent($html);

    }


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
            $form = $crawler->selectButton($form['select-button'])->form();
            foreach ($form['form'] as $key => $value) {
                $form[$key] = $value;
            }
            
            $crawler = $browser->submit($form);
        }
        //return url
        return $crawler;
    }

    public function filterOnSelect(string $url, array $filters) : string{
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', $url);
        foreach ($filters as $key => $form) {
            $form = $crawler->selectButton($form['select-button'])->form();
            foreach ($form['form'] as $key => $value) {
                $form->select($value);
            }
            $crawler = $browser->submit($form);
        }
        //return url
        return $crawler;
    }

}