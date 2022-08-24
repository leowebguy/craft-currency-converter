<?php
/**
 * Currency Converter plugin for Craft CMS 3.x
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2021, leowebguy
 * @license    MIT
 */
namespace leowebguy\currencyconverter\variables;

use leowebguy\currencyconverter\CurrencyConverter;

/**
 * CurrencyConverterVariable.
 */
class CurrencyConverterVariable
{
    /**
     * conversion.
     *
     * @param string $from
     * @param string $to
     * @param float $amount
     *
     * @return mixed
     */
    public function conversion($from = 'EUR', $to = 'USD', $amount = 1)
    {
        return CurrencyConverter::$plugin->currencyConverterService->getConversion($from, $to, $amount);
    }
}
