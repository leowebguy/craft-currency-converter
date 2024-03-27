<?php
/**
 * Currency Converter plugin for Craft CMS
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2024, leowebguy
 */

namespace leowebguy\currencyconverter;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use leowebguy\currencyconverter\models\CurrencyModel;
use leowebguy\currencyconverter\services\CurrencyService;
use leowebguy\currencyconverter\variables\CurrencyVariable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\base\Event;
use yii\base\Exception;

class Currency extends Plugin
{
    public bool $hasCpSection = false;

    public bool $hasCpSettings = true;

    public function init(): void
    {
        parent::init();

        if (!$this->isInstalled) {
            return;
        }

        $this->setComponents([
            'currencyService' => CurrencyService::class
        ]);

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('currency', CurrencyVariable::class);
            }
        );

        Craft::info(
            'Currency Converter plugin loaded',
            __METHOD__
        );
    }

    /**
     * @return Model|null
     */
    protected function createSettingsModel(): ?Model
    {
        return new CurrencyModel;
    }

    /**
     * @throws SyntaxError
     * @throws Exception
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('currency-converter/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
