<?php
namespace leowebguy\currencyconverter\services;

use GuzzleHttp\Client;

use Craft;
use craft\base\Component;

/**
 * Class CurrencyConverterService
 */
class CurrencyConverterService extends Component
{
    public function getConversion($from = 'EUR', $to = 'USD', $amount = 1)
    {
        $key = $from.'_'.$to;

        $path = Craft::$app->path->getStoragePath().'/currency/';
        $cache = $path.$key;

        if (!is_dir($path)) {
            mkdir($path);
        }

        $settings = Craft::$app->plugins->getPlugin('currency-converter')->getSettings();

        if (file_exists($cache) && filemtime($cache) > time() - (60 * 60 * ((int) $settings['cacheTime']))) {
            return $amount * file_get_contents($cache);
        }

//        $client = new Client([
//            'base_uri' => 'http'.($settings['https'] ? 's' : '').'://free.currconv.com/api/v7/convert?q='.$key.'&compact=ultra&apiKey='.$settings['accessKey'],
//            'timeout'  => 2.0
//        ]);
//        $response = $client->request('GET');

        $client = new Client();

        $response = $client->request('GET', 'https://currency-converter5.p.rapidapi.com/currency/convert', [
            'query' => [
                'format' => 'json',
                'from' => $from,
                'to' => $to,
                'amount' => '1'
            ],
            'headers' => [
                'x-rapidapi-host' => 'currency-converter5.p.rapidapi.com',
                'x-rapidapi-key' => $settings['accessKey']
            ]
        ]);

        $responseBody = json_decode(trim($response->getBody()));

        if ($responseBody->status == 'success') {

            $rate = $responseBody->rates->$to->rate;
            file_put_contents($cache, $rate);

            return $amount * $rate;

        } else {

            return false;

        }
    }
}
