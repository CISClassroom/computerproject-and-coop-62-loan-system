<?php
  session_start();
  if( isset($_SESSION['callcenter_username']) AND !empty($_SESSION['callcenter_password'])):
		require(dirname(__FILE__).'/../../tot/config/connect.php');
		
		date_default_timezone_set('Asia/Bangkok');

		if($_POST['p_amount'] > 1000)
		{
			echo "<script language='javascript' type='text/javascript' > alert('การกู้ยืมต้องไม่เกิน1000บาท กรุณาทำรายการกู้ยืมใหม่อีกครั้ง');</script>";
			echo '<meta http-equiv= "refresh" content="0; url=index.php"/>';	
		}
		else	{
					$personnel_code = $_SESSION['Personnel_code'];
					$p_date_borrow = date('Y-m-d H:i:s');
					$p_amount = $_POST['p_amount'];
					$p_signature2 = $_POST['p_signature2'];
					$p_status ='รอดำเนินการ';
					$p_position = $_POST['p_position'];
					$M_money='1';
					$dateNow = date("Y-m-d");

						//$datefix = date("Y-m-19");

				//	if (date("d") > 15 ){
				//		$time = strtotime(date("Y/m/15"));
				//		$final = date("Y-m-d", strtotime("+1 month", $time));
				//	}
				//	if (date("d") <= 15 ){
				//		$time = strtotime(date("Y/m/15"));
				//		$final = date("Y-m-d");
				//	}
				//	if (date("d") == 15 ){
				//		$time = strtotime(date("Y/m/d"));
				//		$final = date("Y-m-d");
				//	}
				//เช็คยอดค้างชำระ
				
					
					$count4 = "SELECT * FROM `personnel` WHERE Personnel_code = '$personnel_code'";
					$result4 = $dbh->prepare($count4);
					$result4->execute();
					$row1 = $result4->fetch(PDO::FETCH_ASSOC);
					$P_sign = $row1['Personnel_sign'];
				
					//เช็ควันคืนเพื่อหาวันยืมใหม่   <=3  ยืมได้ > 15
					$count3 = "SELECT * FROM `petition` WHERE  p_signature2 = '$p_signature2' ORDER BY p_code ASC LIMIT 1;";
					$result2 = $dbh->prepare($count3);
					$result2->execute();
					$row = $result2->fetch(PDO::FETCH_ASSOC);
					$num1 = 1;
                    if(DATE($row['payment_date']) > DATE($row['p_date_approve2'])){
						$time = strtotime(DATE($row['p_date_approve2']));
						$final = strtotime(date("Y-m-d", strtotime("+1 month", $time)));
						$final_day = date("Y-m-d", strtotime("+13 days", $final));
						if($dateNow >= $final_day){
                            $num1 = 0;
						}else
						{
							echo '<script language="javascript">';
							echo 'alert("ขณะนี้ระบบไม่สามารถให้ท่านกู้ยืมได้ เนื่องจากท่านไม่ชำระเงินตามวันที่กำหนด ท่านสามารถยืมได้ใหม่ในวันที่ 16 เดือนถัดไป") ; window.location="index.php"; ';
							echo '</script>';
						}
                      
					}
					else{
						$time = strtotime(DATE($row['p_date_approve2']));
						$final = strtotime(date("Y-m-d", strtotime("+1 month", $time)));
						$final_day = date("Y-m-d", strtotime("+13 days", $final));
						if($dateNow < $final_day){
							echo '<script language="javascript">';
							echo 'alert("ไม่สามารถยืมได้ ท่านสามารถยืมได้ใหม่ในวันที่ 16 เดือนหน้า") ; window.location="index.php"; ';
							echo '</script>';
						}
						else{
                            $num1 = 0;
						}
					}
					
					if($num1 == 0){
						$stmt = $dbh->prepare('INSERT INTO petition (p_code, personnel_code, p_date_borrow, p_amount, p_status, p_signature, p_signature2, p_position) VALUES (NULL, :P2, :P3, :P4, :P5,:P6, :P7, :P8)');
										
						$stmt->bindParam(':P2', $personnel_code);
						$stmt->bindParam(':P3', $p_date_borrow);
						$stmt->bindParam(':P4', $p_amount);
						$stmt->bindParam(':P5', $p_status);
						$stmt->bindParam(':P6', $P_sign);
						$stmt->bindParam(':P7', $p_signature2);
						$stmt->bindParam(':P8', $p_position);
						$stmt->execute();
							header('Location:\tot\06.employer\index.php');

							$message = '💰📙พนักงานชำระเงินเรียบร้อยแล้ว'."\n".'จาก : '.$p_signature2."\n".'ตำแหน่งงาน : '.$p_position."\n". 'วันที่กู้ยืมเงิน : '.$p_date_borrow. "\n".'จำนวนเงิน : '.$p_amount;
							$token = 'smRHCF9MaLuGwHCSnN0qhhyIsiFnv8W8kcoeEiv4jqC' ;
							send_line_notify($message, $token);
					}
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

<?php
/*	$count3 = "SELECT 
					DATE_FORMAT(`p_date_borrow`,'%m') - DATE_FORMAT(`payment_date`,'%m') as mdif 
					,  DATE_FORMAT(now(),'%m') - DATE_FORMAT(`payment_date`,'%m')  as fmdif
					,DATE_FORMAT(`payment_date`,'%d') as payD
					,payment_date
					,DATE_FORMAT(`p_date_borrow`,'%Y-%m%-%d') as p_date_borrow
					,DATE_FORMAT(`payment_date`,'%m') as pppmmmdif 
					,DATE_FORMAT(`p_date_borrow`,'%m') as bbbdif 
					,(case when DATE_FORMAT(`p_date_borrow`,'%d') not in ('1','2') then 
                    	 DATE_FORMAT(DATE_ADD(p_date_borrow, INTERVAL +1 MONTH),'%Y-%m%-03')
                         else DATE_FORMAT(DATE_ADD(p_date_borrow, INTERVAL +0 MONTH),'%Y-%m%-03') end) paydatebu
					FROM `petition` 
					WHERE  p_signature2 = '$p_signature2'
					group by `p_signature2`
					HAVING max(`p_code`)
					";
					$result3 = $dbh->prepare($count3);
					$result3->execute();
					$num3 = $result3->fetch();   //$num3['mdiff']
					echo '<script language="javascript">';
					echo 'alert("'.$num3['paydatebu'].' ") ; window.history.back(); ';
					echo '</script>';	
					if ( $num3['fmdif'] == 1 and $num3['mdif'] == 0 and  ($num3['p_date_borrow'] <  $num3['paydatebu'] ) )
							{
								$num1 = 0 ; //(ยืมได้เลย)

							}
					if( $num3['fmdif'] = 0 ) //n-p 1
					{				 
							if( $num3['mdif'] == 0 ) // b-p 0
							{
								
								if( $num3['payD'] <= 3 ) 

								{				 
									if( $dateNow  >= 15 )
									{				 
										$num1 = 0 ; //(ยืมได้เลย)
										
									}
									if( $dateNow  < 15 )
									{				 
										echo '<script language="javascript">';
										echo 'alert("ไม่สามารถยืมได้ ท่านสามารถยืมได้ใหม่ในวันที่ 15 ") ; window.history.back(); ';
										echo '</script>';
										$num1 =1 ; //(ยืมมไม่ได้)
									}										
								}
								if( $num3['payD'] > 3 )
								
								{
									echo '<script language="javascript">';
									echo 'alert("ไม่สามารถยืมได้ ท่านสามารถยืมได้ใหม่ในวันที่ 15 เดือนหน้า") ; window.history.back(); ';
									echo '</script>';
									$num1 =1 ; //(ยืมมไม่ได้)	
								}
								
							}
							
							if( $num3['mdif'] > 0 )
							{
								if( $num3['payD'] <= 3 )
								{
									if( $dateNow  >= 15 )
									{				 
										$num1 =0 ; //(ยืมได้เลย)
										
									}
									if( $dateNow  < 15 )
									{				 
										echo '<script language="javascript">';
										echo 'alert("ไม่สามารถยืมได้ ท่านสามารถยืมได้ใหม่ในวันที่ 15 ") ; window.history.back(); ';
										echo '</script>';
										$num1 =1 ; //(ยืมมไม่ได้)
										
									}								
								}
								if( $num3['payD'] > 3 )
								{
									echo '<script language="javascript">';
										echo 'alert("ไม่สามารถยืมได้ ท่านสามารถยืมได้ใหม่ในวันที่ 15 เดือนหน้า") ; window.history.back(); ';
										echo '</script>';
										$num1 =1 ; //(ยืมมไม่ได้)
								}
							}
						
					}
					if( $num3['fmdif'] > 1 )
					{
						$num1 =0 ; //(ยืมได้เลย)

					}
					*/