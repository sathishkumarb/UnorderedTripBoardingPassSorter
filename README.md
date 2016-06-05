1) journey.json 

    {
        "departure": "any place",
        "arrival": "any place",
        "transport": "mode",
        "seat": "number strings",
        "text": "support information text"
    }

Departure and arrival properties should be connected to follow chain please see journey.jsn

and json file is mandatory

2) execute the below lines by calling the Journey.php in your code
$obj = new Journey();
$obj->journeySummary();
