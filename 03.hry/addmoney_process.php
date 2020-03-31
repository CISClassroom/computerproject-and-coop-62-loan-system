<?php
  session_start();
  if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):

		require(dirname(__FILE__).'/../../tot/config/connect.php');

        $code = $_POST['code'];
		$fullname = $_POST['fullname'];
		$total = $_POST['total'];

		
	      $stmt = $dbh->prepare('INSERT INTO `money` (M_id, M_code, M_name, M_money) VALUES (NULL, :P2, :P3, :P4)');

			//$stmt->bindParam(':P1', $M_id);
			$stmt->bindParam(':P2', $code);
			$stmt->bindParam(':P3', $fullname);
	    	$stmt->bindParam(':P4', $total);
			$stmt->execute();
				header('Location:\tot\03.hry\money.php');
	    
  else:
    header('Location:\tot\01.login\login.php');
  endif;
?>
