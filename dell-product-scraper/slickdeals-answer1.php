<?php
/**
 * Created by PhpStorm.
 * User: Joshua Ray Copeland
 * Date: 3/7/14
 *
 * @todo Allow some of these variables to be passed in (convert to app/console command)
 * @todo Create a UI form to submit the variables in if web interface is required.
 *
 * @problem 1) Using PHP, scrape the following values from this page, store them in array and output the array to the screen:
 * - http://accessories.us.dell.com/sna/productdetail.aspx?c=us&l=en&s=dhs&cs=19&sku=A7170751
 * Values:
 * - product name
 * - model
 * - price
 */
require __DIR__.'/../vendor/autoload.php';

// Init variables
$uri = 'http://accessories.us.dell.com/sna/productdetail.aspx?c=us&l=en&s=dhs&cs=19&sku=A8224635';

// Init client to request our target product.
$client = new \PHPVegas\WebScraper9000();
$productInfo = $client->getProductInfo($uri);

// Write to flat file
$fp = fopen('productInfo.1.csv', 'w');
fputcsv($fp, array_keys($productInfo));
fputcsv($fp, array_values($productInfo));
fclose($fp);

// Echo out to screen
foreach ($productInfo as $k => $v) {
    echo $k . ' : ' . $v . PHP_EOL;
}
