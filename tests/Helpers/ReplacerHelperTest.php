<?php namespace Ozziest\Core\Tests\Helpers;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Helpers\ReplacerHelper;

class ReplacerHelperTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testInit()
    {
        $content = new ReplacerHelper("Hello {NAME}!");
        $content->replace('NAME', 'Foo Bar');
        $this->assertEquals($content->toString(), 'Hello Foo Bar!');
    }

}