<?php
include 'autoloader.php';

$objSearch = new Search();

$arrBuildings = $objSearch->getAllBuildings();
$arrTechnologies = $objSearch->getAllTechnologies();
$arrCampuses = $objSearch->getAllCampuses();

echo var_dump($arrCampuses);

$arrResults = [];




if(isset($_GET['search'])){
    $arrResults = $objSearch->getResults($_GET['building'], $_GET['technologies'], $_GET['minCapacity'], $_GET['maxCapacity']);
    include 'priv/views/results.php';

} else {
    include 'priv/views/search.php';
}
