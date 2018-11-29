<?php
/**
 * 
 */
class Database
{
	//DB Parametars

	private $hostName="localhost";
	private $DBName="quotes_api";
	private $password ="";
	private $userName="root";
	private $pdo;
	
	public function __construct()
	{
	  $this->pdo=null;

		try {

	  $this->pdo = new PDO("mysql:host=$this->hostName;dbName=$this->DBName",$this->userName,$this->password);
	  $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	  $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);	
	  //echo "Connected";
			
		} catch (PDOException $e) {

			echo "Error :".$e->getMessage();
			
		}
	 
	}

	public function fetchAll($query){
      $stmt = $this->pdo->prepare($query);
      $stmt->execute();
      $rows = $stmt->rowCount();
      if ($rows <= 0) {
      	return 0;
      }else{
      	return $stmt->fetchAll();
      }

	}

	public function fetchOne($query ,$parameter){
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$parameter]);
        $rows = $stmt->rowCount();

        if ($rows <= 0) {
        	return 0;
        }else{

        	return $stmt->fetch();
        }

	}

	public function executeCall($userName,$calls_allowed,$timeOutSeconds){

		$query = "SELECT plan ,calls_made,$time_start,$time_end
                         FROM users
                         WHERE username = '$userName' 
		                  ";
		$stmt = $this->pdo->prepare();
		$stmt->execute([$userName]);
		$results = $stmt->fetch();

		//VARIABLE NEEDED 
		// IF IT IS TIMEOUT OR EQUAL TO ZERO SET TO TRUE

		$timeOut = datetime(time())-$results['time_start'] >= $timeOutSeconds || 
		$results['time_start'] === 0;

		//UPDATE CALLS MADE RESPECE TO TIMEOUT 
		$query = "UPDATE users 
		         SET calls_made = ";
		$query .= $timeOut ? "1,time_start =".datetime(time()).", time_end =".strtotime("+$timeOutSeconds seconds") : "calls_made + 1";
		$query .= " WHERE username = ?";

		//INSTEED OF FETCHING AGAIN USING SELECT ALL UPDATE VARIABLES
        $results['calls_made'] = $timeOut ? 1 : $calls_made + 1;
        $results['time_end'] = $timeOut ? strtotime("+ $timeOutSeconds seconds") : $results['time_end'];

        //EXCUTE CODE WITH RESPECT TO PLANS
        if ($results['plan'] === "unlimited") {
         	$stmt = $this->pdo->prepare($query);
         	$stmt->execute([$userName]);
         	return $results;
         }else{

         	//IF NOT TIME OUT AND CALLS MADE IS GREATER THAN CALL ALLOWED RETURN -1 ;

         	if ($timeOut === false && $result["calls_made"] >= $calls_allowed) {
         		
              return -1 ;
         	}else{
         		//GRANT ACCESS
         		$stmt = $this->pdo->prepare($query);
         		$stmt->execute([$username]);
         		return $results;
         	}
         }

	}

	public function insertOne($query ,$body,$user_id,$category_id,$date){
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$body,$user_id,$category_id,$date]);

	}

	public function updateOne($query,$body,$category_id,$date,$id){

		$stmt =$this->pdo->prepare($query);
		$stmt->prepare([$body,$category_id,$date,$id]);		

	}

	public function deleteOne($query,$id){
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$id]);

	}

	public function insertUser($query,$firstName,$lastName,$password,$userName){
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$firstName,$lastName,$password,$userName]);

	}


}