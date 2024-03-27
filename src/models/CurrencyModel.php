<?php
/**
 * Currency Converter plugin for Craft CMS
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2024, leowebguy
 */

namespace leowebguy\currencyconverter\models;

use craft\base\Model;

class CurrencyModel extends Model
{
    public string $accessKey = '$CC_KEY';
    public int $cacheTime = 6;
}
