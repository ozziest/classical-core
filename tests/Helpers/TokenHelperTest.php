<?php namespace Ozziest\Core\Tests\Helpers;

use PHPUnit_Framework_TestCase;
use Mockery;
use Ozziest\Core\Helpers\TokenHelper;

class TokenHelperTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        putenv("app_key=my_secret_key");
    }

    public function testTokenHelper()
    {
        $this->assertTrue(TokenHelper::hash('value') !== 'value');
        $this->assertTrue(TokenHelper::generate() !== TokenHelper::generate());
        $this->assertTrue(TokenHelper::salt('foo1@bar.com', '123456') !== TokenHelper::salt('foo2@bar.com', '123456'));
    }        
    
}