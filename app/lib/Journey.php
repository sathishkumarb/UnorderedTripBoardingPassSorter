<?php
/**
 * @author:sathish
 * @copyright:
 * @time:
 */
namespace lib;

class Journey{
    
        /*
         * @var $journeyString 
         */
	protected $journeyString;
        /*
         * @var jsonJourneyCards
         */
	protected $jsonJourneyCards;
        /*
         * @var $arrival to the final point
         */
	protected $arrival;
        /*
         * @var $departure from start point
         */
	protected $departure;
        /*
         * @var $pointTransit is to transition point in between
         */
	protected $pointTransit;
        /*
         * @var $journeyPaths
         */
	protected $journeyPaths;
        /*
         * @param type
         * @return type
         */
	function __construct($filename){
            $this->journeyString = @file_get_contents($filename);
            $this->jsonJourneyCards = json_decode($this->journeyString, true);

            if (empty($this->jsonJourneyCards)) {
                throw new InvalidArgumentException("Json Content Empty");
            }
	}
        
        /*
         * @param string
         * @return string departure
         */
        public function getDeparture(){
            return $this->departure;
        }
        
        /*
         * @param 
         * @return Json Journey Cards
         */
        public function getJourneyCards(){
            return $this->jsonJourneyCards;
        }
        
        /*
         * @param string
         * @return string arrival point 
         */
        public function getArrival(){
            return $this->arrival;
        }
        /*
         * @param 
         * @return array journeyPaths 
         */
        public function getJourneyPaths(){
            return $this->journeyPaths;
        }
        
        /*
         * @param type takes Cards Array from constructor
         * @return json / array sorted array data
         * @desc function summaries the unordered card to sorted card and retuns array of jounery cards
         */
	public function journeySummary(){

		//To find atleast departure and arrival colummns that ocuurs in cards once,by splitting up the columns of departure and arrival
		if ( count($this->jsonJourneyCards) > 0 ) {
			
                    foreach( $this->jsonJourneyCards as $value ){

                        if (!in_array($value['arrival'],array_column($this->jsonJourneyCards, 'departure'))){
                                $this->arival = $value['arrival'];
                        }

                        if (!in_array($value['departure'],array_column($this->jsonJourneyCards, 'arrival'))){
                                $this->departure = $value['departure'];
                        }
                    }

                    $this->pointTransit = $this->getDeparture();
                    $this->journeyPaths = array();
                    
                    // Loop Till Departure is not arrival on cards with temporary transit point
                    while( $this->pointTransit != $this->arival ) { 
                        foreach ( $this->jsonJourneyCards as $index => $path ) {
                            // Move Pointer if boarding card arrival mathces next pointer departure
                            if ( $path['departure'] == $this->pointTransit )  {
                                $this->journeyPaths[] = $path;
                                $this->pointTransit = $path['arrival']; 
                                unset($this->jsonJourneyCards[$index]);
                            }
                        }
                    }
                }
                return false;
	}
}
?>
