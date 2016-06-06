1) journey.json 

    {
        "departure": "any place",
        "arrival": "any place",
        "transport": "mode",
        "seat": "number strings",
        "text": "support information text"
    }

Departure and arrival properties should be connected to follow chain please see data/journey.json

and json file is mandatory

2) execute the below lines by including the Journey.php in your code

require_once 'lib\Journey.php';

$cards = Journey::loadJson("data/journey.json");

$obj = new Journey($cards);
$obj->orderTrip();
$JourneyRoutes = $obj->getJourneyPaths();
var_dump($JourneyRoutes);


3) read the php-doc for more info

boardingpasssort/phpdoc/classes/index.html
