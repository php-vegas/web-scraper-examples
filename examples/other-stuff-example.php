<?php

require __DIR__.'/../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

// Go to the symfony.com website
$crawler = $client->request('GET', 'http://www.symfony.com/blog/');

// Get the URI
print 'Request URI : ' . $crawler->getUri() . PHP_EOL;

// Get the Symfony\Component\BrowserKit\Response object
/** @var $response Symfony\Component\BrowserKit\Response */
$response = $client->getResponse();

// Get important stuff out of the Response object
$status = $response->getStatus();
$content = $response->getContent();
$headers = $response->getHeaders();

print 'HTTP status code : ' . $status . PHP_EOL;
//print 'Content of response : ' . $content . PHP_EOL;
//print 'HTTP Headers : ' . print_r($headers) . PHP_EOL;