<?php
namespace kerns\craftforex\variables;

use kerns\craftforex\CraftForex;

/**
 * Class CraftForexVariable
 */
class CraftForexVariable
{
    public function conversion($from = 'EUR', $to = 'USD', $amount = 1)
    {
        return CraftForex::$plugin->craftForexService->getConversion($from, $to, $amount);
    }
}
