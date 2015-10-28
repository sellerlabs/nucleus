<?php

namespace tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Support\Env;
use Chromabits\Nucleus\Support\Str;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class EnvTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package tests\Chromabits\Nucleus\Support
 */
class EnvTest extends TestCase
{
    public function testSanity()
    {
        $_ENV['NUCLEUS_SANITY_CHECK'] = 'why';
        $_ENV['nucleus_sanity_check'] = 'why :(';
        $_SERVER['NUCLEUS_SANITY_CHECK'] = 'u do this';
        $_SERVER['nucleus_sanity_check'] = 'u do this :(';
        putenv('NUCLEUS_SANITY_CHECK=omg php');
        putenv('nucleus_sanity_check=omg php :(');

        $this->assertEqualsMatrix([
            ['why', $_ENV['NUCLEUS_SANITY_CHECK']],
            ['why :(', $_ENV['nucleus_sanity_check']],
            ['u do this', $_SERVER['NUCLEUS_SANITY_CHECK']],
            ['u do this :(', $_SERVER['nucleus_sanity_check']],
            ['omg php', getenv('NUCLEUS_SANITY_CHECK')],
            ['omg php :(', getenv('nucleus_sanity_check')],
        ]);
    }

    protected function wipe()
    {
        putenv('NUCLEUS_GET');
        unset($_SERVER['NUCLEUS_GET']);
        unset($_ENV['NUCLEUS_GET']);
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->wipe();
    }

    public function testGetRaw()
    {
        putenv('NUCLEUS_GET=omg php');
        $this->assertEquals('omg php', Env::getRaw('NUCLEUS_GET'));

        $_SERVER['NUCLEUS_GET'] = 'u do this';
        $this->assertEquals('u do this', Env::getRaw('NUCLEUS_GET'));

        $_ENV['NUCLEUS_GET'] = 'why';
        $this->assertEquals('why', Env::getRaw('NUCLEUS_GET'));

        $this->assertEquals('lol', Env::getRaw('NUCLEUS_GOT', 'lol'));
        $this->assertEquals('omg', Env::getRaw('NUCLEUS_GOT', function () {
            return 'omg';
        }));
    }

    public function testGet()
    {
        putenv('NUCLEUS_GET=true');
        $this->assertSame(true, Env::get('NUCLEUS_GET'));

        putenv('NUCLEUS_GET=false');
        $this->assertSame(false, Env::get('NUCLEUS_GET'));

        putenv('NUCLEUS_GET=null');
        $this->assertSame(null, Env::get('NUCLEUS_GET', 'lol'));

        putenv('NUCLEUS_GET="this is some text"');
        $this->assertSame('this is some text', Env::get('NUCLEUS_GET'));
    }

    public function testGetOrFail()
    {
        putenv('NUCLEUS_GET=false');
        $this->assertSame(false, Env::getOrFail('NUCLEUS_GET'));
    }

    public function testGetOrFailWithMissing()
    {
        $this->setExpectedException(CoreException::class);

        Env::getOrFail('NUCLEUS_GET');
    }

    public function testSet()
    {
        Env::set('NUCLEUS_GET', 'omg php');
        Env::set('nucleus_get', 'why');

        $this->assertEqualsMatrix([
            ['omg php', $_ENV['NUCLEUS_GET']],
            ['why', $_ENV['nucleus_get']],
            ['omg php', $_SERVER['NUCLEUS_GET']],
            ['why', $_SERVER['nucleus_get']],
            ['omg php', getenv('NUCLEUS_GET')],
            ['why', getenv('nucleus_get')],
        ]);
    }
}
