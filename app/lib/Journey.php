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
         * @var $passDetails
         */
	protected $passDetails;
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
         * @var $journeypaths
         */
	protected $journeyPaths;
        /*
         * @param type
         * @return type
         */
	function __construct($filename){
            $this->journeyString = @file_get_contents($filename);
            $this->passDetails = json_decode($this->journeyString, true);

            if (empty($this->passDetails)) {
                throw new InvalidArgumentException("Content Empty");
            }
	}
        
        /*
         * @param type
         * @return type departure
         */
        public function getDeparture(){
            return $this->departure;
        }
        
        /*
         * @param type
         * @return type deaprture 
         */
        public function getArrival(){
            return $this->arrival;
        }
        /*
         * @param type
         * @return json / array sorted array data
         */
	public function journeySummary(){

		//find the one occurence of departure and arrival place
		if (count($this->passDetails)) {
			
			foreach ($this->passDetails as $value){
		
				if (!in_array($value['arrival'],array_column($this->passDetails, 'departure'))){
					$this->arival = $value['arrival'];
				}

				if (!in_array($value['departure'],array_column($this->passDetails, 'arrival'))){
					$this->departure = $value['departure'];
				}
			}

		$this->pointTransit = $this->departure;
	        $this->journeypaths = array();
	        
	        while ($this->pointTransit != $this->arival) { // check till departure place is not equal to arrival with temp assingation move poointer to  next deaprtue with arrival on trnasit
	            foreach ($this->passDetails as $index => $path) {
	                if ($path['departure'] == $this->pointTransit)  {
	                    $this->journeypaths[] = $path;
	                    $this->pointTransit = $path['arrival']; // replace 
	                    unset($this->passDetails[$index]);
	                }
	            }
	        }
		}
		if ( !empty($this->journeypaths) ) {
                    foreach($this->journeypaths as $index => $path){
                            echo ($index + 1). ") from ". $path['departure'].  " To ". $path['arrival'] . " , Transport seat".  $path['seat'] . ", ".$path['text']."<br>";
                    }
                }
	}
}
?>
