<?php
namespace App\WebScraper\Interfaces;

interface ScrapingInterface
{
    public function doScrape(array $urls, array $elements);
    public function doRangeScrape(array $urls, array $elements_range);
}