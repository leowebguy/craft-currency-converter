<?php
/**
 * Currency Converter plugin for Craft CMS
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2023, leowebguy
 * @license    MIT
 */

namespace leowebguy\currencyconverter\variables;

use leowebguy\currencyconverter\Currency;

class CurrencyVariable
{
    /**
     * @param string $from
     * @param string $to
     * @param float|int $amount
     * @return mixed
     */
    public function conversion(string $from = 'EUR', string $to = 'USD', float|int $amount = 1): mixed
    {
        return Currency::$plugin->currencyService->getConversion($from, $to, $amount);
    }
}
