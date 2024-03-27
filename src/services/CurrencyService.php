<?php
/**
 * Currency Converter plugin for Craft CMS
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2024, leowebguy
 */

namespace leowebguy\currencyconverter\services;

use Craft;
use craft\base\Component;
use craft\helpers\App;
use craft\helpers\FileHelper;
use GuzzleHttp\Exception\GuzzleException;
use yii\base\Exception;

class CurrencyService extends Component
{
    /**
     * @param string $from
     * @param string $to
     * @param int $amount
     * @throws GuzzleException
     * @throws Exception
     * @return mixed
     */
    public function getConversion(string $from = 'EUR', string $to = 'USD', int $amount = 1): mixed
    {
        $path = Craft::$app->path->getStoragePath() . '/currency/';
        $cache = $path . $from . '_' . $to;

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
            Craft::error('RapidAPI Error | ' . $e->getMessage(), __METHOD__);
            Craft::$app->getErrorHandler()->logException($e);

            return 'RapidAPI Error #1';
        }

        $r = @json_decode(trim($response->getBody()->getContents()));

        if ($r->status == 'success') {
            $rate = $r->rates->$to->rate;
            @file_put_contents($cache, $rate);

            return $amount * $rate;
        }

        return 'RapidAPI Error #2';
    }
}
