<?php
/*
 * Currency Converter | Craft 3 Plugin
 */

namespace leowebguy\currencyconverter;

use leowebguy\currencyconverter\models\CurrencyConverterModel;
use leowebguy\currencyconverter\services\CurrencyConverterService;
use leowebguy\currencyconverter\variables\CurrencyConverterVariable;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class CurrencyConverter
 * @property  CurrencyConverterService $currencyConverterService
 */
class CurrencyConverter extends Plugin
{
    public static $plugin;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('currency', CurrencyConverterVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'currency-converter',
                '{name} plugin loaded',
                [ 'name' => $this->name ]
            ),
            __METHOD__
        );

    }

    protected function createSettingsModel()
    {
        return new CurrencyConverterModel();
    }

    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('currency-converter/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}
