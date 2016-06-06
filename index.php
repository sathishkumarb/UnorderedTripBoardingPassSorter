<?php
/* 
 * @author:Sathish
 * @copyright:nil
 * @time:05-06-2016
 * @desc: loads the clasess and using namespaces to refer and load class and initiate class jounery methods with json input
 */

require_once 'lib\Journey.php';

$cards = Journey::loadJson("data/journey.json");

$obj = new Journey($cards);
$obj->orderTrip();
$JourneyRoutes = $obj->getJourneyPaths();
?>
<html>
    <style>
         body {background-color:lightgrey;} h1 {color:blue;} p {color:green;}
    </style>
    <body>
        <h1>Trip Sort List</h1>
<?php
if (!empty($JourneyRoutes) && count($JourneyRoutes)) {
    foreach ($JourneyRoutes as $index => $path) {
        echo "<p>".($index + 1). ") Take ".$path['transport']." from ". $path['departure'].  " To ". $path['arrival'] . ", Seat :".  $path['seat'] . " , ".$path['text']."</p><br>";
    }
    echo "<p>". ($index + 2) . ") You have reached final destination</p>";
}
?>
    </body>
</html>
