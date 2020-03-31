<?php
  session_start();
  if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):

		require(dirname(__FILE__).'/../../tot/config/connect.php');

		date_default_timezone_set('Asia/Bangkok');

		$SS = $_POST['p_signature2'];

		$p_code = $_POST['p_code'];
		$p_amount = $_POST['p_amount'];
		$p_status = $_POST['p_status'];
		
		$M_money = '1';
		$payment_date = date('Y-m-d H:i:s');

		$sql = "SELECT * FROM `money`";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$money = $stmt->fetch(PDO::FETCH_ASSOC);

		$moneytotal = $money['M_money'] + $p_amount;
		$stmt1 = $dbh->prepare('UPDATE money SET M_money = :P2  WHERE M_id = :P3');
  		$stmt1->bindParam(':P2', $moneytotal);
  		$stmt1->bindParam(':P3', $M_money);
  		$stmt1->execute();

	      $stmt = $dbh->prepare('UPDATE petition SET p_status = :P2, payment_date = :P3 WHERE p_code = :P1');
	      $stmt->bindParam(':P1', $p_code);
		  $stmt->bindParam(':P2', $p_status);
		  $stmt->bindParam(':P3', $payment_date);
	      $stmt->execute();
		  	header('Location:\tot\03.hry\index3.php');

		  		$message = '💰📙พนักงานชำระเงินเรียบร้อยแล้ว'."\n".'คำขอกู้ยืมที่ : '.$p_code."\n".'ชำระเงินเมื่อวันที่ : '.$payment_date."\n".'สถานะการกู้ยืม : '.$p_status;
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
