<?php
/**
 * Currency Converter plugin for Craft CMS 3.x
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2021, leowebguy
 * @license    MIT
 */

namespace leowebguy\currencyconverter\tests\unit;

use Codeception\Test\Unit;
use leowebguy\currencyconverter\ProperName;
use UnitTester;

class CurrencyConverterTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    protected function _before()
    {
        parent::_before();
    }

    protected function _after()
    {
        parent::_after();
    }

    // Public methods
    // =========================================================================
    public function testProperNameInstance(): void
    {
        self::assertInstanceOf(CurrencyConverter::class, CurrencyConverter::$plugin);
    }

    public function testProperNameServiceMatchName(): void
    {
        $result = CurrencyConverter::getInstance()->propernameService->matchName('asset-shutterstock-047682.jpg');
        self::assertArrayHasKey(0, $result); // match shutterstock
    }

    public function testProperNameGetSettings(): void
    {
        $result = CurrencyConverter::getInstance()->getSettings();
        self::assertArrayHasKey('wordList', $result); // has wordList key
        self::assertArrayHasKey('cacheTime', $result); // has cacheTime key
    }

    public function testProperNameWordListHasData(): void
    {
        $result = CurrencyConverter::getInstance()->getSettings()['wordList'];
        self::assertIsArray($result); // wordList is array
        self::assertArrayHasKey(0, $result); // has at least one entry
    }
}
