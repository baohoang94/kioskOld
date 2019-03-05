<?php
function listTransfer($input)
{
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	$metaTitleMantan= 'Lịch sử giao dịch';

	$dataSend = $input['request']->data;
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelPlace = new Place;
	global $listTypePay;
	global $listStatusPay;
	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listTransfer', $_SESSION['infoStaff']['Staff']['permission']))){
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
			if(!empty($_GET)){
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 500;
				$conditions = array();
				$order = array('timeServer'=>'DESC');
				$fields= array('codeMachine','status','typedateEndPay','timeServer','slotId','codeProduct','orderId','moneyInput','moneyCalculate','idProduct','idMachine','timeClient','quantity','transactionId','moneyAvailable');
				// $conditions['lock']=(int)0;
				// if(isset($_GET['status']) && $_GET['status']!=''){
				// 	$conditions['status']=(int)$_GET['status'];
				// }

				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listTransfer', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['dateStart'])){
					$date= explode('/', $_GET['dateStart']);
					$time= mktime(0,0,0,$date[1],$date[0],$date[2]);
					$conditions['timeServer']['$gte']= $time;
				}

				if(!empty($_GET['dateEnd'])){
					$date1= explode('/', $_GET['dateEnd']);
					$time1= mktime(23,59,59,$date1[1],$date1[0],$date1[2]);
					$conditions['timeServer']['$lte']= $time1;
				}

				if(!empty($_GET['codeMachine'])){
					$codeMachine=trim($_GET['codeMachine']);
					$conditions['codeMachine']= array('$regex' => $codeMachine);
				}
				if(!empty($_GET['codeProduct'])){
					$codeProduct=trim($_GET['codeProduct']);
					$conditions['codeProduct']= array('$regex' => $codeProduct);
				}
				if(!empty($_GET['transactionId'])){
					$orderId=trim($_GET['transactionId']);
					$conditions['orderId']= (int) $orderId;
				}
				if(!empty($_GET['quantity'])){
					$quantity=trim($_GET['quantity']);
					$quantity1=str_replace( array(',','.'),'',$quantity );
					$conditions['quantity']= (int)$quantity1;
				}
				if(!empty($_GET['money'])){
					$money=trim($_GET['money']);
					$money1=str_replace( array(',','.'),'',$money );
					$conditions['moneyCalculate']= (int)$money1;
				}
				if(!empty($_GET['moneyInput'])){
					$moneyInput=trim($_GET['moneyInput']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyInput']= (int)$moneyInput1;
				}
				if(!empty($_GET['moneyAvailable'])){
					$moneyInput=trim($_GET['moneyAvailable']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyAvailable']= (int)$moneyInput1;
				}
				if(!empty($_GET['typedateEndPay'])){
					$typedateEndPay=trim($_GET['typedateEndPay']);
					$conditions['typedateEndPay']= (int)$typedateEndPay;
				}

				if(!empty($_GET['area'])){
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
				}

				if(!empty($_GET['idCity'])){
					$idCity=trim($_GET['idCity']);
					$conditions['idCity']=array('$regex' => $idCity);
				}
				if(!empty($_GET['idDistrict'])){
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['codeStaff'])){
					$listMachine= $modelMachine->find('all',array('fields'=>array('code'),'conditions'=>array('codeStaff'=>$_GET['codeStaff'])));
					$listIdMachine= array();
					if($listMachine){
						foreach($listMachine as $machine){
							$listIdMachine[]= $machine['Machine']['id'];
						}
					}
					$conditions['idMachine']= array('$in'=>$listIdMachine);
				}
				if(!empty($_GET['idPlace'])){
					$idPlace=trim($_GET['idPlace']);
					$conditions['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['slotId'])){
					$conditions['slotId']=(int) $_GET['slotId'];
				}


				if(!empty($_GET['wards'])){
					$conditions['wards']=array('$regex' => $_GET['wards']);
				}
				if(!empty($_GET['numberHouse'])){
					$numberHouse=trim($_GET['numberHouse']);
					$conditions['numberHouse']=array('$regex' =>$numberHouse );
				}
				if(isset($_GET['status'])){
					 if (is_numeric($_GET['status'])){
					 	$conditions['status']=(int)$_GET['status'];
					 }

					// pr($_GET['status']);
				}
				if(!empty($_GET['idChannel'])){
					$conditions['idChannel']=$_GET['idChannel'];
					// $conditions['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				// debug($conditions);
				$listData= $modelTransfer->getPage($page, $limit , $conditions, $order, $fields );
				$listStaff= array();
				$listProduct= array();

				if($listData){
					foreach($listData as $data){
						if(empty($listStaff[$data['Transfer']['idMachine']])){
							$listStaff[$data['Transfer']['idMachine']]= $modelMachine->getMachine($data['Transfer']['idMachine'],array('codeStaff','idStaff'));
						}

						if(empty($listProduct[$data['Transfer']['idProduct']])){
							$listProduct[$data['Transfer']['idProduct']]= $modelProduct->getProduct($data['Transfer']['idProduct'],array('name'));
						}
					}
				}

				$totalData= $modelTransfer->find('count',array('conditions' => $conditions));
				$balance= $totalData%$limit;
				$totalPage= ($totalData-$balance)/$limit;
				if($balance>0)$totalPage+=1;

				$back=$page-1;$next=$page+1;
				if($back<=0) $back=1;
				if($next>=$totalPage) $next=$totalPage;

				if(isset($_GET['page'])){
					$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
					$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
				}else{
					$urlPage= $urlNow;
				}

				if(strpos($urlPage,'?')!== false){
					if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
						$urlPage= $urlPage.'&page=';
					}else{
						$urlPage= $urlPage.'page=';
					}
				}else{
					$urlPage= $urlPage.'?page=';
				}


			// xuất excel


			//$listData2=$modelTransfer->find('all',array('conditions'=>$conditions,'fields'=>$fields,'order'=>$order));

				if(!empty($_POST['inport'])){
					//$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditions,'limit'=>500,'order'=>$order,'fields'=>array('codeMachine','status','typedateEndPay','timeServer','slotId','codeProduct','orderId','moneyInput','moneyCalculate','quantity')));
					$listTransfer= $listData;
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Thời gian'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã máy'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Slot ID'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã sản phẩm'), 'width' => 15, 'filter' => true),
						array('label' => __('Mã giao dịch'), 'width' => 15, 'filter' => true),
						array('label' => __('Số lượng'), 'width' => 15, 'filter' => true),
						array('label' => __('Doanh thu bán hàng(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số tiền khách nạp(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số dư tài khoản khách(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Hình thức thanh toán'), 'width' => 15, 'filter' => true),
						array('label' => __('Trạng thái'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					unset($listData);
					unset($listStaff);
					unset($listProduct);

					if(!empty($listTransfer)){
						foreach ($listTransfer as $key => $value) {
							$stt= $key+1;
							$time=date('d/m/Y H:i:s',@$value['Transfer']['timeServer']);
							$tt=@$listTypePay[$value['Transfer']['typedateEndPay']]['name'];
							$ttt=@$listStatusPay[$value['Transfer']['status']]['name'];
							$moneyAvailable = (isset($value['Transfer']['moneyAvailable']))?$value['Transfer']['moneyAvailable']:'0';
							$data[]= array( $stt,
								$time,
								@$value['Transfer']['codeMachine'],
								@$value['Transfer']['slotId'],
								@$value['Transfer']['codeProduct'],
								@$value['Transfer']['orderId'],
								@$value['Transfer']['quantity'],
								@$value['Transfer']['moneyCalculate'],
								@$value['Transfer']['moneyInput'],
								$moneyAvailable,
								$tt,
								$ttt
							);
						}
					}

					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Lich-su-giao-dich')));
				}

				setVariable('listData',$listData);
				setVariable('listStaff',$listStaff);
				setVariable('listProduct',$listProduct);

				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
				setVariable('mess',$mess);
			}
			setVariable('listPlace',$listPlace);
		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
function viewTransfer($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Chi tiết giao dịch';

	$dataSend = $input['request']->data;
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelPlace= new Place;
	$modelPatner= new Patner;
	$modelWards= new Wards;
	global $listTypePay;
	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewTransfer', $_SESSION['infoStaff']['Staff']['permission']))){
			$id=$input['request']->params['pass']['1'];
			$city=$modelOption->getOption('cityKiosk');
			if(!empty($id)){
				$data=$modelTransfer->getTransfer($id,$fields=array() );
				if(!empty($data['Transfer']['idProduct'])){
					$product=$modelProduct->getProduct($data['Transfer']['idProduct'],$fields=array('code','name') );
					setVariable('product',$product);
					if(!empty($data['Transfer']['idPlace'])){
						$place=$modelPlace->getPlace($data['Transfer']['idPlace'],array('name','idPatner'));
						setVariable('place',$place);
						if(!empty($place['Place']['idPatner'])){
							$patner=$modelPatner->getPatner($place['Place']['idPatner'],$fields=array('name'));
							setVariable('patner',$patner);
						}
					}
				}
				if(!empty($data['Transfer']['idCity'])){
					@$dataCity=$city['Option']['value']['allData'][$data['Transfer']['idCity']]['name'];
					setVariable('dataCity',$dataCity);
				}
				if(!empty($data['Transfer']['idDistrict'])){
					@$dataDistrict=$city['Option']['value']['allData'][$data['Transfer']['idCity']]['district'][$data['Transfer']['idDistrict']]['name'];
					setVariable('dataDistrict',$dataDistrict);
				}
				if(!empty($data['Transfer']['wards'])){
					$wards=$modelWards->getWards($data['Transfer']['wards'],$fields=array('name') );
					setVariable('wards',$wards);
				}
				$listChannelProduct=$modelOption->getOption('listChannelProduct');


				setVariable('data',$data);
				setVariable('listChannelProduct',$listChannelProduct);
				setVariable('listTypePay',$listTypePay);

			}
		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}

}
// giao dịch bằng mã Coupon
function transactionWhitCoupon(){
	$modelTransfer = new Transfer();
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Lịch sử giao dịch Coupon';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelPlace = new Place;
	global $listTypePay;
	global $listStatusPay;

	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('transactionWhitCoupon', $_SESSION['infoStaff']['Staff']['permission']))){
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
			if(!empty($_GET)){
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 500;
				$order = array('timeServer'=>'DESC');
				$fields= array('codeMachine','status','typedateEndPay','timeServer','slotId','codeProduct','orderId','moneyInput','moneyAvailable','moneyCalculate','idProduct','idMachine','timeClient','quantity','coupon','transactionId');

			//$conditions['status']=(int)1;

				$listStaff= array();
				$listProduct= array();

				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('transactionWhitCoupon', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['status'])){
					$conditions['status']=(int) $_GET['status'];
				}

				if(!empty($_GET['dateStart'])){
					$date= explode('/', $_GET['dateStart']);
					$time= mktime(0,0,0,$date[1],$date[0],$date[2]);
					$conditions['timeServer']['$gte']= $time;
				}

				if(!empty($_GET['dateEnd'])){
					$date= explode('/', $_GET['dateEnd']);
					$time= mktime(23,59,59,$date[1],$date[0],$date[2]);
					$conditions['timeServer']['$lte']= $time;
				}

				if(!empty($_GET['codeMachine'])){
					$codeMachine=trim($_GET['codeMachine']);
					$conditions['codeMachine']= array('$regex' => $codeMachine);
				}
				if(!empty($_GET['codeProduct'])){
					$codeProduct=trim($_GET['codeProduct']);
					$conditions['codeProduct']= array('$regex' => $codeProduct);
				}
				if(!empty($_GET['transactionId'])){
					$orderId=trim($_GET['transactionId']);
					$conditions['orderId']= (int) $orderId;
				}
				if(!empty($_GET['quantity'])){
					$quantity=trim($_GET['quantity']);
					$quantity1=str_replace( array(',','.'),'',$quantity );
					$conditions['quantity']= (int)$quantity1;
				}
				if(!empty($_GET['money'])){
					$money=trim($_GET['money']);
					$money1=str_replace( array(',','.'),'',$money );
					$conditions['moneyCalculate']= (int)$money1;
				}
				if(!empty($_GET['moneyAvailable'])){
					$moneyInput=trim($_GET['moneyAvailable']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyAvailable']= (int)$moneyInput1;
				}
				if(!empty($_GET['moneyInput'])){
					$moneyInput=trim($_GET['moneyInput']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyInput']= (int)$moneyInput1;
				}
				if(!empty($_GET['moneyAvailable'])){
					$moneyInput=trim($_GET['moneyAvailable']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyAvailable']= (int)$moneyInput1;
				}
				// if(!empty($_GET['typedateEndPay'])){
				// 	$typedateEndPay=trim($_GET['typedateEndPay']);
				// 	$conditions['typedateEndPay']= (int)$typedateEndPay;
				// }
				if(!empty($_GET['idChannel'])){
					$conditions['idChannel']=$_GET['idChannel'];
				}
				if(!empty($_GET['area'])){
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
				}

				if(!empty($_GET['idCity'])){
					$idCity=trim($_GET['idCity']);
					$conditions['idCity']=array('$regex' => $idCity);
				}
				if(!empty($_GET['idDistrict'])){
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['codeStaff'])){
					$listMachine= $modelMachine->find('all',array('fields'=>array('code'),'conditions'=>array('codeStaff'=>$_GET['codeStaff'])));
					$listIdMachine= array();
					if($listMachine){
						foreach($listMachine as $machine){
							$listIdMachine[]= $machine['Machine']['id'];
						}
					}
					$conditions['idMachine']= array('$in'=>$listIdMachine);
				}
				if(!empty($_GET['idPlace'])){
					$idPlace=trim($_GET['idPlace']);
					$conditions['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['slotId'])){
					$conditions['slotId']=(int) $_GET['slotId'];
				}
				if(!empty($_GET['wards'])){
					$conditions['wards']=array('$regex' => $_GET['wards']);
				}
				if(!empty($_GET['numberHouse'])){
					$numberHouse=trim($_GET['numberHouse']);
					$conditions['numberHouse']=array('$regex' =>$numberHouse );
				}
				if(!empty($_GET['coupon'])){
					$coupon=trim($_GET['coupon']);
					$conditions['coupon'] = array('$regex' => $coupon);
				}
				$conditions['typedateEndPay']=(int)3;
				$listData= $modelTransfer->getPage($page, $limit , $conditions, $order, $fields );


				$totalData= $modelTransfer->find('count',array('conditions' => $conditions));
				$balance= $totalData%$limit;
				$totalPage= ($totalData-$balance)/$limit;
				if($balance>0)$totalPage+=1;

				$back=$page-1;$next=$page+1;
				if($back<=0) $back=1;
				if($next>=$totalPage) $next=$totalPage;

				if(isset($_GET['page'])){
					$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
					$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
				}else{
					$urlPage= $urlNow;
				}

				if(strpos($urlPage,'?')!== false){
					if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
						$urlPage= $urlPage.'&page=';
					}else{
						$urlPage= $urlPage.'page=';
					}
				}else{
					$urlPage= $urlPage.'?page=';
				}
				$listChannelProduct= $modelOption->getOption('listChannelProduct');

			// xuất excel
				//$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditions,'order'=>$order,'fields'=>array('codeMachine','status','typedateEndPay','timeServer','slotId','codeProduct','orderId','moneyInput','moneyAvailable','moneyCalculate','quantity','coupon')));
				if(!empty($_POST['inport'])){
					$listTransfer= $listData;
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Thời gian'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã máy'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã coupon'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Slot ID'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã sản phẩm'), 'width' => 15, 'filter' => true),
						array('label' => __('Mã giao dịch'), 'width' => 15, 'filter' => true),
						array('label' => __('Số lượng'), 'width' => 15, 'filter' => true),
						array('label' => __('Doanh thu bán hàng(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số tiền khách nạp(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số dư tài khoản khách(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Hình thức thanh toán'), 'width' => 15, 'filter' => true),
						array('label' => __('Trạng thái'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($listTransfer)){
					//pr(count($listTransfer));
						foreach ($listTransfer as $key => $value) {
							$stt= $key+1;
							$time=date('d/m/Y H:i:s',$value['Transfer']['timeServer']);
							$tt=$listTypePay[$value['Transfer']['typedateEndPay']]['name'];
							$ttt=$listStatusPay[$value['Transfer']['status']]['name'];
							$moneyAvailable = (isset($value['Transfer']['moneyAvailable']))?$value['Transfer']['moneyAvailable']:'0';

							$data[]= array( $stt,
								$time,
								$value['Transfer']['codeMachine'],
								$value['Transfer']['coupon'],
								$value['Transfer']['slotId'],
								$value['Transfer']['codeProduct'],
								$value['Transfer']['orderId'],
								$value['Transfer']['quantity'],
								$value['Transfer']['moneyCalculate'],
								$value['Transfer']['moneyInput'],
								$moneyAvailable,
								$tt,
								$ttt
							);
						}
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Lich-su-giao-dich-ma-coupon')));
				}
				setVariable('listChannelProduct',$listChannelProduct);
				setVariable('listData',$listData);
				setVariable('listStaff',$listStaff);
				setVariable('listProduct',$listProduct);

				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
				setVariable('mess',$mess);

			}
			setVariable('listPlace',$listPlace);

		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}

}
function deleteTransactionByEmployees(){
	$modelTransfer = new Transfer();
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	$metaTitleMantan= 'Lịch sử giao dịch Coupon';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelLog= new Log();
	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteTransactionByEmployees', $_SESSION['infoStaff']['Staff']['permission']))){
			if(!empty($_GET['id'])&&!empty($_GET['url'])){
				$data['$set']['lock']=(int)1;
				$dk= array('_id'=>new MongoId($_GET['id']));

				if($modelTransfer->updateAll($data,$dk)){
                	// lưu lịch sử tạo sản phẩm
					$saveLog['Log']['time']= time();
					$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' xóa giao dịch  giá có ID là '.$_GET['id'];
					$modelLog->save($saveLog);

					$modelTransfer->redirect($urlHomes.'/'.$_GET['url']);
				}else{
					$modelTransfer->redirect($urlHomes.'/'.$_GET['url']);
				}
			}
		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
// lịch sử giao dịch tiền mặt
function transactionWhitCash(){
	$modelTransfer = new Transfer();
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Lịch sử giao dịch tiền mặt';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelPlace = new Place;
	global $listTypePay;
	global $listStatusPay;
	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('transactionWhitCash', $_SESSION['infoStaff']['Staff']['permission']))){
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
			$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
			if($page<1) $page=1;
			$limit= 500;
			// $conditions = array();
			$order = array('timeServer'=>'DESC');
			$fields= array('codeMachine','status','typedateEndPay','timeServer','slotId','codeProduct','orderId','moneyInput','moneyAvailable','moneyCalculate','idProduct','idMachine','timeClient','quantity','transactionId');

			if (!empty($_GET)) {

				# code...

			//$conditions['status']=(int)1;

				$listStaff= array();
				$listProduct= array();

				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('transactionWhitCash', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['status'])){
					$conditions['status']=(int) $_GET['status'];
				}
				if(!empty($_GET['dateStart'])){
					$date= explode('/', $_GET['dateStart']);
					$time= mktime(0,0,0,$date[1],$date[0],$date[2]);
					$conditions['timeServer']['$gte']= $time;
				}

				if(!empty($_GET['dateEnd'])){
					$date= explode('/', $_GET['dateEnd']);
					$time= mktime(23,59,59,$date[1],$date[0],$date[2]);
					$conditions['timeServer']['$lte']= $time;
				}

				if(!empty($_GET['codeMachine'])){
					$codeMachine=trim($_GET['codeMachine']);
					$conditions['codeMachine']= array('$regex' => $codeMachine);
				}
				if(!empty($_GET['codeProduct'])){
					$codeProduct=trim($_GET['codeProduct']);
					$conditions['codeProduct']= array('$regex' => $codeProduct);
				}
				if(!empty($_GET['transactionId'])){
					$orderId=trim($_GET['transactionId']);
					$conditions['orderId']= (int) $orderId;
				}
				if(!empty($_GET['quantity'])){
					$quantity=trim($_GET['quantity']);
					$quantity1=str_replace( array(',','.'),'',$quantity );
					$conditions['quantity']= (int)$quantity1;
				}
				if(!empty($_GET['money'])){
					$money=trim($_GET['money']);
					$money1=str_replace( array(',','.'),'',$money );
					$conditions['moneyCalculate']= (int)$money1;
				}
				if(!empty($_GET['moneyInput'])){
					$moneyInput=trim($_GET['moneyInput']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyInput']= (int)$moneyInput1;
				}
				if(!empty($_GET['moneyAvailable'])){
					$moneyInput=trim($_GET['moneyAvailable']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyAvailable']= (int)$moneyInput1;
				}
				if(!empty($_GET['idChannel'])){
					$conditions['idChannel']=$_GET['idChannel'];
				}
				if(!empty($_GET['area'])){
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
				}

				if(!empty($_GET['idCity'])){
					$idCity=trim($_GET['idCity']);
					$conditions['idCity']=array('$regex' => $idCity);
				}
				if(!empty($_GET['idDistrict'])){
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['codeStaff'])){
					$listMachine= $modelMachine->find('all',array('fields'=>array('code'),'conditions'=>array('codeStaff'=>$_GET['codeStaff'])));
					$listIdMachine= array();
					if($listMachine){
						foreach($listMachine as $machine){
							$listIdMachine[]= $machine['Machine']['id'];
						}
					}
					$conditions['idMachine']= array('$in'=>$listIdMachine);
				}
				if(!empty($_GET['idPlace'])){
					$idPlace=trim($_GET['idPlace']);
					$conditions['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['slotId'])){
					$conditions['slotId']=(int) $_GET['slotId'];
				}
				if(!empty($_GET['wards'])){
					$conditions['wards']=array('$regex' => $_GET['wards']);
				}
				if(!empty($_GET['numberHouse'])){
					$numberHouse=trim($_GET['numberHouse']);
					$conditions['numberHouse']=array('$regex' =>$numberHouse );
				}
				$conditions['typedateEndPay']=(int)1;
				$listData= $modelTransfer->getPage($page, $limit , $conditions, $order, $fields );
				$totalData= $modelTransfer->find('count',array('conditions' => $conditions));
				$balance= $totalData%$limit;
				$totalPage= ($totalData-$balance)/$limit;
				if($balance>0)$totalPage+=1;

				$back=$page-1;$next=$page+1;
				if($back<=0) $back=1;
				if($next>=$totalPage) $next=$totalPage;

				if(isset($_GET['page'])){
					$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
					$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
				}else{
					$urlPage= $urlNow;
				}

				if(strpos($urlPage,'?')!== false){
					if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
						$urlPage= $urlPage.'&page=';
					}else{
						$urlPage= $urlPage.'page=';
					}
				}else{
					$urlPage= $urlPage.'?page=';
				}
				$listChannelProduct= $modelOption->getOption('listChannelProduct');

				//$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditions,'order'=>$order,'fields'=>array('codeMachine','status','typedateEndPay','timeServer','slotId','codeProduct','orderId','moneyInput','moneyAvailable','moneyCalculate','quantity')));
				if(!empty($_POST['inport'])){
					$listTransfer= $listData;
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Thời gian'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã máy'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Slot ID'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã sản phẩm'), 'width' => 15, 'filter' => true),
						array('label' => __('Mã giao dịch'), 'width' => 15, 'filter' => true),
						array('label' => __('Số lượng'), 'width' => 15, 'filter' => true),
						array('label' => __('Doanh thu bán hàng(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số tiền khách nạp(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số dư tài khoản khách(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Hình thức thanh toán'), 'width' => 15, 'filter' => true),
						array('label' => __('Trạng thái'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($listTransfer)){
					//pr(count($listTransfer));
						foreach ($listTransfer as $key => $value) {
							$stt= $key+1;
							$time=date('d/m/Y H:i:s',$value['Transfer']['timeServer']);
							$tt=$listTypePay[$value['Transfer']['typedateEndPay']]['name'];
							$ttt=$listStatusPay[$value['Transfer']['status']]['name'];
							$data[]= array( $stt,
								$time,
								$value['Transfer']['codeMachine'],
								$value['Transfer']['slotId'],
								$value['Transfer']['codeProduct'],
								$value['Transfer']['orderId'],
								$value['Transfer']['quantity'],
								$value['Transfer']['moneyCalculate'],
								$value['Transfer']['moneyInput'],
								$value['Transfer']['moneyAvailable'],
								$tt,
								$ttt
							);
						}
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Lich-su-giao-dich-tien-mat')));

				}
				setVariable('listChannelProduct',$listChannelProduct);
				setVariable('listData',$listData);
				setVariable('listStaff',$listStaff);
				setVariable('listProduct',$listProduct);

				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
				setVariable('mess',$mess);
			}
			setVariable('listPlace',$listPlace);


		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
// lịch sử giao dịch bằng QR code
function transactionWhitQRViettin(){
	$modelTransfer = new Transfer();
	global $urlHomes;
	global $urlNow;
	global $modelOption;
	global $metaTitleMantan;
	$metaTitleMantan= 'Lịch sử giao dịch QR VietinBank';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelPlace = new Place;
	global $listTypePay;
	global $listStatusPay;
	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('transactionWhitQRViettin', $_SESSION['infoStaff']['Staff']['permission']))){
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
			if (!empty($_GET)) {
				# code...
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 500;
				$order = array('timeServer'=>'DESC');
				$fields= array('codeMachine','status','typedateEndPay','timeServer','slotId','codeProduct','orderId','moneyAvailable','moneyInput','moneyCalculate','idProduct','idMachine','timeClient','quantity','transactionId');

			//$conditions['status']=(int)1;

				$listStaff= array();
				$listProduct= array();

				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('transactionWhitQRViettin', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['status'])){
					$conditions['status']=(int) $_GET['status'];
				}
				if(!empty($_GET['dateStart'])){
					$date= explode('/', $_GET['dateStart']);
					$time= mktime(0,0,0,$date[1],$date[0],$date[2]);
					$conditions['timeServer']['$gte']= $time;
				}

				if(!empty($_GET['dateEnd'])){
					$date= explode('/', $_GET['dateEnd']);
					$time= mktime(23,59,59,$date[1],$date[0],$date[2]);
					$conditions['timeServer']['$lte']= $time;
				}

				if(!empty($_GET['codeMachine'])){
					$codeMachine=trim($_GET['codeMachine']);
					$conditions['codeMachine']= array('$regex' => $codeMachine);
				}
				if(!empty($_GET['codeProduct'])){
					$codeProduct=trim($_GET['codeProduct']);
					$conditions['codeProduct']= array('$regex' => $codeProduct);
				}
				if(!empty($_GET['transactionId'])){
					$orderId=trim($_GET['transactionId']);
					$conditions['orderId']= (int) $orderId;
				}
				if(!empty($_GET['quantity'])){
					$quantity=trim($_GET['quantity']);
					$quantity1=str_replace( array(',','.'),'',$quantity );
					$conditions['quantity']= (int)$quantity1;
				}
				if(!empty($_GET['money'])){
					$money=trim($_GET['money']);
					$money1=str_replace( array(',','.'),'',$money );
					$conditions['moneyCalculate']= (int)$money1;
				}
				if(!empty($_GET['moneyInput'])){
					$moneyInput=trim($_GET['moneyInput']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyInput']= (int)$moneyInput1;
				}
				if(!empty($_GET['moneyAvailable'])){
					$moneyInput=trim($_GET['moneyAvailable']);
					$moneyInput1=str_replace( array(',','.'),'',$moneyInput );
					$conditions['moneyAvailable']= (int)$moneyInput1;
				}
				// if(!empty($_GET['typedateEndPay'])){
				// 	$typedateEndPay=trim($_GET['typedateEndPay']);
				// 	$conditions['typedateEndPay']= (int)$typedateEndPay;
				// }
				if(!empty($_GET['idChannel'])){
					$conditions['idChannel']=$_GET['idChannel'];
				}
				if(!empty($_GET['area'])){
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
				}

				if(!empty($_GET['idCity'])){
					$idCity=trim($_GET['idCity']);
					$conditions['idCity']=array('$regex' => $idCity);
				}
				if(!empty($_GET['idDistrict'])){
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['codeStaff'])){
					$listMachine= $modelMachine->find('all',array('fields'=>array('code'),'conditions'=>array('codeStaff'=>$_GET['codeStaff'])));
					$listIdMachine= array();
					if($listMachine){
						foreach($listMachine as $machine){
							$listIdMachine[]= $machine['Machine']['id'];
						}
					}
					$conditions['idMachine']= array('$in'=>$listIdMachine);
				}
				if(!empty($_GET['idPlace'])){
					$idPlace=trim($_GET['idPlace']);
					$conditions['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['slotId'])){
					$conditions['slotId']=(int) $_GET['slotId'];
				}
				if(!empty($_GET['wards'])){
					$conditions['wards']=array('$regex' => $_GET['wards']);
				}
				if(!empty($_GET['numberHouse'])){
					$numberHouse=trim($_GET['numberHouse']);
					$conditions['numberHouse']=array('$regex' =>$numberHouse );
				}
				$conditions['typedateEndPay']=(int)4;
				$listData= $modelTransfer->getPage($page, $limit , $conditions, $order, $fields );
				$totalData= $modelTransfer->find('count',array('conditions' => $conditions));
				$balance= $totalData%$limit;
				$totalPage= ($totalData-$balance)/$limit;
				if($balance>0)$totalPage+=1;

				$back=$page-1;$next=$page+1;
				if($back<=0) $back=1;
				if($next>=$totalPage) $next=$totalPage;

				if(isset($_GET['page'])){
					$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
					$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
				}else{
					$urlPage= $urlNow;
				}

				if(strpos($urlPage,'?')!== false){
					if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
						$urlPage= $urlPage.'&page=';
					}else{
						$urlPage= $urlPage.'page=';
					}
				}else{
					$urlPage= $urlPage.'?page=';
				}
				$listChannelProduct= $modelOption->getOption('listChannelProduct');

				//$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditions,'order'=>$order,'fields'=>array('codeMachine','status','typedateEndPay','moneyAvailable','timeServer','slotId','codeProduct','orderId','moneyInput','moneyAvailable','moneyCalculate','quantity')));
				if(!empty($_POST['inport'])){
					$listTransfer= $listData;
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Thời gian'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã máy'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Slot ID'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã sản phẩm'), 'width' => 15, 'filter' => true),
						array('label' => __('Mã giao dịch'), 'width' => 15, 'filter' => true),
						array('label' => __('Số lượng'), 'width' => 15, 'filter' => true),
						array('label' => __('Doanh thu bán hàng(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số tiền khách nạp(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Số dư tài khoản khách(vnđ)'), 'width' => 15, 'filter' => true),
						array('label' => __('Hình thức thanh toán'), 'width' => 15, 'filter' => true),
						array('label' => __('Trạng thái'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($listTransfer)){
					//pr(count($listTransfer));
						foreach ($listTransfer as $key => $value) {
							$stt= $key+1;
							$time=date('d/m/Y H:i:s',$value['Transfer']['timeServer']);
							$tt=$listTypePay[$value['Transfer']['typedateEndPay']]['name'];
							$ttt=$listStatusPay[$value['Transfer']['status']]['name'];
							$data[]= array( $stt,
								$time,
								$value['Transfer']['codeMachine'],
								$value['Transfer']['slotId'],
								$value['Transfer']['codeProduct'],
								$value['Transfer']['orderId'],
								$value['Transfer']['quantity'],
								$value['Transfer']['moneyCalculate'],
								$value['Transfer']['moneyInput'],
								$value['Transfer']['moneyAvailable'],
								$tt,
								$ttt
							);
						}
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Lich-su-giao-dich-qr-VietinBank')));
				}
				setVariable('listChannelProduct',$listChannelProduct);
				setVariable('listData',$listData);
				setVariable('listStaff',$listStaff);
				setVariable('listProduct',$listProduct);

				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
				setVariable('mess',$mess);
			}
			setVariable('listPlace',$listPlace);


		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}

// --------------function machinesTransfer--------------
// * Người tạo: Nguyễn Tiến Hưng.
// * Ngày tạo: 26/08/2018.
// * Ghi chú:
// * Mục đích: Tra cứu các máy có hoặc không có giao dịch trong 1 khoảng thời gian được chọn.
// * Lịch sử sửa:
//
// --------------------------------------------------
function machinesTransfer($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $listStatusMachine;
	global $listTypePay;
	global $listStatusPay;
	global $listStatusTransfer;

	$dataSend = $input['request']->data;
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelLogTransaction= new Logtransaction();
	$modelPlace= new Place();
	$mess= '';
	$data=array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('machinesTransfer', $_SESSION['infoStaff']['Staff']['permission']))){
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));

			if(!empty($_GET)){
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 500;
				$conditions = array();
				$order = array('timeServer'=>'DESC');
				$fields= array('timeServer','codeMachine','idStaff','timeClient','idMachine');
				$conditions['lock']=(int)0;

				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listTransfer', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['dateEnd'])){
					$date= explode('/', $_GET['dateEnd']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$lte']= $time;
				}
				if(empty($_GET['dateEnd'])){
					$_GET['dateEnd']=date('d/m/Y H:i:s',(time()+25200));
					$conditions['timeServer']['$lte']=time();
				}

				if(!empty($_GET['dateStart'])){
					$date= explode('/', $_GET['dateStart']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$gte']= $time;
				}
				if(empty($_GET['dateStart'])){
					if(!empty($_GET['dateEnd'])){
						$date= explode('/', $_GET['dateEnd']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$time2=$time-3600;
						$_GET['dateStart']=date('d/m/Y H:i:s',$time2);
						$conditions['timeServer']['$gte']=$time2;
					}
					if(empty($_GET['dateEnd'])){
						$_GET['dateStart']=date('d/m/Y H:i:s',(time()-3600));
						$conditions['timeServer']['$gte']=(time()-3600);
					}
				}

				if(!empty($_GET['idChannel'])){//kênh bán hàng
					$conditions['idChannel']=$_GET['idChannel'];
					$conditionsTransfer['idChannel']=$_GET['idChannel'];
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
					$conditionsTransfer['area']=array('$regex' => $area);
				}


				if(!empty($_GET['idCity'])){ //tỉnh/thành phố
					$idCity=trim($_GET['idCity']);
					$conditions['idCity']=array('$regex' => $idCity);
					$conditionsTransfer['idCity']=array('$regex' => $idCity);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
					$conditionsTransfer['idDistrict']=array('$regex' => $idDistrict);
				}

				if(!empty($_GET['idPlace'])){ //điểm đặt.
					$idPlace=trim($_GET['idPlace']);
					$conditions['idPlace']=array('$regex' => $idPlace);
					$conditionsMachine['idPlace']=array('$regex' => $idPlace);
					$conditionsTransfer['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['typedateEndPay'])){ //hình thức thanh toán.
					$typedateEndPay=trim($_GET['typedateEndPay']);
					$dkPay=array($typedateEndPay,(int)$typedateEndPay);
					$conditions['typedateEndPay']= array('$in'=>$dkPay);
					$conditionsTransfer['typedateEndPay']= array('$in'=>$dkPay);
				}
				if(!empty($_GET['status'])){ //trạng thái thanh toán
					$dkStatus=array($_GET['status'],(int)$_GET['status']);
					$conditions['status']=array('$in'=>$dkStatus);
					$conditionsTransfer['status']=array('$in'=>$dkStatus);
				}
				if(!empty($_GET['codeMachine'])){ //mã máy.
					$codeMachine=trim($_GET['codeMachine']);
					$conditions['codeMachine']= array('$regex' => $codeMachine);
					$conditionsMachine['code']=$_GET['codeMachine'];
				}

				$listData=$modelTransfer->find('list',array('conditions'=>$conditions,'fields'=>'codeMachine','order'=>$order)); //tìm các bản ghi ở bảng transfer theo điều kiện tìm kiếm được nhập với khóa=id bản ghi và giá trị = mã máy ->FIND(LIST).
				$dataTransfer=array_unique($listData); //lọc các mảng có value giống nhau, chỉ lấy mảng đầu tiên tìm được.
				$keydataTransfer=array_keys($dataTransfer); //lấy key từ mảng vừa lọc(=id thuộc bảng transfer).
				$valuedataTransfer=array_values($dataTransfer); //lấy value từ mảng vừa lọc(=mã máy thuộc bảng transfer).
		//tìm kiếm máy không có giao dịch.
									$listDataMachine=$modelMachine->find('list',array('fields'=>'code')); //tìm kiếm tất cả mã máy với lệnh FIND(LIST).
									$refineData=array_diff($listDataMachine,$dataTransfer); //Lọc các mã máy có tại bảng machine nhưng ko có tại bảng transfer.

									$keyrefineData=array_keys($refineData); //Lấy key từ mảng vừa lọc(=id thuộc bảng machine).
									$conditionsMachine['id']=array('$in'=>$keyrefineData);
									$listData2=$modelMachine->find('all',array('conditions'=>$conditionsMachine,'fields'=>array('code','codeStaff','idStaff','status','name')));
									$countRefine=count($listData2);//đếm số phần tử mảng vừa lọc(cho vòng lặp for).
									for($x=0;$x<$countRefine;$x++){
											$listData2[$x]['Machine']['timeServer']=''; //đặt 1 tham số thời gian cho mảng vừa tìm được thuộc bảng machine.
											$conditionsTransfer['codeMachine']=$listData2[$x]['Machine']['code'];
											$listDataTransfer=$modelTransfer->find('first',array('conditions'=>$conditionsTransfer,'fields'=>'timeServer','order'=>$order)); //tìm các bảng ghi thuộc bảng transfer với mã máy là các mã máy vừa tìm được ở bảng machine.
													if(!empty($listDataTransfer)){ //nếu mảng tìm ở bảng transfer ko trống thì bắt đầu gán giá trị thời gian. Nếu không, giá trị thời gian = rỗng.
													$listData2[$x]['Machine']['timeServer']=$listDataTransfer['Transfer']['timeServer'];
													}
													 $data1[]=array();
													 $data1[$x]=$listData2[$x]; //để lấy được dữ liệu ra màn hình, ta phải lặp 1 mảng liên tục. Những các mảng tìm được lại là mảng rời rạc, vì vập phải ép tất cả vào chung 1 mảng.
									}// đóng vòng lặp for.

								if(!empty($_GET['statusMachine'])){ //nếu ô trạng thái máy được lựa chọn.
									$dieukien=array($_GET['statusMachine'],(int)$_GET['statusMachine']);
									$conditionsMachine['status']=array('$in'=>$dieukien);
									$listDataMachine2=$modelMachine->find('list',array('conditions'=>$conditionsMachine,'fields'=>'code')); //tìm tại bảng machine các máy theo trạng thái máy được lựa chọn.
									$refine=array_intersect($listDataMachine2,$refineData); //tìm các bản ghi phù hợp đk kết hợp "không có giao dịch" + "trạng thái máy".
									$keyRefine=array_keys($refine); //lấy id bản ghi vừa lọc.
									$valueRefine=array_values($refine); // lấy mã máy vừa lọc.
									$count=count($refine); //đếm số phần tử thuộc mảng $refine vừa lọc.

									for($i=0;$i<$count;$i++){
									$listDataMachine3=$modelMachine->find('first',array('conditions'=>array('id'=>$keyRefine[$i]),'fields'=>array('code','name','idStaff','codeStaff','status'),'order'=>$order)); // Các bản ghi thuộc bảng machine vừa lọc được.
									$conditionsTransfer['codeMachine']=$valueRefine[$i];

									$listDataTransfer3=$modelTransfer->find('first',array('conditions'=>$conditionsTransfer,'fields'=>'timeServer','order'=>$order)); //tìm các bản ghi có mã máy là các mã máy vừa lọc được.
									$listDataMachine3['Machine']['timeServer']=''; //tạo thuộc tính thời gian giao dịch cho mảng thuộc bảng machine vừa lọc.

										if(!empty($listDataTransfer3)){ //nếu mã máy vừa lọc từ bảng machine có tồn tại ở bảng transfer thì lấy thời gian giao dịch ra, ko thì thời gian giao dịch = rỗng.
											$listDataMachine3['Machine']['timeServer']=$listDataTransfer3['Transfer']['timeServer'];
										}

										$a[]=array();
										$a[$i]=$listDataMachine3; //tạo mảng liên tục(như trên).
									}

									$data1=$a; //biến dùng để lặp.
								}//đóng if(!empty($_GET['statusMachine'])).

										if(!empty($data1)){ //bắt đầu lặp mảng liên tục và gán giá trị.
											foreach($data1 as $data){

																				}
																			}

				$totalData= $modelTransfer->find('count',array('conditions' => $conditions));
				$balance= $totalData%$limit;
				$totalPage= ($totalData-$balance)/$limit;
				if($balance>0)$totalPage+=1;

				$back=$page-1;$next=$page+1;
				if($back<=0) $back=1;
				if($next>=$totalPage) $next=$totalPage;

				if(isset($_GET['page'])){
					$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
					$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
				}else{
					$urlPage= $urlNow;
				}

				if(strpos($urlPage,'?')!== false){
					if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
						$urlPage= $urlPage.'&page=';
					}else{
						$urlPage= $urlPage.'page=';
					}
				}else{
					$urlPage= $urlPage.'?page=';
				}

		//xuất file excel.
				if(!empty($_POST['inport'])){
					//global $listStatusMachine;
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Mã máy'),'width' => 25, 'filter' => true, 'wrap' => true),
						array('label' => __('Tên máy'), 'width' => 25, 'filter' => true, 'wrap' => true),
						array('label' => __('Thời gian giao dịch cuối cùng'),'width' => 30, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã nhân viên'), 'width' => 15, 'filter' => true),
						array('label' => __('Trạng thái máy hiện tại'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($data1)){

						foreach ($data1 as $key => $value) {
							$stt= $key+1;
							$time=date('d/m/Y H:i:s',@$value['Machine']['timeServer']);
							$data[]= array( $stt,
								$value['Machine']['id'],
								$value['Machine']['name'],
								$time,
								$value['Machine']['codeStaff'],
								$listStatusMachine[$value['Machine']['status']]['name']
							);
						}

					}
					$exportsController = new ExportsController();
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Tra-cuu-may-khong-co-giao-dich')));


				}

				setVariable('data1',@$data1);
				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
				setVariable('mess',$mess);
			}
			setVariable('listPlace',$listPlace);
			setVariable('listStatusMachine',$listStatusMachine);
		}
	}
}


?>
