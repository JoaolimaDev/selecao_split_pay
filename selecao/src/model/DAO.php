<?php
namespace model;
use PDO;
use model\Database;

  class DAO
  {
    private static $stmt;

    

    public static function select(string $Raw_Query, array $params = array()) : array
    {

      $database = new Database;

      $conn = $database->connect();

      DAO::$stmt = $conn->prepare($Raw_Query);
      
      DAO::setParams($params);

      DAO::$stmt->execute();

  
      return DAO::$stmt->fetchAll(PDO::FETCH_ASSOC);
      
    }

    public static function query(string $Raw_Query, array $params = array()) : bool
    {
      
      $database = new Database;

      $conn = $database->connect();

      DAO::$stmt = $conn->prepare($Raw_Query);
  
      DAO::setParams($params);

      DAO::$stmt->execute();

 
      if (DAO::$stmt->rowCount() == 0) {
        
        return false;
      }

      return true;
      
      
    }

    private static function setParams($parameters = array())
	  {

      foreach ($parameters as $key => $value) {
        
        DAO::bindParam($key, $value);

      }

	  }

	  private static function bindParam($key, $value)
	  {

		  return DAO::$stmt->bindValue($key, $value);

	  }
  }



?>