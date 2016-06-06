<?php
/**
 * @author:sathish
 * @copyright:
 * @link      https://github.com/sathishkumarb/UnorderedTripBoardingPassSorter
 */
//namespace lib;
use Exception as Exception;

/**
 * Abstract Class Loadcards
 * @abstracts getcards and setcards def
 */
abstract class LoadCards
{
    /**
     * Cards array
     * @var $cards 
     */
    protected $cards;
    /**
     * abstract get set cards
     * @return array cards
     */
    abstract public function getCards();
    /**
     * abstract get set cards
     * @return null
     */
    abstract public function setCards($cards);
     /**
     * LoadJson to define body
     * @return array cards
     */
    public static function loadJson()
    {
    }
}
/**
 * Class Journey
 * @extends abstract loadcards
 */
class Journey
{
    
    /**
     * Final point
     * @var $arrival 
     */
    protected $arrival;
    
    /**
     * Start point
     * @var $departure 
     */
    protected $departure;
    
    /**
     * Transition point in between
     * @var $pointTransit 
     */
    protected $pointTransit;
    
    /**
     * Journey paths final array
     * @var $journeyPaths
     */
    protected $journeyPaths;
    /**
     * LoadJson to load unordered cards
     * @return type
     */
    public function __construct($cards)
    {
        $this->setCards($cards);
    }
    
    
    /**
     * Function LoadJson to load unordered cards from json and gets overriden from inheried class
     * @return array cards
     */
    public static function loadJson($filename)
    {
        $journeyString = @file_get_contents($filename);
        $cards = json_decode($journeyString, true);
        if ($cards == null) {
            throw new InvalidArgumentException("JSON Invalid");
        }
        return $cards;
    }
   
    /**
     * Get Cards 
     * @return array cards
     */
    public function getCards()
    {
        return $this->cards;
    }
    /**
     * Set Cards 
     * @return array Cards
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
        return $this;
    }
    
    /**
     * Set departure
     * @return string departure
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;
        return $this;
    }
    
    /**
     * Get Departure
     * @return string departure
     */
    public function getDeparture()
    {
        return $this->departure;
    }
    
     /**
     * Set arrival
     * @return string this
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;
        return $this;
    }

    /**
     * Get arrival
     * @return string arrival
     */
    public function getArrival()
    {
        return $this->arrival;
    }
    
    /**
     * Set journey paths
     * @return array journey paths
     */
    public function setJourneyPaths($journeyPaths)
    {
        $this->journeyPaths = $journeyPaths;
        return $this;
    }
    
    /**
     * Get journey paths
     * @return array journeyPaths 
     */
    public function getJourneyPaths()
    {
        return $this->journeyPaths;
    }
        
    /**
     * Extracts the departure and arrival column to find minimum occurence in array of cards
     * @param type takes Cards Array from constructor
     * @return array sorted array data
     */
    public function orderTrip()
    {
        //To find atleast departure and arrival colummns that ocuurs in cards once,by splitting up the columns of departure and arrival
        if (count($this->cards) > 0) {
            foreach ($this->cards as $value) {
                if (!in_array($value['arrival'], array_column($this->cards, 'departure'))) {
                    $this->arrival = $value['arrival'];
                }

                if (!in_array($value['departure'], array_column($this->cards, 'arrival'))) {
                    $this->departure = $value['departure'];
                }
            }
            $this->pointTransit = $this->getDeparture();
            $this->journeySummary();
        }
    }
    
    /**
     * Set transit point
     * @return string transit point
     */
    public function setPointTransit($pointTransit)
    {
        $this->pointTransit = $pointTransit;
        ;
        return $this;
    }
    
    /**
     * Get transit point
     * @return string transit point
     */
    public function getPointTransit()
    {
        return $this->pointTransit;
    }
    
    /**
     * Sorts and orders the departure and arrival 
     * @return void
     */
    public function journeySummary()
    {
        $this->journeyPaths = array();

        // Loop Till Departure is not arrival on cards with temporary transit point
        while ($this->pointTransit != $this->arrival) {
            foreach ($this->cards as $index => $path) {
                // Move Pointer if boarding card arrival mathces next pointer departure
                if ($path['departure'] == $this->pointTransit) {
                    $this->journeyPaths[] = $path;
                    $this->pointTransit = $path['arrival'];
                    unset($this->cards[$index]);
                }
            }
        }
        return false;
    }
}
