<?php
include '/DatabaseConnection.php';
class Result
{
    private $strBuildingName;
    private $strFilterCode;
    private $intRoomNumber;
    private $intSeats;
    private $strRoomUrl;
    private $strEquipmentUrl;
    private $arrEquipment;
    private $intRoomId;
    private $strImageType;

    public function __construct($strBuildingName, $strFilterCode, $intRoomNumber, $intSeats, $intRoomId, $strRoomUrl, $strEquipmentUrl, $strImageType )
    {
        $this->strBuildingName = $strBuildingName;
        $this->strFilterCode = $strFilterCode;
        $this->intRoomNumber = $intRoomNumber;
        $this->intSeats = $intSeats;
        $this->intRoomId = $intRoomId;
        $this->strRoomUrl = $strRoomUrl;
        $this->strEquipmentUrl = $strEquipmentUrl;
        $this->setEquipment($intRoomId);
        $this->strImageType = $strImageType;
    }

    /**
     * getBuildingName
     * Returns the name of the building
     *
     * @return string
     */
    public function getBuildingName()
    {
        return $this->strBuildingName;
    }

    /**
     * getFilterCode
     * Returns the filter code of the building
     *
     * @return string
     */
    public function getFilterCode()
    {
        return $this->strFilterCode;
    }

    /**
     * getRoomNumber
     * Returns the room number
     *
     * @return int
     */
    public function getRoomNumber()
    {
        return $this->intRoomNumber;
    }

    /**
     * getSeats
     * Returns the number of seats in the room
     *
     * @return int
     */
    public function getSeats()
    {
        return $this->intSeats;
    }

    /**
     * getRoomUrl
     * Returns the url of the room image
     *
     * @return string
     */
    public function getRoomUrl()
    {
        return $this->strRoomUrl;
    }

    /**
     * getEquipmentUrl
     * Returns the url of the equipment image
     *
     * @return string
     */
    public function getEquipmentUrl()
    {
        return $this->strEquipmentUrl;
    }

    /**
     * getEquipment
     * Returns an array of equipment in the room
     *
     * @return array
     */
    public function getEquipment()
    {
        //Take the array of equipment and return it as a string with a new line separating each item
        $strEquipment = "";
        foreach($this->arrEquipment as $equipment) {
            $strEquipment .= $equipment . "\n";
        }
        return $strEquipment;
    }

    public function getImageType()
    {
        return $this->strImageType;
    }

    /**
     * setEquipment
     * Sets the equipment array
     *
     * @param int $intRoomId
     */
    public function setEquipment($intRoomId){
        $dbConnection = new DatabaseConnection();
        $sql = "SELECT * FROM classroom_assets_junction as caj, asset_common_names as acn WHERE caj.asset_id = acn.common_name_id AND caj.room_id = $intRoomId ORDER BY acn.common_name";


        foreach($dbConnection->interact($sql) as $row){
            $this->arrEquipment[] = $row['common_name'];
        }
    }

}