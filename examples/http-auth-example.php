<?php

require __DIR__ . '/../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

// Params are username, password, and auth type (like digest)
$client->setAuth('test', 'test', 'basic');

$crawler = $client->request('GET', 'http://browserspy.dk/password-ok.php');

print $client->getResponse()->getStatus();
// 401 = no good, 200 = happy