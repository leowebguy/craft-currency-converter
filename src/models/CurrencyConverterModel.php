<?php
/**
 * Currency Converter plugin for Craft CMS 3.x
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2021, leowebguy
 * @license    MIT
 */

namespace leowebguy\currencyconverter\models;

use craft\base\Model;

/**
 * CurrencyConverterModel.
 */
class CurrencyConverterModel extends Model
{
    public $accessKey = '$CC_KEY';
    public $cacheTime = 6;
}
