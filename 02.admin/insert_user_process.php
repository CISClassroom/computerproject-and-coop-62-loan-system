<?php
  session_start();
  if( isset($_SESSION['admin_username']) AND !empty($_SESSION['admin_password'])):

		require(dirname(__FILE__).'/../../tot/config/connect.php');

	  if ($_POST["password1"] == $_POST["password2"]) {

	    $fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$code = $_POST['code'];
		$position = $_POST['position'];
		$phoneNumber = $_POST['tell'];
		$user = $_POST['username'];
		//$pass = $_POST['password2'];
		$pass = sha1(MD5($_POST['password2']));
		$FLname = $fname.' '.$lname;

      $count1 = "SELECT count(*) FROM `personnel` WHERE Personnel_Usermae='$user'";
	    $result1 = $dbh->prepare($count1);
	    $result1->execute();
	    $num1 = $result1->fetchColumn();

      $count2 = "SELECT count(*) FROM `personnel` WHERE Personnel_FL_Name='$FLname'";
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
	      $stmt = $dbh->prepare('INSERT INTO personnel (Personnel_code, Personnel_FL_Name, Personnel_Position, Personnel_Phone, Personnel_Usermae, Personnel_Password) 
		  VALUES ( :P1, :P2, :P3, :P4, :P5, :P6)');

			$stmt->bindParam(':P1', $code);
			$stmt->bindParam(':P2', $FLname);
			$stmt->bindParam(':P3', $position);
	    	$stmt->bindParam(':P4', $phoneNumber);
	    	$stmt->bindParam(':P5', $user);
			$stmt->bindParam(':P6', $pass);
			$stmt->execute();
				header('Location:\tot\02.admin\index.php');
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
