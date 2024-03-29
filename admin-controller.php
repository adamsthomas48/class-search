<?php

include 'autoloader.php';

$currentPageUrl = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$urlComponents = parse_url($currentPageUrl);
parse_str($urlComponents['query'], $params);
$intBuildingId = $params["building_id"];
$strBuildingCode = $params["building_code"];
$arrPathParts = explode('/', $urlComponents['path']);
$strCampusUrl = end($arrPathParts);
$strAccessGroup = str_replace('-', ' ', $strCampusUrl);
$strAccessGroup = ucfirst($strAccessGroup);
$arrWords = explode(" ", $strAccessGroup);
if (count($arrWords) > 1) {
    $arrWords[1] = ucfirst($arrWords[1]);
    $strAccessGroup = implode(" ", $arrWords);
}

$baseUrl = 'https://classroomsupport.usu.edu/development/classroom_information/admin/' . end($arrPathParts);


$objSearch = new Search();
$objDbConnection = new DatabaseConnection();
$arrCampusList = $objSearch->getGeneralCampusList();
$intCampusId = $objSearch->getCampusId($strAccessGroup);

$arrAllTech = $objSearch->getAllTechnologies();
if(isset($_GET['deleteAsset'])){
    $objDbConnection->deleteData('asset_common_names', 'common_name_id', $_GET['assetId']);
}

if(isset($_GET['deleteClassroom'])){
    $objDbConnection->deleteData('classrooms', 'id', $_GET['classroomId']);
}

if($params["add_building"]){
    $arrCampuses = $objSearch->getAllCampuses();

    include 'priv/views/add-building.php';
}
else if($params["add_classroom"]){

    include 'priv/views/add-classroom.php';
}
else if($params["edit_tech"]){
    $arrAllTech = $objSearch->getCompleteTechnologies();
    include 'priv/views/edit-tech.php';
}
else if($params["update_classroom"]){
    $objClassroomInfo = $objSearch->getClassroomById($params["classroom_id"]);
    $strBuildingCode = $params["building_code"];

    $arrClassTech = $objSearch->getTechnologiesByClassroom($params["classroom_id"]);


    include 'priv/views/update-classroom.php';
}
else if($params["building_id"]){
    $arrClassrooms = $objSearch->getClassroomsByBuilding($params["building_id"]);
    $objBuildingInfo = $objSearch->getBuildingById($params["building_id"])[0];
    include 'priv/views/admin-building.php';
} else {


    $arrBuildings = $objSearch->getBuildingsByCampus($strAccessGroup);

    include 'priv/views/admin.php';
    if($strAccessGroup == "Logan"){
        $arrCampusList = $objSearch->getGeneralCampusList();
        include 'priv/views/campus-list.php';
    }
}
/**
 * Logic from add-building.php
 */
if(isset($_POST['submit-add-building'])){
    $strBuildingName = $_POST['building-name'];
    $strBuildingCode = $_POST['building-code'];

    $arrCols = array("id", "building_name", "filter_code", "campus");

    if($strAccessGroup == "Logan"){
        $strCampus = 1;
    } else {
        $strCampus = $objSearch->getCampusId($strAccessGroup);
    }

    $arrValues = array(null, $strBuildingName, $strBuildingCode, $strCampus);
    $objDbConnection->insertData('building_list', $arrCols, $arrValues);

    echo '<p class="text-bold text-center">Building Added!</p>';
}

/**
 * Logic from add-classroom.php
 */
