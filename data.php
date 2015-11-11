<?php
	require_once("function.php");
	require_once("InterestsManager.class.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		//edasist ei käivitata
		exit();
	}

	
	if(isset($_GET["logout"])){

		session_destroy();
		
		header("Location: login.php");
	}
	
	$InterestsManager = new InterestsManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(isset($_GET["new_interest"])){
		
		$add_new_response = $InterestsManager->addInterest($_GET["new_interest"]);
	}
	
	
?>

<h3>Lisa huviala</h3>


	<?php if(isset($add_new_response->error)): ?>
	
		<p style="color:red;"> <?=$add_new_response->error->message;?> </p>
		
	<?php elseif(isset($add_new_response->success)): ?>
	
		<p style="color:green;"> <?=$add_new_response->success->message;?> </p>
	
	<?php endif; ?>
<form>
	<p> 
		<input name="new_interest" type="text" placeholder="Lisa huviala" >
		<input name="create" type="submit" value="Lisa huviala">
	</p>
</form>

<p>Tere,  <?php echo $_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja</a> 
</p> 














