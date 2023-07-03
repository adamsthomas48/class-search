<?php
include 'autoloader.php';

$objSearch = new Search();

$arrBuildings = $objSearch->getBuildingsByCampus("Logan");
$arrTechnologies = $objSearch->getAllTechnologies();
$arrCampuses = $objSearch->getAllCampuses();

$arrResults = [];




if(isset($_GET['search'])){
    $arrResults = $objSearch->getResults($_GET['building'], $_GET['technologies'], $_GET['minCapacity'], $_GET['maxCapacity'], $_GET['campus']);
    include 'priv/views/results.php';

} else if (isset($_GET['getBuildings'])){
    $arrBuildings = $objSearch->getBuildingsByCampus($_GET['campus']);
    include 'priv/views/building-list.php';
}

else {
    include 'priv/views/search.php';
}