if(isset($_POST['submit-add-classroom'])){
    $strRoomName = $_POST['room-name'];
    $strRoomImage = "/classroom-technology-images/" . $strCampusUrl . "/" . $_POST['room-image-url'];
    $strEquipmentImage = "/classroom-technology-images/" . $strCampusUrl . "/" . $_POST['equipment-image-url'];
    $strSeatCapacity = $_POST['seat-capacity'];
    $arrTech = $_POST['tech'];
    $strImageType = $_POST['image-type'];

    $arrCols = array("id", "name", "building_id", "seats", "room_image_url", "equipment_image_url", "image_type");
    $arrValues = array(null, $strRoomName, $intBuildingId, $strSeatCapacity, $strRoomImage, $strEquipmentImage, $strImageType);
    $objDbConnection->insertData('classrooms', $arrCols, $arrValues);

    $objNewClassroom = $objSearch->getClassroomByNameAndBuildingId($strRoomName, $intBuildingId);

    $arrTechCols = array("room_id", "asset_id");
    foreach($arrTech as $intTechId){
        $arrTechValues = array($objNewClassroom['id'], $intTechId);
        $objDbConnection->insertData('classroom_assets_junction', $arrTechCols, $arrTechValues);
    }


    echo '<p class="text-bold text-center">Classroom Added!</p>';
    redirect($baseUrl.'?building_id='.$intBuildingId);
}

/**
 * Logic from update-classroom.php
 */
if(isset($_POST['update-tech'])){
    $arrTech = $_POST['tech'];

    foreach($arrAllTech as $objTech){
        if(in_array($objTech->getId(), $arrTech)){
            $objDbConnection->updateData("asset_common_names", array("status"), array("active"), "common_name_id", $objTech->getId());
        } else {
            $objDbConnection->updateData("asset_common_names", array("status"), array("inactive"), "common_name_id", $objTech->getId());
        }
    }
    redirect($baseUrl ."?edit_tech=true");
}
if(isset($_POST['create-tech'])) {
    $strAssetName = $_POST['asset-name'];
    $objDbConnection->insertData("asset_common_names", array("common_name", "status"), array($strAssetName, "active"));

    redirect($baseUrl . "?edit_tech=true");
}
if(isset($_POST['delete'])){
    $objDbConnection->deleteData("asset_common_names", "common_name_id", $_POST['delete']);
    redirect($baseUrl ."?edit_tech=true");
}


/**
 * Logic from update-classroom.php
 */
if(isset($_POST['update-classroom'])){
    $strClassroomName = $_POST['classroom-name'];
    $strClassroomImage = $_POST['classroom-image'];
    $strEquipmentImage = $_POST['equipment-image'];
    $intClassroomCapacity = $_POST['classroom-capacity'];
    $strImageType = $_POST['image-type'];
    $arrTech = $_POST['tech'];



    $arrCols = array("name", "room_image_url", "equipment_image_url", "seats", "image_type");
    $arrValues = array($strClassroomName, $strClassroomImage, $strEquipmentImage, $intClassroomCapacity, $strImageType);

    $objDbConnection->updateData('classrooms', $arrCols, $arrValues, 'id', $params['classroom_id']);

    $arrTechCols = array("room_id", "asset_id");
    foreach($arrAllTech as $objTech){
        $arrTechValues = array($params['classroom_id'], $objTech->getId());
        if($arrTech == null){
            $objDbConnection->deleteWithMultipleValues('classroom_assets_junction', $arrTechCols, $arrTechValues);
        } else {
            if(in_array($objTech->getId(), $arrTech)){
                if(!$objDbConnection->existsInDatabase('classroom_assets_junction', $arrTechCols, $arrTechValues)){
                    $objDbConnection->insertData('classroom_assets_junction', $arrTechCols, $arrTechValues);
                }

            } else {
                if($objDbConnection->existsInDatabase('classroom_assets_junction', $arrTechCols, $arrTechValues)){
                    $objDbConnection->deleteWithMultipleValues('classroom_assets_junction', $arrTechCols, $arrTechValues);
                }
            }
        }

    }

    echo '<p class="text-bold text-center">Classroom Updated!</p>';

    redirect($baseUrl .'?building_id=' . $objClassroomInfo['building_id'] );
}

function redirect($url){
    echo '<script>window.location.href = "' . $url . '";</script>';
}

