<?php

// --------------function syncTransferUpload--------------
// * Người tạo: Nguyễn Tiến Hưng.
// * Ngay tao:
// * Ghi chú:
// * Mục đích: đọc file csv chứa các giao dịch được xuất trực tiếp từ máy bán hàng.
// * Lịch sử sửa:
//
// --------------------------------------------------
function syncTransferUpload($input){
	global $modelOption;
	global $urlHomes;


	$modelLog= new Log();
	$modelTransfer= new Transfer();
	$modelMachine = new Machine();
	$modelPlace= new Place;
	$modelProduct = new Product;

		if(!empty($_SESSION['infoStaff'])){
			if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin')
			|| (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('syncTransferUpload', $_SESSION['infoStaff']['Staff']['permission']))){

				if(isset($_POST['submit'])){
					$filetmp=$_FILES['file']['tmp_name'];
					$mang=$_FILES['file'];
					foreach ($_FILES['file']['name'] as $i => $name) {
						if($mang['type'][$i]=='application/vnd.ms-excel' || $mang['type'][$i]=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
			        if($mang['type'][$i]=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){ //nếu file là dạng excel(.xlsx).

			          if (strlen($name) > 1) { //nếu tên file nhiều hơn 1 chữ.
			              if (move_uploaded_file($filetmp[$i], 'C:/Ampps/www/demo/app/Plugin/kiosk/file_excel/'.$name)) { //nếu file được di chuyển vào thư mục theo yêu cầu.
			                   $reportSuccess[]='OK';
			                }
			              else{ //nếu file không được di chuyển vào thư mục theo yêu cầu.
			                $reportFail[]='Fail';
			              }
			            } //đóng if (strlen($name) > 1).
								}//đóng if với dạng file là excel(.xlsx).
								if($mang['type'][$i]=='application/vnd.ms-excel'){ //nếu file là dạng csv(.csv).
				          //echo 'File '.$name.' là file csv(.csv)<br><br>';

				          if (strlen($name) > 1) { //nếu tên file nhiều hơn 1 chữ.
				              if (move_uploaded_file($filetmp[$i], 'C:/Ampps/www/demo/app/Plugin/kiosk/file_csv/'.$name)) { //nếu file được di chuyển vào thư mục theo yêu cầu.
				                   $reportSuccess[]='OK';
				                }
				              else{ //nếu file không được di chuyển vào thư mục theo yêu cầu.
				                $reportFail[]='Fail';
				              }
				            } //đóng if (strlen($name) > 1).
									}// đóng if với dạng file là csv.
							}// đóng if tổng.
							else{ //đối với các file không phải xlsx hay csv.
								if (strlen($name) > 1) { //nếu tên file nhiều hơn 1 chữ.
				            if (move_uploaded_file($filetmp[$i], 'C:/Ampps/www/demo/app/Plugin/kiosk/file_other/'.$name)) { //nếu file được di chuyển vào thư mục theo yêu cầu.
				                 $reportSuccess[]='OK';
				              }
				            else{ //nếu file không được di chuyển vào thư mục theo yêu cầu.
				              $reportFail[]='Fail';
				            }
				          } //đóng if (strlen($name) > 1).
							}// đóng else.

					}// đóng foreach.
					$countSuccess= 0;
					$countFail=0;
					if(!empty($reportSuccess)){
						$countSuccess= count($reportSuccess);
					}
					if(!empty($reportFail)){
						$countFail= count($reportFail);
					}
					$mess1='Upload thành công: '.$countSuccess.' file';
					$mess2='Upload thất bại: '.$countFail.' file';

					setVariable('mess1',$mess1);
					setVariable('mess2',$mess2);
			}// đóng if(isset($_POST['submit'])).


			if(isset($_POST['sync'])){ //lỗi tại đây. Trang không nhận sự kiện nhấn nút.

				$inputFileName = glob('C:/Ampps/www/demo/app/Plugin/kiosk/file_csv/*');
				if(!empty($inputFileName)){
				$count=count($inputFileName);
				$s = microtime(true);
				for($i=0;$i<$count;++$i){

						$nameFile= basename($inputFileName[$i]);
						$link1=$inputFileName[$i];
						$link2= 'C:/Ampps/www/demo/app/Plugin/kiosk/backup_csv/'.$nameFile;
						$link3= 'C:/Ampps/www/demo/app/Plugin/kiosk/upload_failed/'.$nameFile;
						$file=fopen($inputFileName[$i],"r"); //mở file được up lên, và chỉ đọc(read -> "r").
						while(! feof($file)) //Hàm feof() kiểm tra xem con trỏ tập tin đã ở vị trí cuối cùng của file chưa, nếu chưa thì tiếp tục lặp con trỏ qua từng row(dòng).
							{
								$dataUpload=fgetcsv($file); // hàm fgetcsv() sẽ parse(phân giải dữ liệu) dòng nó đọc sang định dạng CSV và trả về một mảng chứa các trường đã đọc.
								if(!empty($dataUpload)){ //Nếu file không trống.
								$dataSend=json_decode(@$dataUpload[9], true); // dữ liệu sau khi đọc sẽ được mã hóa dưới dạng json, dùng hàm decode để giải mã về dạng mảng để lấy giá trị.
								if(!empty($dataSend)){ // nếu dữ liệu decode không trống.
										if(!empty($dataSend['machineId'])){ // kiểm tra xem file excel gửi lên có mã máy thuộc máy nằm trong cơ sỏ dữ liệu của serverVMS hiện tại ko?
										$machine = $modelMachine->getMachineCode($dataSend['machineId'],array('code'));
									}
									if(!empty($machine)){ //nếu mã máy đưa lên hợp lệ thì tiến hành gán giá trị vào mảng để chuẩn bị save lên database.
										if(!empty($dataSend['AvailableAmount'])){
											$reportFail2[]='Fail';
											copy($link1,$link3);
										}
										else{ //Câu lệnh này sẽ lọc xem file có tồn tại dạng cấu trúc cũ hay không(chỉ lưu cấu trúc mới).
											$modelSync= new Sync();
											$dataSync['typedateEndPay']=$dataSend['typePay'];
											$dataSync['timeClient']=$dataSend['time'];
											$dataSync['codeProduct']=$dataSend['goodId'];
											$dataSync['quantity']=$dataSend['quantity'];
											$dataSync['moneyCalculate']=$dataSend['moneyCalculate'];
											$dataSync['moneyInput']=$dataSend['moneyInput'];
											$dataSync['moneyAvailable']=$dataSend['moneyAvailable'];
											$dataSync['codeMachine']=$dataSend['machineId'];
											$dataSync['transactionId']=$dataSend['transactionId'];
											$dataSync['slotId']=$dataSend['slotId'];
											$dataSync['status']=$dataSend['status'];
											$dataSync['coupon']=$dataSend['coupon'];
											$dataSync['saleSessionId']=$dataSend['saleSessionId'];
											$dataSync['timeUp']=time();
											$dataSync['lock']=(int)0;
											if($modelSync->save($dataSync)){ //lưu mảng trên và nếu mảng trên được lưu thành công thì echo ...
												$reportSuccess2[]='OK';
												copy($link1,$link2);
											}
											else{ //nếu lưu thất bại thì ...
												$reportFail2[]='Fail';
												copy($link1,$link3);
											}
										}// đóng if(!isset($dataSend['AvailableAmount'])).

									}
									else{ //nếu mã máy không hợp lệ.
										echo 'Mãy máy không thuộc cơ sở dữ liệu này';
									}
								} // đóng if(!empty($dataSend)).
							} //đóng if(!empty($dataUpload)).
						} //đóng while.

					fclose($file); // Hàm fclose() sẽ đóng một tập tin đang mở  bằng hàm fopen() hoặc fsockopen() trước đó.
					unlink($link1);
					} //đóng vòng lặp for.
					$e = microtime(true);
					$time=round($e - $s, 2);

				$countSuccess2= 0;
				$countFail2=0;
				if(!empty($reportSuccess2)){
					$countSuccess2= count($reportSuccess2);
				}
				if(!empty($reportFail2)){
					$countFail2= count($reportFail2);
				}
				$mess3='Upload thành công: '.$countSuccess2.' bản ghi';
				$mess4='Upload thất bại: '.$countFail2.' bản ghi';
				$mess5='Thời gian thực thi: '.$time.' giây';

				setVariable('mess3',$mess3);
				setVariable('mess4',$mess4);
				setVariable('mess5',$mess5);
				}//đóng if(!empty($inputFileName)).
				else{
					$mess='Dữ liệu hiện tại trống';
					setVariable('mess',$mess);
				}
			}//đóng if(isset($_POST['sync'])).
		}
	}
}// đóng function.

