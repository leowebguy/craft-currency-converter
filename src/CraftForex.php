<?php
namespace kerns\craftforex;

use kerns\craftforex\models\CraftForexModel;
use kerns\craftforex\services\CraftForexService;
use kerns\craftforex\variables\CraftForexVariable;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class CraftForex
 * @property  CraftForexService $craftForexService
 */
class CraftForex extends Plugin
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
                $variable->set('currency', CraftForexVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'craft-forex',
                '{name} plugin loaded',
                [ 'name' => $this->name ]
            ),
            __METHOD__
        );

    }

    protected function createSettingsModel()
    {
        return new CraftForexModel();
    }

    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('craft-forex/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}
