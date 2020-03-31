<?php
  session_start();
  if( isset($_SESSION['approve_username']) AND !empty($_SESSION['approve_password'])):

    date_default_timezone_set('Asia/Bangkok');

    require(dirname(__FILE__).'/../../tot/config/connect.php');

      $m_approve2 = $_SESSION['Personnel_FL_Name'];
      $p_code = $_POST['p_code'];
      $p_status = "อนุมัติเรียบร้อย";
      $p_date_approve = date('Y-m-d H:i:s');
      $m_approve = $_POST['m_approve'];
      $m_name = $_POST['m_name'];
    
      
      $count4 = "SELECT * FROM `personnel` WHERE  Personnel_FL_Name = '$m_name'";
			$result4 = $dbh->prepare($count4);
			$result4->execute();
			$row1 = $result4->fetch(PDO::FETCH_ASSOC);
			$P_sign = $row1['Personnel_sign'];
	  
	      $stmt = $dbh->prepare('UPDATE petition SET p_status = :P2, p_date_approve = :P3, m_approve = :P4, m_approve2 = :P5  WHERE p_code = :P1');
	      $stmt->bindParam(':P1', $p_code);
        $stmt->bindParam(':P2', $p_status);
        $stmt->bindParam(':P3', $p_date_approve);
        $stmt->bindParam(':P4', $P_sign);
        $stmt->bindParam(':P5', $m_approve2);
	      $stmt->execute();
          header('Location:\tot\05.approve\project_detail4.php?p_code='.$p_code);
        
        $message = '💰📙คำร้องขอการกู้ยืมที่อนุมัติแล้ว'."\n".'คำขอกู้ยืมที่ : '.$p_code."\n".'ได้รับการอนุมัติโดย : '.$m_approve2."\n".'สถานะการกู้ยืม : '.$p_status;
        $token = 'smRHCF9MaLuGwHCSnN0qhhyIsiFnv8W8kcoeEiv4jqC' ;
        send_line_notify($message, $token);
    
      endif;
      //LINE Notify
     function send_line_notify($message, $token){
     $ch = curl_init();
     curl_setopt( $ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
     curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt( $ch, CURLOPT_POST, 1);
     curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=$message");
     curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
     $headers = array( "Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token", );
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
     $result = curl_exec( $ch );
     curl_close( $ch );
    
     return $result;
    }
    ?>