// --------------function syncTransfer--------------
// * Ngay tao:
// * Ghi chú:
// * Mục đích: Tra cứu và đồng bộ các dữ liệu giao dịch thuộc serverVMS và máy kiosk.
// * Lịch sử sửa:
// * Lưu ý: khi thuật toán cần sử dụng tới nhiều vòng lặp, hãy ƯU TIÊN sử dụng for thay vì foreach(nếu có thể) bởi for nhanh hơn rất nhiều so với foreach.
// --------------------------------------------------
		function syncTransfer($input){
		$modelSync= new Sync;
		$modelTransfer= new Transfer;
		$modelMachine = new Machine;
		$modelPlace = new Place;
		$modelProduct = new Product();
		if(!empty($_SESSION['infoStaff'])){
			if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin')
			|| (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('syncTransfer', $_SESSION['infoStaff']['Staff']['permission']))){
				$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
				$listMachine=$modelMachine->find('all',array('conditions'=>array('lock'=>(int)0),'fields'=>'code'));

				if(!empty($_GET)){
					$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
					if($page<1) $page=1;

					$fieldsTransfer=array('moneyCalculate','timeServer','timeClient','codeMachine','idMachine','quantity');
					$fieldsSync=array('moneyCalculate','timeClient','quantity','codeMachine','status');

					if(!empty($_GET['dateStart'])){ //từ ngày.
						$date= explode('/', $_GET['dateStart']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$gte']= $time;
						$conditionsSync['timeClient']['$gte']= $time;
						$conditionsTransfer1['timeServer']['$gte']= $time;
						$conditionsSync1['timeClient']['$gte']= $time;
					}
					if(!empty($_GET['dateEnd'])){ //đến ngày.
						$date= explode('/', $_GET['dateEnd']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$lte']= $time;
						$conditionsSync['timeClient']['$lte']= $time;
						$conditionsTransfer1['timeServer']['$lte']= $time;
						$conditionsSync1['timeClient']['$lte']= $time;
					}
					if(!empty($_GET['type'])){ //kiểu đối soát.
						if($_GET['type']==2){
						$conditionsSync['status']=(int)1;
						$conditionsTransfer['status']=(int)1;
						}
					}

					if($_GET['idPlace']!=1){ //điểm đặt.
						$idPlace=trim($_GET['idPlace']);
						$conditionsPlace['id']=$idPlace;
					}

					if(!empty($_GET['area'])){ //vùng miền
						$area=trim($_GET['area']);
						$conditionsPlace['area']= $area;
					}
					if(!empty($_GET['idCity'])){ //tỉnh/thành phố
						$idCity=trim($_GET['idCity']);
						$conditionsPlace['idCity']= $idCity;
					}
					if(!empty($_GET['idDistrict'])){ //quận/huyện
						$idDistrict=trim($_GET['idDistrict']);
						$conditionsPlace['idDistrict']= $idDistrict;
					}
					if(!empty($_GET['wards'])){ // xã phường.
						$idWards=trim($_GET['wards']);
						$conditionsPlace['wards']= $idWards;
					}

						if($_GET['codeMachine']==1){ //nếu mã máy trống.
							if(!empty($conditionsPlace)){ //nếu đk lọc điểm đặt không rỗng.
								$conditionsPlace['lock']=(int)0;
								$Place=$modelPlace->find('all',array('conditions'=>$conditionsPlace,'fields'=>'id'));
								if(!empty($Place)){
								$countPlace=count($Place);
									for($x=0;$x<$countPlace;$x++){
											$array[$x]=$Place[$x]['Place']['id'];
									}
									$conditionsMachine['idPlace']=array('$in'=>$array);
									$conditionsMachine['lock']=(int)0;
								}
							} //đóng if(!empty($conditionsPlace)).
							else{
								$conditionsMachine['lock']=(int)0;
							}
						}
						else{
							$codeMachine=trim($_GET['codeMachine']);
							$conditionsMachine['code']=$codeMachine;
						}//đóng else(nếu mã máy không trống).

				$dataMachine=$modelMachine->find('all',array('conditions'=>$conditionsMachine,'fields'=>array('code','idPlace','idStaff')));
				$count=count($dataMachine);

					$listData[]=array();
				if(!empty($dataMachine)){

						for($i=0;$i<$count;$i++){
							$conditionsTransfer['codeMachine']=$dataMachine[$i]['Machine']['code'];
							$conditionsSync['codeMachine']=$dataMachine[$i]['Machine']['code'];
							$listPlace2=$modelPlace->find('all',array('conditions'=>array('id'=>$dataMachine[$i]['Machine']['idPlace']),'fields'=>array('name','area','idCity','idDistrict','wards','numberHouse','idChannel')));
							$listTransfer=$modelTransfer->find('all',array('conditions'=>$conditionsTransfer,'fields'=>$fieldsTransfer));
							$listSync=$modelSync->find('all',array('conditions'=>$conditionsSync,'fields'=>$fieldsSync));
							$count1=count($listTransfer);
							$count2=count($listSync);
							$tongSL1=0;
							$tongDT1=0;
							$soluong1=0;
							$doanhthu1=0;

							$tongSL2=0;
							$tongDT2=0;
							$soluong2=0;
							$doanhthu2=0;
							for($a=0;$a<$count1;$a++){ //vòng lặp cho $listTransfer.
								$soluong1=$soluong1+$listTransfer[$a]['Transfer']['quantity'];
								$doanhthu1=$doanhthu1+$listTransfer[$a]['Transfer']['moneyCalculate'];
								//$ClientTransfer['timeClient']=$listTransfer[$a]['Transfer']['timeClient'];

							}//đóng for với $a.
							$tongSL1=$tongSL1+$soluong1;
							$tongDT1=$tongDT1+$doanhthu1;
							for($b=0;$b<$count2;$b++){ //vòng lặp cho $listSync.
								$soluong2=$soluong2+$listSync[$b]['Sync']['quantity'];
								$doanhthu2=$doanhthu2+$listSync[$b]['Sync']['moneyCalculate'];
								//$ClientSync['timeClient']=$listSync[$b]['Sync']['timeClient'];

							}//đóng for với $b.
							$tongSL2=$tongSL2+$soluong2;
							$tongDT2=$tongDT2+$doanhthu2;

							// pr($listPlace);
							$listData[$i]['codeMachine']=$dataMachine[$i]['Machine']['code'];
							$listData[$i]['idMachine']=$dataMachine[$i]['Machine']['id'];
							$listData[$i]['idStaff']=$dataMachine[$i]['Machine']['idStaff'];

							$listData[$i]['namePlace']=$listPlace2[0]['Place']['name'];
							$listData[$i]['idPlace']=$listPlace2[0]['Place']['id'];
							$listData[$i]['countTransfer']=$count1;
							$listData[$i]['countSync']=$count2;
							$listData[$i]['quantityTransfer']=$tongSL1;
							$listData[$i]['quantitySync']=$tongSL2;
							$listData[$i]['revenueTransfer']=$tongDT1;
							$listData[$i]['revenueSync']=$tongDT2;
							$listData[$i]['dateStart']=$_GET['dateStart'];
							$listData[$i]['dateEnd']=$_GET['dateEnd'];
							if(!empty($listSync)){
							$listData[$i]['status']=$listSync[0]['Sync']['status'];
							}
							//pr($listSync);
							$listData[$i]['area']=$listPlace2[0]['Place']['area'];
							$listData[$i]['idDistrict']=$listPlace2[0]['Place']['idDistrict'];
							$listData[$i]['idCity']=$listPlace2[0]['Place']['idCity'];
							$listData[$i]['idChannel']=$listPlace2[0]['Place']['idChannel'];
							$listData[$i]['wards']=$listPlace2[0]['Place']['wards'];
							$listData[$i]['numberHouse']=$listPlace2[0]['Place']['numberHouse'];

							//$listData[$i]['timeClient']=
							//pr($listSync);
						}// đóng for với $i.

					} // đóng if(!empty($dataMachine)).
						//giờ chúng ta đã có mảng liên tục $listData và sẽ dùng để lặp bên file giao diện của trang(syncTransfer.php) :D .

					if(isset($_POST['sync'])){ //Nếu nút "Đồng bộ" được click.
							if(!empty($listData)){ //NẾU mảng $listData được gán ở trên không trống.

									$countListData=count($listData); //đếm mảng.
									for($i=(-1);$i<$countListData;++$i){ //lặp mảng.
										$conditionsTransfer1['codeMachine']=@$listData[$i]['codeMachine'];
										$conditionsSync1['codeMachine']=@$listData[$i]['codeMachine'];
										$conditionsSync2['codeMachine']=@$listData[$i]['codeMachine'];

										$listTransfer1=$modelTransfer->find('list',array('conditions'=>$conditionsTransfer1,'fields'=>'transactionId'));
										$listSync1=$modelSync->find('list',array('conditions'=>$conditionsSync1,'fields'=>'transactionId'));
										$refine= array_diff($listSync1,$listTransfer1);
										//pr($refine);

										//$valueRefine=array_values($refine);
										$conditionsSync2['transactionId']=array('$in'=>array_values($refine));
										$listSync2=$modelSync->find('all',array('conditions'=>$conditionsSync2,'fields'=>array()));
										// pr($listSync2);
										if(!empty($listSync2)){
											$countSync=count($listSync2);
											for($x=0;$x<$countSync;++$x){ //bắt đầu lặp biến $listSync2.

												if($listSync2[$x]['Sync']['status']!=0){ //Nếu không phải dạng giao dịch chưa được khởi tạo thì bắt đầu ghép mảng và lưu lên csdl.
													$modelTransfer = new Transfer;
													$listProduct=$modelProduct->find('first',array('conditions'=>array('code'=>$listSync2[$x]['Sync']['codeProduct']),'fields'=>'code')); //xem lại hàm này, có thể phải sử dụng find('all').
													global $modelOption;
						                $numberOrderKiosk= $modelOption->getOption('numberOrderKiosk');
						                if(empty($numberOrderKiosk['Option']['value'])) $numberOrderKiosk['Option']['value']= 0;
						                $numberOrderKiosk['Option']['value']++;
						                $modelOption->saveOption('numberOrderKiosk', $numberOrderKiosk['Option']['value']);

						                $save['Transfer']['orderId']= (int)$numberOrderKiosk['Option']['value'];

														$save['Transfer']['typedateEndPay']=(int)$listSync2[$x]['Sync']['typedateEndPay'];
														$save['Transfer']['timeServer']= (int)$listSync2[$x]['Sync']['timeClient'];
								            $save['Transfer']['timeClient']= (int)$listSync2[$x]['Sync']['timeClient'];

														$save['Transfer']['idProduct']= $listProduct['Product']['id'];
								            $save['Transfer']['codeProduct']= $listProduct['Product']['code'];

														$save['Transfer']['quantity']= (int)$listSync2[$x]['Sync']['quantity'];
								            $save['Transfer']['moneyCalculate']= (int)$listSync2[$x]['Sync']['moneyCalculate'];
								            $save['Transfer']['moneyInput']= (int)$listSync2[$x]['Sync']['moneyInput'];
								            $save['Transfer']['moneyAvailable']= (int)$listSync2[$x]['Sync']['moneyAvailable'];
								            $save['Transfer']['idMachine']= $listData[$i]['idMachine'];
								            $save['Transfer']['codeMachine']= $listData[$i]['codeMachine'];
								            $save['Transfer']['transactionId']= $listSync2[$x]['Sync']['transactionId'];
								            $save['Transfer']['slotId']= (int) $listSync2[$x]['Sync']['slotId'];
								            $save['Transfer']['status']= (int) $listSync2[$x]['Sync']['status'];
								            $save['Transfer']['coupon']= $listSync2[$x]['Sync']['coupon'];
								            $save['Transfer']['lock']= 0;
								            $save['Transfer']['area']= $listData[$i]['area'];
								            $save['Transfer']['idCity']= $listData[$i]['idCity'];
								            $save['Transfer']['idDistrict']= $listData[$i]['idDistrict'];
								            $save['Transfer']['wards']= $listData[$i]['wards'];
								            $save['Transfer']['numberHouse']= $listData[$i]['numberHouse'];
								            $save['Transfer']['idChannel']= $listData[$i]['idChannel'];
								            $save['Transfer']['idPlace']= $listData[$i]['idPlace'];
								            $save['Transfer']['idStaff']= $listData[$i]['idStaff'];
														if($modelTransfer->save($save['Transfer'])){ //code đoạn này hiện tại đang cho lưu lên bảng sync để test, chính thức sẽ đưa lên bảng transfer.
															$reportSuccess1[]='OK';
														}
														else{
															$reportFail1[]='Fail';
														}

												}//đóng if($listSync2[$x]['Sync']['status']!=0).
											}// đóng for($x).
										} // đóng if(!empty($listSync2)).

									}// đóng for().
									$countSuccess= 0;
									$countFail=0;

									if(!empty($reportSuccess)){
										$countSuccess= count($reportSuccess);
										pr($reportSuccess);
									}
									if(!empty($reportFail)){
										$countFail= count($reportFail);
									}
									$mess1='Đồng bộ thành công: '.$countSuccess.' bản ghi<br>';
									$mess2='<br>Đồng bộ thất bại: '.$countFail.' bản ghi<br>';
									echo $mess1;
									echo $mess2;
									setVariable('mess1',$mess1);
									setVariable('mess2',$mess2);
							} //đóng if(!empty($listData)).
							else{
								echo 'Không có dữ liệu để thực hiện đồng bộ';
							}

					} //đóng if(isset($_POST['sync'])).

							//xuất file excel.
							if(!empty($_POST['inport'])){

								$table = array(
									array('label' => __('STT'), 'width' => 5),
									array('label' => __('Thời gian'),'width' => 25, 'filter' => true, 'wrap' => true),
									array('label' => __('Mã máy'), 'width' => 25, 'filter' => true, 'wrap' => true),
									array('label' => __('Điểm đặt'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Tổng giao dịch trên máy'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Tổng giao dịch trên server'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Chênh lệch giao dịch'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Số lượng hàng bán ra trên máy'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Số lượng hàng bán ra trên server'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Chênh lệch Sản lượng'), 'width' => 15, 'filter' => true),
									array('label' => __('Tổng doanh thu trên máy'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Tổng doanh thu trên server'),'width' => 30, 'filter' => true, 'wrap' => true),
									array('label' => __('Chênh lệch doanh thu'), 'width' => 30, 'filter' => true),
								);
								$data= array();
								if(!empty($listData)){

									foreach ($listData as $key => $value) {
										$stt= $key+1;
										$time=$value['dateStart'].'-'.$value['dateEnd'];
										$chenhlechSL=$value['quantitySync']-$value['quantityTransfer'];
										$chenhlechDT=$value['revenueSync']-$value['revenueTransfer'];
										$chenhlechGD=$value['countSync']-$value['countTransfer'];
										$data[]= array( $stt,
											$time,
											$value['codeMachine'],
											$value['namePlace'],
											$value['countSync'],
											$value['countTransfer'],
											abs($chenhlechGD),
											$value['quantitySync'],
											$value['quantityTransfer'],
											abs($chenhlechSL),
											$value['revenueSync'],
											$value['revenueTransfer'],
											abs($chenhlechDT)
										);
									}

								}
								$exportsController = new ExportsController();
								$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'bao-cao-doi-soat-du-lieu-giao-dich')));

							}
				setVariable('listData',$listData);

				}// kết thúc if(!empty($_GET)).
			setVariable('listMachine',$listMachine);
			setVariable('listPlace',$listPlace);
				}
			}

		}

		// --------------function syncDetails--------------
		// * Người tạo: Nguyễn Tiến Hưng.
		// * Ngay tao:
		// * Ghi chú:
		// * Mục đích: Tra cứu chi tiết các dữ liệu giao dịch chệnh lệch trước khi thực hiện đồng bộ.
		// * Lịch sử sửa:
		// * Lưu ý: khi thuật toán cần sử dụng tới nhiều vòng lặp, hãy ƯU TIÊN sử dụng for thay vì foreach(nếu có thể) bởi for nhanh hơn rất nhiều so với foreach.

		function syncDetails($input){
			$modelPlace = new Place;
			$modelSync = new Sync;
			$modelTransfer = new Transfer;
			$modelMachine = new Machine;
			$modelProduct = new Product;
			if(!empty($_SESSION['infoStaff'])){
				if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin')
				|| (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('syncTransfer', $_SESSION['infoStaff']['Staff']['permission']))){
					$listPlace=$modelPlace->find('all',array('conditions'=>array('lock'=>(int)0),'fields'=>'name'));
					$listMachine=$modelMachine->find('all',array('conditions'=>array('lock'=>(int)0),'fields'=>'code'));

					if(!empty($_GET)){
						$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
						if($page<1) $page=1;

						$fieldsSync=array();
						$conditionsSync=array();
						$conditionsTransfer=array();

						if(!empty($_GET['dateStart'])){ //từ ngày.
							$dateStart= explode('/', $_GET['dateStart']);
							$dateStart1=explode(' ',$dateStart[2]);
							$dateStart2=explode(':',$dateStart1[1]);
							$time1= mktime($dateStart2[0],$dateStart2[1],$dateStart2[2],$dateStart[1],$dateStart[0],$dateStart1[0]);
							$conditionsSync['timeClient']['$gte']= $time1;
							$conditionsTransfer['timeClient']['$gte']=$time1;
						}
						if(!empty($_GET['dateEnd'])){ //đến ngày.
							$dateEnd= explode('/', $_GET['dateEnd']);
							$dateEnd1=explode(' ',$dateEnd[2]);
							$dateEnd2=explode(':',$dateEnd1[1]);
							$time2= mktime($dateEnd2[0],$dateEnd2[1],$dateEnd2[2],$dateEnd[1],$dateEnd[0],$dateEnd1[0]);
							$conditionsSync['timeClient']['$lte']= $time2;
							$conditionsTransfer['timeClient']['$lte']=$time2;
						}

						if($_GET['codeMachine']!=1){ //nếu mã máy khong trống.
								$codeMachine=trim($_GET['codeMachine']);
								$conditionsSync['codeMachine']=$codeMachine;
								$conditionsTransfer['codeMachine']=$codeMachine;
								$conditionsSync2['codeMachine']=$codeMachine;

								$dataMachine=$modelMachine->find('first',array('conditions'=>array('code'=>$codeMachine),'fields'=>array('code','idPlace','idStaff')));
								$dataPlace=$modelPlace->find('first',array('conditions'=>array('id'=>$dataMachine['Machine']['idPlace']),'fields'=>array('name','area','idCity','idDistrict','wards','numberHouse','idChannel')));

								if(empty($_GET['statusRecord'])){
									$listSync=$modelSync->find('list',array('conditions'=>$conditionsSync,'fields'=>'transactionId'));
									$listTransfer=$modelTransfer->find('list',array('conditions'=>$conditionsTransfer,'fields'=>'transactionId'));
									$refine =array_diff($listSync,$listTransfer);
									if(!empty($refine)){
										$transactionId=array_values($refine);
										$conditionsSync2['transactionId']=array('$in'=>$transactionId);
										if(!empty($_GET['typedateEndPay'])){ //hình thức thanh toán.
											$conditionsSync2['typedateEndPay']= (int)$_GET['typedateEndPay'];
										}
										if(!empty($_GET['status'])){ //trạng thái thanh toán
											$conditionsSync2['status']=(int)$_GET['status'];
										}
										$listSync2=$modelSync->find('all',array('conditions'=>$conditionsSync2,'fields'=>$fieldsSync));
										$countSync2=count($listSync2);

										for($i=0;$i<$countSync2;++$i){
											$listSync2[$i]['Sync']['idMachine']=$dataMachine['Machine']['id'];
											$listSync2[$i]['Sync']['idPlace']=$dataPlace['Place']['id'];
											$listSync2[$i]['Sync']['namePlace']=$dataPlace['Place']['name'];
											$listSync2[$i]['Sync']['idProduct']='';
											if(!empty($listSync2[$i]['Sync']['codeProduct'])){
												$product=$modelProduct->getProductCode($listSync2[$i]['Sync']['codeProduct'],array('id'));
												$listSync2[$i]['Sync']['idProduct']=$product['Product']['id'];
											}
										}// kết thúc vòng lặp for.

									} // đóng if(!empty($refine)).
									else{
										$listSync2=array();
									}
								}// đóng if(empty($_GET['statusRecord'])).
								else{
									$conditionsSync2['lock']=(int)$_GET['statusRecord'];
									$listSync2=$modelSync->find('all',array('conditions'=>$conditionsSync2,'fields'=>$fieldsSync));
									if(!empty($listSync2)){
									$countSync2=count($listSync2);
									for($i=0;$i<$countSync2;++$i){
										$listSync2[$i]['Sync']['idMachine']=$dataMachine['Machine']['id'];
										$listSync2[$i]['Sync']['idPlace']=$dataPlace['Place']['id'];
										$listSync2[$i]['Sync']['namePlace']=$dataPlace['Place']['name'];
										$listSync2[$i]['Sync']['idProduct']='';
										if(!empty($listSync2[$i]['Sync']['codeProduct'])){
											$product=$modelProduct->getProductCode($listSync2[$i]['Sync']['codeProduct'],array('id'));
											$listSync2[$i]['Sync']['idProduct']=$product['Product']['id'];
										}
									}// kết thúc vòng lặp for.

								}// đóng if(!empty($listSync2)).

							}// đóng else.

					}// đóng if($_GET['codeMachine']!=1).
						else{
							$mess= 'Hãy chọn mã máy';
							setVariable('mess',$mess);
						}
					} // đóng if(!empty($_GET)).

					if(isset($_POST['sync'])){ //nếu nút đồng bộ được click.
						if(!empty($listSync2)){ // nếu mảng $listSync2 không trống.

									if(isset($_POST['checkbox'])){ //nếu các nút checkbox được tích.
										// require_once('simple_html_dom.php');
								    // $html = file_get_html('http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
										$checkbox= $_POST['checkbox'];
										$countCheck=count($checkbox);
											for($i=0; $i<$countCheck; ++$i){
											$modelSync2 = new Sync;
											//$modelTransfer2= new Transfer;
											$modelTransfer2= new Transfer;
											global $modelOption; //xem biến $modelOption tại file function.php .
											$numberOrderKiosk= $modelOption->getOption('numberOrderKiosk');
											if(empty($numberOrderKiosk['Option']['value'])) $numberOrderKiosk['Option']['value']= 0;
											$numberOrderKiosk['Option']['value']++;
											$modelOption->saveOption('numberOrderKiosk', $numberOrderKiosk['Option']['value']);

											$save['Transfer']['orderId']= (int)$numberOrderKiosk['Option']['value'];

											$save['Transfer']['typedateEndPay']=(int)$listSync2[$checkbox[$i]]['Sync']['typedateEndPay'];
											$save['Transfer']['timeServer']= (int)$listSync2[$checkbox[$i]]['Sync']['timeClient'];
											$save['Transfer']['timeClient']= (int) $listSync2[$checkbox[$i]]['Sync']['timeClient'];

											$save['Transfer']['idProduct']= $listSync2[$checkbox[$i]]['Sync']['idProduct'];
											$save['Transfer']['codeProduct']= $listSync2[$checkbox[$i]]['Sync']['codeProduct'];

											$save['Transfer']['quantity']= (int)$listSync2[$checkbox[$i]]['Sync']['quantity'];
											$save['Transfer']['moneyCalculate']= (int)$listSync2[$checkbox[$i]]['Sync']['moneyCalculate'];
											$save['Transfer']['moneyInput']= (int)$listSync2[$checkbox[$i]]['Sync']['moneyInput'];
											$save['Transfer']['moneyAvailable']= (int)$listSync2[$checkbox[$i]]['Sync']['moneyAvailable'];
											$save['Transfer']['idMachine']= $dataMachine['Machine']['id'];
											$save['Transfer']['codeMachine']= $dataMachine['Machine']['code'];
											$save['Transfer']['transactionId']= $listSync2[$checkbox[$i]]['Sync']['transactionId'];
											$save['Transfer']['slotId']= (int) $listSync2[$checkbox[$i]]['Sync']['slotId'];
											$save['Transfer']['status']= (int) $listSync2[$checkbox[$i]]['Sync']['status'];
											$save['Transfer']['coupon']= $listSync2[$checkbox[$i]]['Sync']['coupon'];
											$save['Transfer']['lock']= 0;
											$save['Transfer']['area']= $dataPlace['Place']['area'];
											$save['Transfer']['idCity']= $dataPlace['Place']['idCity'];
											$save['Transfer']['idDistrict']= $dataPlace['Place']['idDistrict'];
											$save['Transfer']['wards']= $dataPlace['Place']['wards'];
											$save['Transfer']['numberHouse']= $dataPlace['Place']['numberHouse'];
											$save['Transfer']['idChannel']= $dataPlace['Place']['idChannel'];
											$save['Transfer']['idPlace']= $dataPlace['Place']['id'];
											$save['Transfer']['idStaff']= $dataMachine['Machine']['idStaff'];
											if($modelTransfer2->save($save['Transfer'])){
												$reportSuccess[]='OK';
												$dataSync=$modelSync2->getSync($listSync2[$checkbox[$i]]['Sync']['id']);
												$dataSync['Sync']['lock']=(int)1;
												$modelSync2->save($dataSync['Sync']);
											}
											else{
												$reportFail[]='Fail';
												$dataSync=$modelSync2->getSync($listSync2[$checkbox[$i]]['Sync']['id']);
												$dataSync['Sync']['lock']=(int)2;
												$modelSync2->save($dataSync['Sync']);
											}
										}//đóng for.
										$countSuccess= 0;
										$countFail=0;
										if(!empty($reportSuccess)){
											$countSuccess= count($reportSuccess);
										}
										if(!empty($reportFail)){
											$countFail= count($reportFail);
										}
										$mess1='Đồng bộ thành công: '.$countSuccess.' bản ghi';
										$mess2='Đồng bộ thất bại: '.$countFail.' bản ghi';
										$listSync2=$modelSync->find('all',array('conditions'=>$conditionsSync2,'fields'=>$fieldsSync));
										$count=count($listSync2);

										for($i=0;$i<$count;++$i){
											$listSync2[$i]['Sync']['idMachine']=$dataMachine['Machine']['id'];
											$listSync2[$i]['Sync']['idPlace']=$dataPlace['Place']['id'];
											$listSync2[$i]['Sync']['namePlace']=$dataPlace['Place']['name'];
											$listSync2[$i]['Sync']['idProduct']='';
											if(!empty($listSync2[$i]['Sync']['codeProduct'])){
												$product=$modelProduct->getProductCode($listSync2[$i]['Sync']['codeProduct'],array('id'));
												$listSync2[$i]['Sync']['idProduct']=$product['Product']['id'];
											}
										}// kết thúc vòng lặp for.

										setVariable('mess1',$mess1);
										setVariable('mess2',$mess2);
									}// đóng if(isset($_POST['checkbox'])).
									else{ //nếu nút checkbox không được tích.
										$mess3='Hãy chọn bản ghi để thực hiện đồng bộ';
										setVariable('mess3',$mess3);
									}
								}// đóng if(!empty($listSync2)).
								else{
									$mess4= ' Không có dữ liệu để đồng bộ';
									setVariable('mess4',$mess4);
								}

							}//đóng if(isset($_POST['sync'])).
					setVariable('listSync2',@$listSync2); //Hàm setVariable dùng để hiển thị dữ liệu của biến.
					setVariable('listMachine',$listMachine);
					setVariable('listPlace',$listPlace);

				}
			}
		}

 ?>
