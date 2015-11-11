<?php
class InterestsManager{
	
	private $connection;
	private $user_id;
	
	function __construct($mysqli, $user_id_from_session){
		
		$this->connection = $mysqli;
		$this->user_id = $user_id_from_session;
		
		echo "Huvialade haldus käivitatud, kasutajale" .$this->user_id;
	}
	
	function addInterest($new_interest){
		
		$response = new Stdclass();
		
		$stmt = $this->connection->prepare("SELECT id FROM interests WHERE name=?");
		$stmt->bind_param("s", $new_interest);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise huvialaga <strong>'.$new_interest'</strong> kasutaja on juba olemas!";
			$response->error = $error;
			return $response;
			
		}
		
		
		$stmt->close();	
		$stmt = $this->connection->prepare('INSERT INTO interests (name) VALUE (?)');
		$stmt->bind_param("s", $new_interest);
		
		if($stmt->execute()){
			$success  = new StdClass();
			$success->message = "Huviala sai edukalt lisatud!";
			$response->success = $success;
			return $response;
			
		}else{
			
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			
			$response->error = $error;
			
		}
		$stmt->close();
		return $response;
		
	}

	
} ?>