<?php
/*
 * Currency Converter | Craft 3 Plugin
 */

namespace leowebguy\currencyconverter;

use Craft;
use craft\base\Plugin;
use craft\base\Model;
use craft\web\twig\variables\CraftVariable;
use leowebguy\currencyconverter\models\CurrencyConverterModel;
use leowebguy\currencyconverter\services\CurrencyConverterService;
use leowebguy\currencyconverter\variables\CurrencyConverterVariable;
use yii\base\Event;

/**
 * Class CurrencyConverter.
 *
 * @property CurrencyConverterService $currencyConverterService
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
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('currency', CurrencyConverterVariable::class);
            }
        );

        Craft::info(
            'Currency Converter plugin loaded',
            __METHOD__
        );
    }

    protected function createSettingsModel(): ?Model
    {
        return new CurrencyConverterModel();
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('currency-converter/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
