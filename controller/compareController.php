<?php
function staticTransactionsVietinbank($input)
{
	$modelTransfer= new Transfer();

	$lastday= getdate(strtotime("-1 day"));
	$startTime= mktime(0,0,0,$lastday['mon'],$lastday['mday'],$lastday['year']);
	$endTime= mktime(23,59,59,$lastday['mon'],$lastday['mday'],$lastday['year']);

	$conditions= array();
	$conditions['timeServer']= array('$gte' => $startTime,'$lte' => $endTime);
	$conditions['typedateEndPay']= 4;
	$order= array('timeServer'=>'asc');
	$listData= $modelTransfer->find('all',array('conditions'=>$conditions,'order'=>$order));

	$file = __DIR__.'/../compare/vietinbank/VIETINBANK_IN/'.$lastday['year'].$lastday['mon'].$lastday['mday'].'_TRANS_sabmerchant.txt';
	$data= "RecordType,RcReconcile,MsgType,CurCode,Amount,TranId,RefundId,TranDate,MerchantId,BankTrxSeq,BankResponseCode,CardNumber,Checksum\n";

	if($listData){
		foreach($listData as $key=>$transfer){
			$today= getdate($transfer['Transfer']['timeServer']);

            if($today['mon']<10) $today['mon']= '0'.$today['mon'];
            if($today['mday']<10) $today['mday']= '0'.$today['mday'];
            if($today['hours']<10) $today['hours']= '0'.$today['hours'];
            if($today['minutes']<10) $today['minutes']= '0'.$today['minutes'];
            if($today['seconds']<10) $today['seconds']= '0'.$today['seconds'];

			$RecordType= '0002';
			$RcReconcile= '00';
			$MsgType= '1210';
			$CurCode= 'VND';
			$Amount= $transfer['Transfer']['moneyCalculate'];
			$TranId= $transfer['Transfer']['transactionId'];
			$RefundId= '';
			$TranDate= $today['mday'].$today['mon'].$today['year'].$today['hours'].$today['minutes'].$today['seconds'];
			$MerchantId= 'sab';
			$BankTrxSeq= '';
			$BankResponseCode= '';
			$CardNumber= '';
			$Checksum= '';
			$data .= $RecordType."|".$RcReconcile."|".$MsgType."|".$CurCode."|".$Amount."|".$TranId."|".$TranDate."|".$MerchantId."|".$BankTrxSeq."|".$BankResponseCode."|".$CardNumber."|".$Checksum;
		}
	}

	file_put_contents($file, $data); 
	/*
	$file = fopen($file,"w");
	echo fwrite($file,"Hello World. Testing!\nabc");
	fclose($file);
	*/
}
?>