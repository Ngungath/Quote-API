<?php
/**
 * 
 */
class Quote
{
	private $db;
	
	function __construct(Database $db)
	{
	  $this->db =$db;
	}

	public function fetchAllQuotes(){

		$query = "SELECT
        quotes.id,quotes.body,quotes.date,users.firstName,users.lastName,categories.name AS
        categoryName FROM quotes
        LEFT JOIN users on quotes.user_id = users.id
        LEFT JOIN categories on quotes.category_id = categories.id
		";

		return $this->db->fetchAll($query);

	}

	public function fetchOneQuote($parameter){


		$query = "SELECT
        quotes.id,quotes.body,quotes.date,users.firstName,users.lastName,categories.name AS
        categoryName FROM quotes
        LEFT JOIN users on quotes.user_id = users.id
        LEFT JOIN categories on quotes.category_id = categories.id
        WHERE quotes.id = ?";

		return $this->db->fetchOne($query,$parameter);


	}

	public function fetchRandomQuotes($limit){


		$query = "SELECT
        quotes.id,quotes.body,quotes.date,users.firstName,users.lastName,categories.name AS
        categoryName FROM quotes
        LEFT JOIN users on quotes.user_id = users.id
        LEFT JOIN categories on quotes.category_id = categories.id
        ORDER BY RAND()
        LIMIT $limit";

		return $this->db->fetchAll($query);


	}

	public function fetchUsersQuotes($id){


		$query = "SELECT
        quotes.id,quotes.body,quotes.date,users.firstName,users.lastName,categories.name AS
        categoryName FROM quotes
        LEFT JOIN users on quotes.user_id = users.id
        LEFT JOIN categories on quotes.category_id = categories.id
        WHERE users.id = '$id'
        ORDER BY quotes.date ";

		return $this->db->fetchAll($query);


	}

	public function insertQuotes($parameters ,$user_id){

		 $query = "INSERT INTO quotes(body,user_id,category_id,date) VALUES(?,?,?,?)";

		 if (isset($parameters->body) && isset($parameters->category_id)) {
		 	
		 	$body = $parameters->body;
		 	$category_id = $parameters->category_id;
		 	$user_id = $parameters->user_id;
		 	$date = date('d/m/Y');
		 	$this->db->insertOne($query,$body,$user_id,$category_id,$date);
		 }

	}

	public function updateQuote($parameters){

		$query = "UPDATE quotes SET
		body = ? , category_id = ? ,date = ? where id = ?";
		if (isset($parameters['body']) && isset($parameters['id']) && isset($parameters['category_id']) && isset($parameters['date'])) {
			$id = $parameters['id'];
			$body = $parameters['body'];
			$category_id = $parameters['category_id'];
			$date = $parameters['date'];

			$result = $this->db->updateOne($query,$body,$category_id,$date,$id);
			$return $parameters;


		}else{

			return -1;
		}

	}

	public function deleteQuote($id){
		$query ="DELETE FROM quotes WHERE id = ?";

		$result = $this->db->deleteOne($query,$id);

		return [
          "message"=>"Quote with the id $id was succesfully deleted",
		];

	}
}