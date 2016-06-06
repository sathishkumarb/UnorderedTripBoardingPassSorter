<?php
spl_autoload_register('AutoLoader');

function AutoLoader($className)
{
    
    require_once 'app\/'.$className . '.php';
    //Make your own path, Might need to use Magics like ___DIR___
}

use lib as Jour;

$obj = new Jour\Journey(basename("../data/journey.json"));

/**
 * Class CardTtest
 *
 * @author    Julien Guittard <julien@youzend.com>
 * @link      http://github.com/jguittard/tripsorter for the canonical source repository
 * @copyright Copyright (c) 2014 Julien Guittard
 */
class JourneyTest extends PHPUnit_Framework_TestCase
{

    public function testPropertiesAreNullByDefault()
    {
        $this->assertNull($this->card->getDeparture());
        $this->assertNull($this->card->getArrival());
        $this->assertNull($this->card->getCards());
        $this->assertNull($this->card->getTransitPoint());
        $this->assertNull($this->card->getJourneyPaths());
    }

    
} 