<?php  

/**
 * 
 */
class Database1 
{
	//Datbase constant
	$hostName ="localhost";
	$databaseName="quote_api";
	$databaseUserName = "root";
	$databasePassword = "";
	$pdo = null;
	
	function __construct(argument)
	{
		$this->pdo = new PDO("mysql:host=$this->hostName;dbname=$this->databaseName",$this->databaseUserName,$this->databasePassword);
		$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
		$TIS->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		try {
			
		} catch (PDOException $e) {

			echo "Erorr" . $e->getMessage;
			
		}
	}
}