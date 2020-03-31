<?php
  session_start();
  if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):
  require(dirname(__FILE__).'/../../tot/config/connect.php');

     $p_code = $_POST['p_code'];
     $p_status = $_POST['p_status'];
     $p_date_approve2 = date('Y-m-03',strtotime("+1 Month"));
     $p_amount = $_POST['p_amount'];
     $M_money = '1';
     
     $spl = "SELECT * FROM `money`";
    $stmt = $dbh->prepare($spl);
    $stmt->execute();
    $money = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $moneytotal = $money['M_money'] - $p_amount;
    if($p_amount > 500)
		{
			$totalp_amount = $p_amount + 10;
		}
		elseif($p_amount <= 500)
		{
			$totalp_amount = $p_amount  + 5;
    }
    if($money['M_money'] < $p_amount){
			echo "<script language='javascript' type='text/javascript' > alert('จำนวนเงินคงเหลือของเดือนนี้ไม่พอ กรุณาทำรายการใหม่เดือนหน้า');</script>";
     	echo '<meta http-equiv= "refresh" content="0; url=index.php"/>';
		}else{
  
    $stmt1 = $dbh->prepare('UPDATE `money` SET M_money = :P2  WHERE M_id = :P3');
    $stmt1->bindParam(':P2', $moneytotal);
    $stmt1->bindParam(':P3', $M_money);
    $stmt1->execute();
    
    $stmt = $dbh->prepare('UPDATE petition SET p_status = :P2, p_date_approve2 = :P3, p_amount = :P4  WHERE p_code = :P1');
    $stmt->bindParam(':P1', $p_code);
    $stmt->bindParam(':P2', $p_status);
    $stmt->bindParam(':P3', $p_date_approve2);
    $stmt->bindParam(':P4', $totalp_amount);
	  $stmt->execute();	
       header('Location:\tot\03.hry\index.php');

        $message = '💰📙พนักงานรับเงิน'."\n".'คำขอกู้ยืมที่ : '.$p_code."\n".'จำนวนเงินที่ต้องชำระ : '.$totalp_amount."\n".'กำหนดวันที่ชำระเงิน : '.$p_date_approve2."\n".'สถานะการกู้ยืม : '.$p_status;
				$token = 'smRHCF9MaLuGwHCSnN0qhhyIsiFnv8W8kcoeEiv4jqC' ;
				send_line_notify($message, $token);
    }
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
