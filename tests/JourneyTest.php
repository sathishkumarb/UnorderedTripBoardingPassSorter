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
    
    public function __construct()
    {
        $this->cards = Journey::loadJson("../data/journey.json");
        $this->obj = new Journey($this->cards);
    }
  
    /** Test Cards loaded are instance and of same type ex: array
     * return void
     */
    public function testJourneyCardsIsInstance()
    {
        $this->obj = new Journey($this->cards);
        $this->obj->orderTrip();
        $this->assertContainsOnlyInstancesOf($this->obj, array());
    }
    
    /** Test File not found json
     * return void
     */
    public function testFileNotFoundException()
    {
        $this->setExpectedException('InvalidArgumentException');
        Journey::loadJson('data/nothing.json');
    }
    
    /** Test invalid 
     * return void
     */
    public function testInvalidJsonException()
    {
        $this->setExpectedException('InvalidArgumentException');
        Journey::loadJson('data/nothing.txt');
    }
        
    /** Test method properties are Null by default
     * return void
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
    
    /** Test Departure null before loaded and not null after loaded card arrays
     * return void
     */
    public function testDepartureIsNullIsNotInit()
    {
        $this->assertNull($this->obj->getDeparture());
        $this->obj->orderTrip();
        $this->assertNotNull($this->obj->getDeparture());
    }
    
    /** Test Arrival null before loaded and not null after loaded card arrays
     * return void
     */
    public function testArrivalIsNullIsNotInit()
    {
        $this->assertNull($this->obj->getArrival());
        $this->obj->orderTrip();
        $this->assertNotNull($this->obj->getArrival());
    }
    
    /** Test Arrival and departure are not equal
     * return void
     */
    public function testDepartureAndArrivalAreNotEqual()
    {
        $this->obj->orderTrip();
        $this->assertNotEquals($this->obj->getDeparture(), $this->obj->getArrival());
    }
    
    /** Test trip cards same type
     * return void
     */
    public function testTripCardsSame()
    {
        $instance = $this->obj->setCards($origin = 'Madrid');
        $this->assertSame($origin, $this->obj->getCards());
        $this->assertSame($instance, $this->obj);
    }
    
    /** Test trip departure same get set
     * return void
     */
    public function testTripDepartureSame()
    {
        $instance = $this->obj->setDeparture($depart = 'Madrid');
        $this->assertSame($depart, $this->obj->getDeparture());
        $this->assertSame($instance, $this->obj);
    }

    /** Test trip arrival same get set
     * 
     */
    public function testTripArrivalSame()
    {
        $instance = $this->obj->setArrival($destination = 'Barcelona');
        $this->assertSame($destination, $this->obj->getArrival());
        $this->assertSame($instance, $this->obj);
    }
    
    /** Test trip transit point same type
     * return void
     */
    public function testPointTransitSame()
    {
        $instance = $this->obj->setPointTransit($destination = 'Barcelona');
        $this->assertSame($destination, $this->obj->getPointTransit());
        $this->assertSame($instance, $this->obj);
    }
    
    /** Test journey paths same type
     * return void
     */
    public function testJourneyPathsSame()
    {
        $instance = $this->obj->setJourneyPaths($paths = $this->cards);
        $this->assertSame($paths, $this->obj->getJourneyPaths());
        $this->assertSame($instance, $this->obj);
    }
}
