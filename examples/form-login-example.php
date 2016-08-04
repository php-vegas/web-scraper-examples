<?php

require __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'http://github.com/');
$crawler = $client->click($crawler->selectLink('Sign in')->link());
$form = $crawler->selectButton('Sign in')->form();
// I put the password in an external file for security reasons since I'm presenting this to a bunch of hackers
$crawler = $client->submit($form, array('login' => 'throwawaygithubuser', 'password' => file_get_contents('pw.txt')));

$crawler->filter('.flash-error')->each(function ($node) {
    print $node->text()."\n";
});

// Save the response to an html file so I can show where this output is coming from
file_put_contents('blah.html', $client->getResponse()->getContent());