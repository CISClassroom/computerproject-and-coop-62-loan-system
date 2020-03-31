<?php
  session_start();
  if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):

		require(dirname(__FILE__).'/../../tot/config/connect.php');

	 	$M_id = $_POST['M_id'];
		$code = $_POST['code'];
		$fullname = $_POST['fullname'];
		$total = $_POST['total'];
	  
	      $stmt = $dbh->prepare('UPDATE money SET M_code = :P2, M_name = :P3, M_money = :P4 WHERE M_id = :P1');
		  
		  $stmt->bindParam(':P1', $M_id);
		  $stmt->bindParam(':P2', $code);
	      $stmt->bindParam(':P3', $fullname);
	      $stmt->bindParam(':P4', $total);
	      $stmt->execute();

	      header('Location:\tot\03.hry\money.php');
	  
  else:
    header('Location:\tot\01.login\login.php');
  endif;
?>
