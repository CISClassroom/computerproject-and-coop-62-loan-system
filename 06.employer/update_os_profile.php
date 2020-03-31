<?php
  session_start();
  if( isset($_SESSION['callcenter_username']) AND !empty($_SESSION['callcenter_password'])):

		require(dirname(__FILE__).'/../../tot/config/connect.php');

	  if ($_POST["password1"] == $_POST["password2"]) {

		$Personnel_code = $_POST['Personnel_code'];
		$flname = $_POST['flname'];
		$position = $_SESSION['Personnel_Position'];
		$phoneNumber = $_POST['tell'];
	    $user = $_POST['username'];
	    $pass = $_POST['password2'];

      $count1 = "SELECT count(*) FROM `personnel` WHERE NOT Personnel_code='$Personnel_code' AND Personnel_Usermae='$user'";
	    $result1 = $dbh->prepare($count1);
	    $result1->execute();
	    $num1 = $result1->fetchColumn();

      $count2 = "SELECT count(*) FROM `personnel` WHERE NOT Personnel_code='$Personnel_code' AND Personnel_FL_Name='$flname'";
	    $result2 = $dbh->prepare($count2);
	    $result2->execute();
	    $num2 = $result2->fetchColumn();

	    if ($num1 > 0 || $num2 > 0) {
	      echo "
        <script>
        if (confirm('มีข้อมูลซ้ำ! กรุณาตรวจสอบข้อมูล'))
        {
          window.history.back();
        }
        </script>";
	    }
	    else {
	      $stmt = $dbh->prepare('UPDATE personnel SET Personnel_FL_Name = :P2, Personnel_Position = :P3, Personnel_Phone = :P4, Personnel_Usermae = :P5, Personnel_Password = :P6  WHERE Personnel_code = :P1');
		  
		  $stmt->bindParam(':P1', $Personnel_code);
		  $stmt->bindParam(':P2', $flname);
	      $stmt->bindParam(':P3', $position);
	      $stmt->bindParam(':P4', $phoneNumber);
	      $stmt->bindParam(':P5', $user);
	      $stmt->bindParam(':P6', $pass);
	      $stmt->execute();

	      header('Location:\tot\06.employer\callcenter_profile.php');
	    }
	  }
	  else {
      echo "
      <script>
        if (confirm('รหัสผ่านไม่ถูกต้อง!'))
        {
          window.history.back();
        }
      </script>";
	  }
  else:
    header('Location:\tot\01.login\login.php');
  endif;
?>
