<?php
/**
 * Class JourneyTest
 *
 * @author    Sathish
 * @link      https://github.com/sathishkumarb/UnorderedTripBoardingPassSorter
 * @copyright null
 */

class JourneyTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * @var cards
     */
    protected $cards;
    
    /**
     * @var obj
    */
    protected $obj;
    
    public function __construct(){
        $this->cards = Journey::loadJson("../data/journey.json");
        $this->obj = new Journey($this->cards);
    }
    /** Test method properties are Null by default
     * 
     */
    public function testFieldsAreNullByDefault()
    {
        $this->obj = new Journey(null);
        $this->assertNull($this->obj->getCards());
        $this->assertNull($this->obj->getDeparture());
        $this->assertNull($this->obj->getArrival());
        $this->assertNull($this->obj->getJourneyPaths());
        $this->assertNull($this->obj->getPointTransit());
    }

    /** Test Cards loaded are instance and of same type ex: array
     * 
     */
    public function testJourneyCardsIsInstance()
    {
        $this->obj = new Journey($this->cards);
        $this->obj->orderTrip();
        $this->assertContainsOnlyInstancesOf($this->obj, array() );
    }
    
    /** Test Departure null before loaded and not null after loaded car arrays
     * 
     */
    public function testDepartureIsNullIfTripIsNotInit()
    {
        
        $this->assertNull($this->obj->getDeparture());
        $this->obj->orderTrip();
        $this->assertNotNull($this->obj->getDeparture());
    }
    
    /** Test Arrival null before loaded and not null after loaded car arrays
     * 
     */
    public function testArrivalIsNullIfTripIsNotInit()
    {
        $this->assertNull($this->obj->getArrival());
        $this->obj->orderTrip();
        $this->assertNotNull($this->obj->getArrival());
    }
    
    public function testDepartureAndArrivalAreDifferent()
    { 
        $this->obj->orderTrip();
        $this->assertNotEquals($this->obj->getDeparture(), $this->obj->getArrival());
    }
        
    public function testTripCards()
    {
        $instance = $this->obj->setCards($origin = 'Madrid');
        $this->assertSame($origin, $this->obj->getCards());
        $this->assertSame($instance, $this->obj);
    }
    
    public function testTripDeparture()
    {
        $instance = $this->obj->setDeparture($depart = 'Madrid');
        $this->assertSame($depart, $this->obj->getDeparture());
        $this->assertSame($instance, $this->obj);
    }

    public function testTripArrival()
    {
        $instance = $this->obj->setArrival($destination = 'Barcelona');
        $this->assertSame($destination, $this->obj->getArrival());
        $this->assertSame($instance, $this->obj);
    }
    
    public function testPointTransit()
    {
        $instance = $this->obj->setPointTransit($destination = 'Barcelona');
        $this->assertSame($destination, $this->obj->getPointTransit());
        $this->assertSame($instance, $this->obj);
    }
    
    public function testJourneyPaths()
    {
        $instance = $this->obj->setJourneyPaths($paths = $this->cards);
        $this->assertSame($paths, $this->obj->getJourneyPaths());
        $this->assertSame($instance, $this->obj);
    }

 } 
    
