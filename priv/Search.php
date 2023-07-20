<?php
include 'DatabaseConnection.php';
include 'Building.php';
include 'Technology.php';
include 'Result.php';

class Search
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    /**
     *  getResults
     *  Takes a building id, array of technology ids, and a minimum and maximum capacity for a classroom. Queries the database
     *  and creates a Result object for each result. Returns an array of Result objects.
     *
     * @param string $strBuildingId
     * @param array $arrTechnologyIds
     * @param int $intMinCapacity
     * @param int $intMaxCapacity
     * @return array arrResults
     */
    public function getResults($strBuildingId = 'any', $arrTechnologies = null, $intMinSeats = 0, $intMaxSeats = 500, $strCampus = "Logan"){

        $strFilterTechnologies = "";
        // loop through each technology with key and value
        if($arrTechnologies){
            $strFilterTechnologies .= "HAVING SUM(";
            foreach($arrTechnologies as $intK => $intTechId){
                if($intK < count($arrTechnologies) - 1){
                    $strFilterTechnologies .= "(asset_id = $intTechId) + ";
                } else {
                    $strFilterTechnologies .= "(asset_id = $intTechId)) = " . count($arrTechnologies);
                }
            }
        }

        $strFilterBuilding = "";
        if($strBuildingId != 'any'){
            $strFilterBuilding = "AND building_id = $strBuildingId";
        }

        $strFilterCampus = "AND ca.name = '$strCampus'";


        $stringSql = sprintf("SELECT ca.name, c.image_type, c.name, b.filter_code, b.building_name, c.seats, c.id, c.room_image_url, c.equipment_image_url
                               FROM classrooms as c, building_list as b, campus as ca
                               WHERE c.building_id = b.id AND b.campus = ca.id %s %s AND c.seats BETWEEN %d AND %d
                               AND c.id IN (SELECT room_id
                                            FROM classroom_assets_junction
                                            GROUP BY room_id
                                            %s)
                               ORDER BY b.building_name, c.name",$strFilterBuilding, $strFilterCampus, $intMinSeats, $intMaxSeats, $strFilterTechnologies);


        $arrResults = [];
        foreach($this->dbConnection->interact($stringSql) as $objRow){
            $objResult = new Result($objRow['building_name'], $objRow['filter_code'], $objRow['name'], $objRow['seats'], $objRow['id'], $objRow['room_image_url'], $objRow['equipment_image_url'], $objRow['image_type']);
            $arrResults[] = $objResult;


        }
        return $arrResults;

    }

    /**
     * getBuildings
     * Queries the database and creates a Building object for each result. Returns an array of Building objects.
     *
     * @return array arrBuildings
     */
    public function getAllBuildings(){
        $strSql = "SELECT * FROM building_list ORDER BY building_name";

        $arrBuildings = [];

        foreach($this->dbConnection->interact($strSql) as $objRow){
            $objBuilding = new Building($objRow['id'], $objRow['building_name'], $objRow['filter_code']);
            $arrBuildings[] = $objBuilding;
        }

        return $arrBuildings;
    }

    /**
     * getAllCampuses
     * Queries the database and returns an array of all campuses that have at least one building
     * associated with them.
     *
     * @return array arrCampuses
     */
    public function getAllCampuses(){
        $strSql = "SELECT DISTINCT ca.name as 'campus' FROM building_list as b, campus as ca WHERE b.campus = ca.id ORDER BY ca.name";

        $arrCampuses = [];
        foreach($this->dbConnection->interact($strSql) as $objRow){
            $arrCampuses[] = $objRow['campus'];
        }

        return $arrCampuses;
    }

    /**
     * getBuildingsByCampus
     * Queries the database based on the selected campus and creates a Building object for each result. Returns an array of Building objects.
     *
     * @param $strCampus
     * @return array arrBuildings
     */
    public function getBuildingsByCampus($strCampus){
        $strSql = "SELECT b.id, b.building_name, b.filter_code
                    FROM building_list as b, campus as ca
                    WHERE b.campus = ca.id AND ca.name = '$strCampus' 
                    ORDER BY building_name";

        $arrBuildings = [];
        foreach($this->dbConnection->interact($strSql) as $objRow){
            $objBuilding = new Building($objRow['id'], $objRow['building_name'], $objRow['filter_code']);
            $arrBuildings[] = $objBuilding;
        }

        return $arrBuildings;
    }

    /**
     * getCampusId
     * Queries the database and returns the id of the campus with the given name.
     *
     * @param $strCampusName
     * @return int id
     */
    public function getCampusId($strCampusName){
        $strSql = "SELECT id FROM campus WHERE name = '$strCampusName' LIMIT 1";

        return $this->dbConnection->interact($strSql)[0]['id'];
    }


    /**
     * getGeneralCampusList
     * Queries the database and returns an array of all campuses regardless of if they have any buildings
     * or classrooms in them.
     *
     * @return array arrCampuses
     */
    public function getGeneralCampusList(){
        $strSql = "SELECT id, name FROM campus ORDER BY name";

        $arrCampuses = [];
        foreach($this->dbConnection->interact($strSql) as $objRow){
            $arrRow = [];
            $arrRow['id'] = $objRow['id'];
            $arrRow['name'] = $objRow['name'];
            $arrCampuses[] = $arrRow;
        }

        return $arrCampuses;
    }


    /**
     * getAllTechnologies
     * Queries the database and creates a Technology object for each result. Returns an array of Technology objects.
     *
     * @return array arrTechnologies
     */
    public function getAllTechnologies() {
        $arrTechnologies = [];

        $strFirstSql = "SELECT common_name_id, common_name, status FROM asset_common_names WHERE common_name_id = 29";

        foreach($this->dbConnection->interact($strFirstSql) as $row) {
            $objTechnology = new Technology($row['common_name_id'], $row['common_name'], $row['status']);
            $arrTechnologies[] = $objTechnology;
        }

        $strSql = "SELECT common_name_id, common_name, status FROM asset_common_names WHERE status = 'active' AND common_name_id != 29 ORDER BY common_name";

        foreach($this->dbConnection->interact($strSql) as $row) {
            $objTechnology = new Technology($row['common_name_id'], $row['common_name'], $row['status']);
            $arrTechnologies[] = $objTechnology;
        }

        return $arrTechnologies;

    }

    /**
     * getCompleteTechnologies
     * Queries the database and creates a Technology object for each result. Returns an array of Technology objects.
     *
     * @return array arrTechnologies
     */
    public function getCompleteTechnologies() {
        $arrTechnologies = [];
        $strSql = "SELECT common_name_id, common_name, status FROM asset_common_names WHERE common_name_id != 29 ORDER BY common_name";

        foreach($this->dbConnection->interact($strSql) as $row) {
            $objTechnology = new Technology($row['common_name_id'], $row['common_name'], $row['status']);
            $arrTechnologies[] = $objTechnology;
        }

        return $arrTechnologies;

    }


    /**
     * getClassroomsByBuilding
     * Queries the database and creates a Classroom object for each result. Returns an array of Classroom objects.
     *
     * @param string $strBuildingId
     * @return array arrClassrooms
     */

    public function getClassroomsByBuilding($strBuildingId){
        $strSql = sprintf("SELECT * FROM classrooms WHERE building_id = %s ORDER BY name", $strBuildingId);

        $arrClassrooms = [];

        foreach($this->dbConnection->interact($strSql) as $row){
            $arrClassrooms[] = $row;
        }

        return $arrClassrooms;
    }

    /**
     * getBuildingById
     * Queries the database and creates a Building object for the result. Returns a Building object.
     *
     * @param string $strBuildingId
     * @return array $arrBuilding
     */
    public function getBuildingById($strBuildingId){
        $strSql = sprintf("SELECT * FROM building_list WHERE id = %s", $strBuildingId);

        $arrBuilding = [];

        foreach($this->dbConnection->interact($strSql) as $row){
            $arrBuilding[] = $row;
        }

        return $arrBuilding;
    }


    /**
     * getClassroomById
     * Queries the database and creates a Classroom object for the result. Returns a Classroom object.
     *
     * @param string $strClassroomId
     * @return object $objClassroom
     */
    public function getClassroomById($strClassroomId){
        $strSql = sprintf("SELECT * FROM classrooms WHERE id = %s", $strClassroomId);

        $objClassroom = null;
        foreach($this->dbConnection->interact($strSql) as $row){
            $objClassroom = $row;
        }

        return $objClassroom;
    }

    /**
     * getTechnologiesByClassroom
     * Queries the database and creates a Technology object for each result. Returns an array of Technology objects.
     *
     * @param string $strClassroomId
     * @return array $arrTechnologies
     */
    public function getTechnologiesByClassroom($strClassroomId){
        $strSql = sprintf("SELECT *
                                  FROM classroom_assets_junction as caj, asset_common_names as acn
                                  WHERE caj.asset_id = acn.common_name_id AND room_id = %s", $strClassroomId);

        $arrTechnologies = [];

        foreach($this->dbConnection->interact($strSql) as $row){
            $arrTechnologies[] = $row['common_name_id'];
        }

        return $arrTechnologies;
    }

    /**
     * getClassroomByNameAndBuildingId
     * Queries the database and creates a Classroom object for the result. Returns a Classroom object.
     *
     * @param string $strClassroomName
     * @param int $intBuildingId
     * @return array $objClassroom
     */
    public function getClassroomByNameAndBuildingId($strClassroomName, $intBuildingId){
        $strSql = sprintf("SELECT * FROM classrooms WHERE name = '%s' AND building_id = %d", $strClassroomName, $intBuildingId);

        $objClassroom = null;
        foreach($this->dbConnection->interact($strSql) as $row){
            $objClassroom = $row;
        }

        return $objClassroom;
    }

}