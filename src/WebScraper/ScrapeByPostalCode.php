<?php

namespace App\WebScraper;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class Scrape
{

    private $search_postal_code;
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $option_1;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $option_2;

    private $option_3;

    public function __construct(string $url, array $options)
    {
        $this->prepareScrape($options);
    }

    private function prepareScrape(array $options) : void{
        foreach($options as $option){

        }
    }

    public function submitSearch(string $url, array $form) : ?HttpBrowser{
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', 'https://github.com/login');

        // select the form and fill in some values
        $form = $crawler->selectButton('Sign in')->form();
        $form['login'] = 'symfonyfan';
        $form['password'] = 'anypass';

        // submits the given form
        $crawler = $browser->submit($form);
        return $crawler;
    }

    public function getNumSoldPropertiesByPostCode(){

    }


    private function doScrape(){

    }

    private function option1_function(){

    }

    private function option2_function(){
        
    }

    private function option3_function(){
        
    }

}
