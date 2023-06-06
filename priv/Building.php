<?php

class Building
{
    private $intId;
    private $strName;
    private $strFilterCode;

    public function __construct($intId, $strName, $strFilterCode)
    {
        $this->intId = $intId;
        $this->strName = $strName;
        $this->strFilterCode = $strFilterCode;
    }

    /**
     * getId
     * Returns the id of the building
     *
     * @return int
     */
    public function getId()
    {
        return $this->intId;
    }

    /**
     * getName
     * Returns the name of the building
     *
     * @return string
     */
    public function getName()
    {
        return $this->strName;
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
    
}