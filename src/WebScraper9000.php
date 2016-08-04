<?php

namespace PHPVegas;

/**
 * Class WebScraper9000 extends the Goutte Client and provides a helper method to grab product info.
 *
 * @author Joshua Ray Copeland <Josh@PsyCode.org>
 */
class WebScraper9000 extends \Goutte\Client
{

    /**
     * A helper method to grab product info from Dell.
     *
     * @param string $uri
     * @return array The product info
     */
    public function getProductInfo($uri)
    {

        // Init empty productInfo array @todo create value object
        $productInfo = array();

        $crawler = $this->request('GET', $uri);

        if ($this->getResponse()->getStatus() != 200) {
            die('Something went wrong. HTTP status code is not OK! :( Exiting web scraper 9000...');
        }

        // Scrape product information
        try {
            // Grab the product name
            $productInfo['Product Name'] = $crawler->filterXPath("(//span[@itemprop='name'])[1]")->text();
            // Grab the price (note if no sales price is found, it looks for the retail price)
            try {
                $productInfo['Price'] = $crawler->filterXPath("(//span[@name='pricing_sale_price'])[1]")->text();
            } catch (\InvalidArgumentException $exSalePrice) {
                try {
                    $productInfo['Price'] = $crawler->filterXPath("(//span[@name='pricing_retail_price'])[1]")->text();
                } catch (\InvalidArgumentException $exRetailPrice) {
                    die('No price was found, please update css selectors.');
                }
            }
            // Extract just the model # (requires a bit more work since its combined with other info)
            $productInfo['Model #'] =
                trim(
                    str_replace(
                        'Manufacturer Part# : ',
                        '',
                        explode('|', $crawler->filterXPath("(//td[@class='para_small'])[1]")->text())[0]
                    )
                );
        } catch (InvalidArgumentException $ex) {
            die('One of the data nodes was not extracted properly, please update css selectors.');
        }

        return $productInfo;
    }
} 
