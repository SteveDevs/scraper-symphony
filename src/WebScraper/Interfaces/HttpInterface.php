<?php
namespace App\WebScraper\Interfaces;

interface HttpInterface
{
    public function submitSearch(string $url, array $form);
}