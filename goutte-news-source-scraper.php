<?php
/* 
* Goutte is an HTTP client made for web scraping, built by creator of Symfony Framework
* combines several Symfony components:
* BrowserKit - simulates the behavior of a web browser that yuo can use programmatically
* DomCrawler - DOMDocument and XPath with superpowers
* CssSelector - translates CSS queries into XPath queries
* Symfony HTTP Client - pretty new
*/

require 'vendor/autoload.php';

$client = new \Goutte\Client();

$client
    ->request("GET", "https://mediabiasfactcheck.com/pseudoscience-dictionary/")
    ->filter('#mbfc-table > tbody > tr > td > span > a')
    ->each(function ($node) {
        $fo = fopen('../sources/pseudoscience.php', 'a');
        fwrite($fo, $node->text()."\n");
        fclose($fo);
    });

    
