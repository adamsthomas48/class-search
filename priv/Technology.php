<?php

class Technology
{
    private $intId;
    private $strName;
    private $strStatus;

    public function __construct($intId, $strName, $strStatus)
    {
        $this->intId = $intId;
        $this->strName = $strName;
        $this->strStatus = $strStatus;

    }

    /**
     * getId
     * Returns the id of the technology
     *
     * @return int $intId
     */
    public function getId(){
        return $this->intId;
    }

    /**
     * getName
     * Returns the name of the technology
     *
     * @return string $strName
     */
    public function getName(){
        return $this->strName;
    }

    /**
     * getStatus
     * Returns the status of the technology
     *
     * @return string $strStatus
     */
    public function getStatus(){
        return $this->strStatus;
    }
}