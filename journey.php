<?php
class Journey{
	protected $journey_string;
	protected $passDetails;
	protected $arivalFinal;
	protected $departureFinal;
	protected $pointTransit;
	protected $journeypaths;
	function __construct(){

		$this->journey_string = file_get_contents(basename("/journey.json"));
		$this->passDetails = json_decode($this->journey_string, true);
	}

	public function journeySummary(){

		//find the one occurence of departure and arrival place
		if (count($this->passDetails)) {
			
			foreach ($this->passDetails as $value){
		
				if (!in_array($value['arrival'],array_column($this->passDetails, 'departure'))){
					$this->arivalFinal = $value['arrival'];
				}

				if (!in_array($value['departure'],array_column($this->passDetails, 'arrival'))){
					$this->departureFinal = $value['departure'];
				}
			}

		 	$this->pointTransit = $this->departureFinal;
	        $this->journeypaths = array();
	        
	        while ($this->pointTransit != $this->arivalFinal) { // check till departure place is not equal to arrival with temp assingation move poointer to  next deaprtue with arrival on trnasit
	            foreach ($this->passDetails as $index => $path) {
	                if ($path['departure'] == $this->pointTransit)  {
	                    $this->journeypaths[] = $path;
	                    $this->pointTransit = $path['arrival']; // replace 
	                    unset($this->passDetails[$index]);
	                }
	            }
	        }
		}
		if (count($this->journeypaths))
		foreach($this->journeypaths as $index => $path){
			echo ($index + 1). ") from ". $path['departure'].  " To ". $path['arrival'] . " , Transport seat".  $path['seat'] . ", ".$path['text']."<br>";
		}
	}
}
$obj = new Journey();
$obj->journeySummary();
?>
