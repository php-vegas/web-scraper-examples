<?php

require __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

// Create the guzzle client with your default options
// See all available options that can be set in guzzle at http://docs.guzzlephp.org/en/latest/request-options.html
$guzzle = new GuzzleClient(
    array(
        // base_uri isn't supported due to BrowserKit, anyone want to make a PR on github for this?
        // 'base_uri'        => 'https://www.symfony.com',
        'timeout'         => 0,
        'allow_redirects' => false,
        'cookies'         => true,
        // Proxy from proxylist.hidemyass.com
        'proxy'           => 'tcp://63.150.152.151:3128'
    )
);

$client = new Client();
$client->setClient($guzzle);

// Go to the symfony.com website
$crawler = $client->request('GET', 'https://www.symfony.com/blog/');

// Click on the "Security Advisories" link
$link = $crawler->selectLink('Security Advisories')->link();
$crawler = $client->click($link);

// Get the latest post in this category and display the titles
$crawler->filter('h2 > a')->each(function ($node) {
    print $node->text() . "\n";
});

