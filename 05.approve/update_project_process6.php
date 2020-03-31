<?php
  session_start();
  if( isset($_SESSION['approve_username']) AND !empty($_SESSION['approve_password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');

	
	    $p_code = $_POST['p_code'];
      $p_status = "รอดำเนินการ";
	  
	  
	      $stmt = $dbh->prepare('UPDATE petition SET p_status = :P2  WHERE p_code = :P1');
	      $stmt->bindParam(':P1', $p_code);
        $stmt->bindParam(':P2', $p_status);
	      $stmt->execute();

	      header('Location:\tot\05.approve\index_approve2.php');
	    
	  
      endif;
?>
