<?php namespace Ozziest\Core\Tests\System;

use PHPUnit_Framework_TestCase;
use Mockery, Exception;
use Ozziest\Core\System\Logger;

class LoggerTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testDB()
    {
        $monolog = Mockery::mock('Monolog\Logger')
                          ->shouldReceive('pushHandler')->times(1)
                          ->shouldReceive('addError')->times(2)
                          ->shouldReceive('addWarning')->times(1)
                          ->mock();
                        
        $logger = new Logger($monolog);
        $logger->error("An error message");
        $logger->warning("A warning message");
        
        try
        {
            throw new Exception();
        }
        catch (Exception $exception)
        {
            $logger->exception($exception);
        }
    }

}