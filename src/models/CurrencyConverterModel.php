<?php
/*
 * Currency Converter | Craft 3 Plugin
 */

namespace leowebguy\currencyconverter\models;

use craft\base\Model;

/**
 * CurrencyConverterModel.
 */
class CurrencyConverterModel extends Model
{
    public $accessKey = '';
    public $cacheTime = 6;
}
