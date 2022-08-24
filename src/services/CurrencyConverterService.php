<?php
/**
 * Currency Converter plugin for Craft CMS 3.x
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2021, leowebguy
 * @license    MIT
 */

namespace leowebguy\currencyconverter\services;

use Craft;
use craft\base\Component;
use craft\helpers\App;
use craft\helpers\FileHelper;

/**
 * CurrencyConverterService.
 */
class CurrencyConverterService extends Component
{
    /**
     * getConversion.
     *
     * @param string $from
     * @param string $to
     * @param float $amount
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function getConversion($from = 'EUR', $to = 'USD', $amount = 1)
    {
        $key = $from . '_' . $to;

        $path = Craft::$app->path->getStoragePath() . '/currency/';
        $cache = $path . $key;

        if (!is_dir($path)) {
            FileHelper::createDirectory($path);
        }

        $settings = Craft::$app->plugins->getPlugin('currency-converter')->getSettings();

        if (@file_exists($cache) && @filemtime($cache) > time() - (60 * 60 * ((int)$settings['cacheTime']))) {
            return $amount * @file_get_contents($cache);
        }

        try {
            $client = Craft::createGuzzleClient();
            $response = $client->get('https://currency-converter5.p.rapidapi.com/currency/convert', [
                'query' => [
                    'format' => 'json',
                    'from' => $from,
                    'to' => $to,
                    'amount' => '1',
                ],
                'headers' => [
                    'X-RapidAPI-Key' => App::parseEnv($settings['accessKey']),
                    'X-RapidAPI-Host' => 'currency-converter5.p.rapidapi.com'
                ],
            ]);
        } catch (\Exception $e) {
            Craft::error('RapidAPI Guzzle Client Error', __METHOD__);
            return 'RapidAPI Error';
        }

        $r = @json_decode(trim($response->getBody()->getContents()));

        if ('success' == $r->status) {
            $rate = $r->rates->$to->rate;
            @file_put_contents($cache, $rate);

            return $amount * $rate;
        }

        return false;
    }
}
