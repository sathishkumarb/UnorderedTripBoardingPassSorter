<?php
/**
 * @author:sathish
 * @copyright:
 * @time:
 */
namespace lib;

class Journey
{
    
    /**
     * Json journey string
     * @var $journeyString 
     */
    protected $journeyString;
    /**
     * Json jounery cards
     * @var jsonJourneyCards
     */
    protected $jsonJourneyCards;
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
        $this->jsonJourneyCards = json_decode($this->journeyString, true);

        if (empty($this->jsonJourneyCards)) {
            throw new InvalidArgumentException("Json Content Empty");
        }
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
     * Get json cards 
     * @return Json Journey Cards
     */
    public function getJourneyCards()
    {
        return $this->jsonJourneyCards;
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
        if (count($this->jsonJourneyCards) > 0) {
            foreach ($this->jsonJourneyCards as $value) {
                if (!in_array($value['arrival'], array_column($this->jsonJourneyCards, 'departure'))) {
                    $this->arrival = $value['arrival'];
                }

                if (!in_array($value['departure'], array_column($this->jsonJourneyCards, 'arrival'))) {
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
     * Get Journey Summary
     * @return array journeyPaths 
     */
    public function journeySummary()
    {
        $this->journeyPaths = array();

        // Loop Till Departure is not arrival on cards with temporary transit point
        while ($this->pointTransit != $this->arrival) {
            foreach ($this->jsonJourneyCards as $index => $path) {
                // Move Pointer if boarding card arrival mathces next pointer departure
                if ($path['departure'] == $this->pointTransit) {
                    $this->journeyPaths[] = $path;
                    $this->pointTransit = $path['arrival'];
                    unset($this->jsonJourneyCards[$index]);
                }
            }
        }
        return false;
    }
}
