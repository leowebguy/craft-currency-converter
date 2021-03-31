<?php
/*
 * Currency Converter | Craft 3 Plugin
 */

namespace leowebguy\currencyconverter\variables;

use leowebguy\currencyconverter\CurrencyConverter;

/**
 * CurrencyConverterVariable
 */
class CurrencyConverterVariable
{
    /**
     * conversion
     *
     * @param  string $from
     * @param  string $to
     * @param  float $amount
     * @return mixed
     */
    public function conversion($from = 'EUR', $to = 'USD', $amount = 1)
    {
        return CurrencyConverter::$plugin->currencyConverterService->getConversion($from, $to, $amount);
    }
}
