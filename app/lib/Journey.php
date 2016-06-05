<?php
/**
 * @author:sathish
 * @copyright:
 * @time:
 */
namespace lib;

/**
 * Abstract Class Loadcards
 * @abstracts getcards and setcards def
 */
abstract class LoadCards
{
    protected $cards;
    abstract public function getCards();
    abstract public function setCards($cards);
}
/**
 * Class Journey
 * @extends abstract loadcards
 */
class Journey extends LoadCards
{
    
    /**
     * Json journey string
     * @var $journeyString 
     */
    protected $journeyString;
    
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
     * Constructor to load unordered cards
     * @return type
     */
    public function __construct($filename)
    {
        $this->journeyString = @file_get_contents($filename);
        $this->cards = json_decode($this->journeyString, true);
        if (empty($this->cards)) {
            throw new InvalidArgumentException("Json Content Empty");
        }
    }
      
    /**
     * Get json cards 
     * @return Json Journey Cards
     */
    public function getCards()
    {
        return $this->cards;
    }
    /**
     * Get json cards 
     * @return Json Journey Cards
     */
    public function setCards($cards)
    {
        return $this->cards;
    }
    /**
     * Get departure
     * @return string departure
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Get arrival
     * @return string arrival point 
     */
    public function getArrival()
    {
        return $this->arrival;
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
     * returns sorted cards
     * @param type takes Cards Array from constructor
     * @return json / array sorted array data
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
     * Get transit point
     * @return array journeyPaths 
     */
    public function getPointTransit()
    {
        return $this->pointTransit;
    }
    
    /**
     * Set Journey Paths Summary
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
