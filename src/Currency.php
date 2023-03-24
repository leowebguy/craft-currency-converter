<?php
/**
 * Currency Converter plugin for Craft CMS
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2023, leowebguy
 * @license    MIT
 */

namespace leowebguy\currencyconverter;

use Craft;
use craft\base\Plugin;
use craft\base\Model;
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
    // Properties
    // =========================================================================

    public static $plugin;

    public bool $hasCpSection = false;

    public bool $hasCpSettings = true;

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        self::$plugin = $this;

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

    // Protected Methods
    // =========================================================================

    /**
     * @return Model|null
     */
    protected function createSettingsModel(): ?Model
    {
        return new CurrencyModel();
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
