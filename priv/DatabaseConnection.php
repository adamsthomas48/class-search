<?php

class DatabaseConnection
{
    private $strServerName = 'mysql02.usu.edu';
    private $strDatabaseName = 'inventory';
    private $strUserName = 'classinvuser';
    private $strPassword = 'xbaAzfnnqZlYX7kUhgUQtzrsd6tSIy7IGCF';
    private $objConnection;

    public function __construct(){}

    /**
     * setConnection
     * Establishes a connection with the database and saves it to the $conn variable.
     * @return void
     */
    public function setConnection()
    {
        try {
            $this->objConnection = new PDO("mysql:host=$this->strServerName;dbname=$this->strDatabaseName;", $this->strUserName, $this->strPassword);
            $this->objConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * interact
     * Interacts with the database and returns the results.
     *
     * @param string $strSql
     * @return void
     */
    public function interact($strSql)
    {
        try {
            $this->setConnection();
            $objStmt = $this->objConnection->prepare($strSql);
            $objStmt->execute();
            $this->objConnection = null;
            if($objStmt->columnCount() > 0){
                return $objStmt->fetchAll();
            }


        } catch (PDOException $e) {

            die("Error: " . $e->getMessage());
        }
    }

    /**
     * insertData
     * Takes a table name, an array of the columns that will be affected, and an array of values that will be inserted for
     * those columns and inserts into the database. This only handles one row at a time and will rollback if there is an issue.
     *
     * @param string $strTableName
     * @param array $arrCols
     * @param array $arrValues
     * @return void
     */
    public function insertData($strTableName, $arrCols, $arrValues)
    {
        $this->setConnection();
        $strCols = implode(', ', $arrCols);
        $stmt = $this->objConnection->prepare(sprintf("INSERT INTO %s (%s) VALUES (%s)", $strTableName, $strCols, $this->setValueString($arrCols)));


        try {
            $this->objConnection->beginTransaction();
            $stmt->execute($arrValues);
            $this->objConnection->commit();
        } catch (Exception $e){
            $this->objConnection->rollback();
            $this->handleError($e);

        }
        $this->objConnection = null;
    }

    /**
     * deleteData
     * Takes a table name, a column name (the name of the column containing the id of the item being deleted) and the item id and removes
     * that row from the database.
     *
     * @param string $strTableName
     * @param string $strColumn
     * @param int $intItemId
     * @return void
     */
    public function deleteData($strTableName, $strColumn, $intItemId){

        try{
            $this->setConnection();
            $sql = 'DELETE FROM ' . $strTableName . ' WHERE ' . $strColumn . ' = ' . $intItemId;
            $stmt = $this->objConnection->prepare($sql);
            $stmt->execute();
            $this->objConnection = null;
        } catch (PDOException $e) {

            die("Error: " . $e->getMessage());
        }
    }

    /**
     * updateData
     * Takes a table name, an array of the columns that will be affected, an array of values that will be inserted for
     * those columns, the name of the column containing the id of the item being updated, and the item id and updates the
     * database with the new values.
     *
     * @param string $strTableName
     * @param array $arrCols
     * @param array $arrValues
     * @param string $strIdColumn
     * @param int $intItemId
     * @return void
     */
    public function updateData($strTableName, $arrCols, $arrValues, $strIdColumn, $intItemId){
        $this->setConnection();
        $strSql = sprintf("UPDATE %s SET %s WHERE %s = %s", $strTableName, $this->createUpdateString($arrCols, $arrValues), $strIdColumn, $intItemId);

        try{
            $stmt = $this->objConnection->prepare($strSql);
            $stmt->execute();
            $this->objConnection = null;
        } catch (PDOException $e) {

            die("Error: " . $e->getMessage());
        }


    }

    /**
     * setValueString
     * Takes an array of columns and returns a string of question marks that is the same length as the array.
     * This is used to create the value string for the insertData function.
     *
     * @param array $arrCols
     * @return string $strValuesTemplate
     */
    private function setValueString($arrCols){
        $strValuesTemplate = str_repeat('?,', sizeof($arrCols) - 1);
        $strValuesTemplate .= '?';

        return $strValuesTemplate;
    }

    /**
     * createUpdateString
     * Takes an array of columns and an array of values and returns a string that can be used in an update statement.
     *
     * @param array $arrCols
     * @param array $arrValues
     * @return string $strUpdateString
     */
    public function createUpdateString($arrCols, $arrValues){
        $strUpdateString = '';
        foreach($arrCols as $key => $column){
            $strUpdateString .= $column . ' = ' . '"' . $arrValues[$key] . '"';

            if($key != sizeof($arrCols) - 1){
                $strUpdateString .= ', ';
            }
        }

        return $strUpdateString;
    }

    /**
     * createExistsString
     * Takes an array of columns and an array of values and returns a string that can be used in an exists statement.
     *
     * @param array $arrCols
     * @param array $arrValues
     * @return string $strExistsString
     */
    public function createExistsString($arrCols, $arrValues){
        $strExistsString = '';
        foreach($arrCols as $key => $column){
            $strExistsString .= $column . ' = ' . '"' . $arrValues[$key] . '"';

            if($key != sizeof($arrCols) - 1){
                $strExistsString .= ' AND ';
            }
        }

        return $strExistsString;
    }

    /**
     * existsInDatabase
     * Used to check if a value exists in the database based on it's columns and values.
     *
     * @param string $strTableName
     * @param array $arrCols
     * @param array $arrValues
     * @return bool
     */
    public function existsInDatabase($strTableName, $arrCols, $arrValues){
        $this->setConnection();
        $strSql = sprintf("SELECT * FROM %s WHERE %s", $strTableName, $this->createExistsString($arrCols, $arrValues));
        $stmt = $this->objConnection->prepare($strSql);
        $stmt->execute();
        $this->objConnection = null;
        if($stmt->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
     * deleteWithMultipleValues
     * Used to delete a row from the database based on multiple columns and values.
     *
     * @param string $strTableName
     * @param array $arrCols
     * @param array $arrValues
     *
     * @return bool
     */
    public function deleteWithMultipleValues($strTableName, $arrCols, $arrValues){
        $this->setConnection();
        $strSql = sprintf("DELETE FROM %s WHERE %s", $strTableName, $this->createExistsString($arrCols, $arrValues));
        echo $strSql . '<br>';

        $stmt = $this->objConnection->prepare($strSql);
        return $stmt->execute();

    }


}