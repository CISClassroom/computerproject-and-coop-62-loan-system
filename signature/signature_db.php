<?php
  session_start();
  if( isset($_SESSION['username']) AND !empty($_SESSION['password'])):
		require(dirname(__FILE__).'/../../tot/config/connect.php');
		
		date_default_timezone_set('Asia/Bangkok');
      $result = array();
      $datetime_txt = date("YmdHis");    
      $customer="";
      $code = $_POST['code'];
      $fullname = $_POST['fullname'];
      $position = $_POST['position'];
      $signature = $_POST['signature'];
  
      $signatureFileName = $datetime_txt.'.png';
      $signature = str_replace('data:image/png;base64,', '', $signature);
      $signature = str_replace(' ', '+', $signature);
      $data = base64_decode($signature);
      $file = 'sign_image/'.$signatureFileName;
      file_put_contents($file, $data);
      //$msg =  '<script language="javascript"> alert("อัพโหลดลายเซ็๋นของท่านเรียบร้อยแล้ว") ; window.location="index.php"; </script>';

     /* if($customer == ""){
        $insert = "UPDATE petition SET m_approve = '$signatureFileName' WHERE m_approve2 = '$fullname'";
        if($query = mysqli_query($dbh,$insert))
        {
          echo "<script language='javascript' type='text/javascript'> alert('บันทึกลายเซ็นของคุณเรียบร้อยแล้ว'); </script>";  
        }
        else{
          echo "Error".mysqli_error($dbh);
        }
      }  
      $insert = "INSERT INTO signature1(signature_personnel,signature_name,signature_position,signature_img,dateadd,status) VALUE ('$code','$name','$position','$signatureFileName','$dateadd',1)";
      $query = mysqli_query($dbh,$update) or die(mysql_error());
      */
      $stmt = $dbh->prepare('UPDATE personnel SET Personnel_sign = :P2 WHERE Personnel_FL_name = :P1');
      $stmt->bindParam(':P1', $fullname);
      $stmt->bindParam(':P2', $signatureFileName);
      $stmt->execute();	
				header('Location:\tot\06.employer\index.php');
    endif;
?>


