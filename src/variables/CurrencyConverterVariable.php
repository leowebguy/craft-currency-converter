<?php
namespace leowebguy\currencyconverter\variables;

use leowebguy\currencyconverter\CurrencyConverter;

/**
 * Class CurrencyConverterVariable
 */
class CurrencyConverterVariable
{
    public function conversion($from = 'EUR', $to = 'USD', $amount = 1)
    {
        return CurrencyConverter::$plugin->currencyConverterService->getConversion($from, $to, $amount);
    }
}
