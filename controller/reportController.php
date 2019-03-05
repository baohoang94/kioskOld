<?php
// báo cáo theo nhà cung cấp
function listReportBySuppliers($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo bán hàng theo nhà cung cấp';
	$dataSend = $input['request']->data;
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace = new Place;
	$listIDPro=array();
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportBySuppliers', $_SESSION['infoStaff']['Staff']['permission']))){
			$conditionsPlace['lock']=(int)0;
			if(!empty($_GET)){
				$conditionsSuppliers=array();
				if($_GET['idSupplier']!=1){
					$conditionsSuppliers['id']=$_GET['idSupplier'];
				}

				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;

				$listData1= $modelSupplier->getPage($page, $limit , $conditionsSuppliers, $order=array(), $fields=array('name') );
				if(!empty($listData1)){
					foreach ($listData1 as $key => $value) {

						$listData[$key]['Supplier']['name']=$value['Supplier']['name'];
						$listData[$key][$key]['Supplier']['id']=$value['Supplier']['id'];
						$listData[$key]['Supplier']['listID']= $modelProduct->find('all', array('conditions'=>array('idSupplier'=>$value['Supplier']['id']),'fields'=>array('id')));
					}
					//pr($listData);
				}

				$totalData= $modelSupplier->find('count',array('conditions' => $conditionsSuppliers));
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

				$conditions=array();
				$conditions['status']=(int)1;
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportBySuppliers', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions['idMachine']= array('$in'=>$_SESSION['listIdMachine']);
				}
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$lte']= $time;
				}
				if(!empty($_GET['idCity'])){ // tỉnh/thành phố.
					$conditions['idCity']= array('$regex' => $_GET['idCity']);
					$conditionsPlace['idCity']=array('$regex' => $_GET['idCity']);
				}
				if(!empty($_GET['idChannel'])){
					$conditions['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
					$conditionsPlace['area']=array('$regex' => $area);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
					$conditionsPlace['idDistrict']=array('$regex' => $idDistrict);
				}
				if($_GET['idPlace']!=1){ //điểm đặt.
					$idPlace=trim($_GET['idPlace']);
					$conditions['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['wards'])){ //xã phường.
					$conditions['wards']=array('$regex' => $_GET['wards']);
					$conditionsPlace['wards']=array('$regex' => $_GET['wards']);
				}

				$tongSL=0;
				$tongTien=0;
				$soluong=0;
				$tong=0;
				$listTransfer=$modelTransfer->find('all',array('conditions'=>$conditions,'fields'=>array('moneyCalculate','quantity')));
			if(!empty($listTransfer)){
				foreach ($listTransfer as $value) {
					$soluong=$soluong+$value['Transfer']['quantity'];
					$tong=$tong+$value['Transfer']['moneyCalculate'];
				}
			}
				$tongSL=$tongSL+$soluong;
				$tongTien=$tongTien+$tong;
			// xuất file
				if(!empty($_POST['inport'])){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Tên nhà cung cấp'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Sản lượng bán(lẻ)'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Tỷ trọng SL bán(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Doanh thu'), 'width' => 15, 'filter' => true),
						array('label' => __('Tỷ trọng doanh thu(%)'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					$totalSales=0;
					$totalMoneyCalculation=0;
					if(!empty($listData)){
					foreach ($listData as $key => $value) {
						$soluong=0;
						$tong=0;
						$i++;
						$titrongsl=0;
						$titrongt=0;
						$listID=array();
						if(!empty($value['Supplier']['listID'])){
							foreach ($value['Supplier']['listID'] as $key1 => $cua) {
							$listID[$key1]=$cua['Product']['id'];

							}

							$conditions['idProduct']=array('$in'=>$listID);
							$giaodich= $modelTransfer->find('all', array('conditions'=>$conditions,'fields'=>array('idProduct','quantity','moneyCalculate','moneyInput')));

							foreach ($giaodich as $key2 => $cua1) {
							$soluong=$soluong+$cua1['Transfer']['quantity'];
							$tong=$tong+$cua1['Transfer']['moneyCalculate'];

							}
					if($tongSL==0){
						$titrongsl=0;
					}else{
						$titrongsl=($soluong/$tongSL)*100;
					}
					if($tongTien==0){
						$titrongt=0;
					}else{
						$titrongt=($tong/$tongTien)*100;
					}
						}else{
							$titrongsl=0;
							$titrongt=0;
						}
								$stt= $key+1;
								$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
								$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
								$data[]= array( $stt,
									$value['Supplier']['name'],
									$soluong,
									$so,
									$tong,
									$so1
								);
							}
					$cua=array('','Tổng cộng',$tongSL,'',$tongTien,'');
					array_push($data,$cua);
					}
					$exportsController = new ExportsController();
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-ban-hang-theo-nha-cung-cap')));
				}
				setVariable('listData',$listData);
				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
				setVariable('listTransfer',$listTransfer);
				setVariable('tongSL',$tongSL);
				setVariable('tongTien',$tongTien);
			}
			$listSupplier=$modelSupplier->find('all', array('conditions'=>array(),'fields'=>array('name')));
			setVariable('listSupplier',$listSupplier);
			$listPlace=$modelPlace->find('all', array('conditions'=>$conditionsPlace,'fields'=>array('name')));
			setVariable('listPlace',$listPlace);
			//pr($listPlace);
			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			setVariable('listChannelProduct',$listChannelProduct);

		}else{
			$modelProduct->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelProduct->redirect($urlHomes.'login?status=-2');
	}

}
	// báo cáo ncc theo  sản phẩm
function listReportBySuppliersOrderProduct($input ){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo Nhà cung cấp theo sản phẩm';

	$dataSend = $input['request']->data;
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace = new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportBySuppliersOrderProduct', $_SESSION['infoStaff']['Staff']['permission']))){
			if (!empty($_GET)) {
				# code...
				$conditions=array();
				$conditionsProduct=array();
				$conditionsProduct['lock']=(int)0;
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportBySuppliersOrderProduct', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['code'])){
					$code=trim($_GET['code']);
					$conditionsProduct['code']=array('$regex' => $code);
				}
				if(!empty($_GET['idSupplier'])){
					$idSupplier=trim($_GET['idSupplier']);
					$conditionsProduct['idSupplier']=array('$regex' => $idSupplier);
				}
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;
				//$order = array('created'=>'DESC');
				$listData= $modelProduct->getPage($page, $limit , $conditionsProduct, $order=array(), $fields=array('name','idSupplier','code') );

				$totalData= $modelProduct->find('count',array('conditions' => $conditionsProduct));
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
				$conditions['status']=(int)1;
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$lte']= $time;
				}
				if(!empty($_GET['idChannel'])){
					$conditions['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				if(!empty($_GET['idCity'])){ //tỉnh-thành phố.
					$conditions['idCity']= array('$regex' => $_GET['idCity']);
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['idPlace'])){ //điểm đặt.
					$idPlace=trim($_GET['idPlace']);
					$conditions['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['wards'])){ //xã phường.
					$conditions['wards']=array('$regex' => $_GET['wards']);
				}
				$listTransfer= $modelTransfer->find('all', array('conditions'=>$conditions,'fields'=>array('idProduct','quantity','moneyCalculate','moneyInput')));
				$listProduct=$modelProduct->find('all', array('conditions'=>$conditionsProduct,'fields'=>array('name','idSupplier','code')));
				// tính tổng
				$tongSL=0;
				$tongTien=0;

				if(!empty($listProduct)){
					foreach ($listProduct as $key => $value) {
						$soluong=0;
						$sotien=0;
						if($listTransfer){
							foreach ($listTransfer as $key1 => $cua) {
								if($value['Product']['id']==$cua['Transfer']['idProduct']){
									$soluong=$soluong+$cua['Transfer']['quantity'];
									$sotien=$sotien+$cua['Transfer']['moneyCalculate'];
								}
							}
						}
						$tongSL=$tongSL+$soluong;
						$tongTien=$tongTien+$sotien;

					}

				}

				// xửa lý dữ liệu xuất file xcel
				if(!empty($_POST['inport'])){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Mã sản phẩm'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tên sản phẩm'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tên nhà cung cấp'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Sản lượng bán(lẻ)'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Tỷ trọng SL bán(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Doanh thu'), 'width' => 15, 'filter' => true),
						array('label' => __('Tỷ trọng doanh thu(%)'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($listProduct)){
						foreach ($listProduct as $key => $value) {
							$soluong=0;
							$sotien=0;
							$titrongsl=0;
							$titrongt=0;
							$supplier[$key]=$modelSupplier->getSupplier($value['Product']['idSupplier'],array('name'));
							if($listTransfer){
								foreach ($listTransfer as $key1 => $cua) {
															# code...
									if($value['Product']['id']==$cua['Transfer']['idProduct']){
										$soluong=$soluong+$cua['Transfer']['quantity'];
										$sotien=$sotien+$cua['Transfer']['moneyCalculate'];

									}
								}
							}
							if($tongSL==0){
								$titrongsl=0;
							}else{
								$titrongsl=($soluong/$tongSL)*100;
							}
							if($tongTien==0){
								$titrongt=0;
							}else{
								$titrongt=($sotien/$tongTien)*100;
							}

							$stt= $key+1;
							$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
							$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
							$data[]= array( $stt,
								$value['Product']['code'],
								$value['Product']['name'],
								$supplier[$key]['Supplier']['name'],
								$soluong,
								$so,
								$sotien,
								$so1
							);

						}
						$cua=array('','','','Tổng cộng',$tongSL,'',$tongTien,'');
						array_push($data,$cua);
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-ban-hang-nha-cung-cap-theo-san-pham')));
				}
				setVariable('listData',$listData);
				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
				setVariable('listProduct',$listProduct);
				setVariable('listTransfer',$listTransfer);
				setVariable('tongSL',$tongSL);
				setVariable('tongTien',$tongTien);
			}

			$cityKiosk = $modelOption->getOption('cityKiosk');
			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			$listSupplier=$modelSupplier->find('all', array('conditions'=>array(),'fields'=>array('name')));
			setVariable('listSupplier',$listSupplier);
			setVariable('cityKiosk',$cityKiosk);
			setVariable('listChannelProduct',$listChannelProduct);
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
			setVariable('listPlace',$listPlace);
		}else{
			$modelProduct->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelProduct->redirect($urlHomes.'login?status=-2');
	}

}
//
function listReportTotalSalesByPlace(){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo bán hàng theo điểm đặt';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportTotalSalesByPlace', $_SESSION['infoStaff']['Staff']['permission']))){
			$listChannelProduct=$modelOption->getOption('listChannelProduct');
			setVariable('listChannelProduct',$listChannelProduct);
			if (!empty($_GET)) {
				# code...
				$conditionsPlace['lock']=(int)0;
				if(!empty($_GET['name'])){
					$name=trim($_GET['name']);
					$key= createSlugMantan($name);
					$conditionsPlace['slug.name']= array('$regex' => $key);
				}
				if(!empty($_GET['code'])){
					$code=createSlugMantan(trim($_GET['code']));
					$conditionsPlace['$or'][0]['slug.code']= array('$regex' => $code);
					$conditionsPlace['$or'][1]['code']= array('$regex' => $code);
				//$conditions['code']=array('$regex' =>$code);
				}
				if(!empty($_GET['idChannel'])){
					$conditionsPlace['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportTotalSalesByPlace', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;
				//$order = array('created'=>'DESC');
				$listData= $modelPlace->getPage($page, $limit , $conditionsPlace, $order=array(), $fields=array('name','code','idChannel') );

				$totalData= $modelPlace->find('count',array('conditions' => $conditionsPlace));
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
				$conditions['status']=(int)1;
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['timeServer']['$lte']= $time;
				}
				if(!empty($_GET['idCity'])){ // tỉnh/thành phố.
					$conditions['idCity']= array('$regex' => $_GET['idCity']);
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditions['area']=array('$regex' => $area);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditions['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['wards'])){ //xã phường.
					$conditions['wards']=array('$regex' => $_GET['wards']);
				}
				$fields=array('name','idMachine','code','idChannel');
				$listPlace=$modelPlace->find('all', array('conditions'=>$conditionsPlace,'fields'=>$fields));
				$listTransfer= $modelTransfer->find('all', array('conditions'=>$conditions,'fields'=>array('idMachine','quantity','moneyCalculate','moneyInput','idPlace')));
			// tính số lượng
				$tongSL=0;
				$tongTien=0;
				if(!empty($listPlace)){
					foreach ($listPlace as $key => $value) {
						$soluong=0;
						$tong=0;
						if(!empty($listTransfer)){
							foreach ($listTransfer as $key1 => $cua) {
								if(!empty($cua['Transfer']['idPlace'])&&$value['Place']['id']==$cua['Transfer']['idPlace']){
									$soluong=$soluong+$cua['Transfer']['quantity'];
									$tong=$tong+$cua['Transfer']['moneyCalculate'];
							}								# code...
						}
						$tongSL=$tongSL+$soluong;
						$tongTien=$tongTien+$tong;
					}
				}
			}
			// xử lý xuất file excel
			if(!empty($_POST['inport'])){
				$table = array(
					array('label' => __('STT'), 'width' => 5),
					array('label' => __('Mã điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Tên điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Kêhn bán hàng'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Sản lượng bán(lẻ)'), 'width' => 15, 'filter' => true, 'wrap' => true),
					array('label' => __('Tỷ trọng SL bán(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
					array('label' => __('Doanh thu'), 'width' => 15, 'filter' => true),
					array('label' => __('Tỷ trọng doanh thu (%)'), 'width' => 15, 'filter' => true),
				);
				$data= array();
				if(!empty($listPlace)){
					$totalSales=0;
					$totalMoneyCalculation=0;
					foreach ($listPlace as $key => $value) {
						$soluong=0;
						$tong=0;
						$tong1=0;
						$titrongsl=0;
						$titrongt=0;
						if(!empty($listTransfer)){
							foreach ($listTransfer as $key1 => $cua) {
								if(!empty($cua['Transfer']['idPlace'])&&$value['Place']['id']==$cua['Transfer']['idPlace']){
									$soluong=$soluong+$cua['Transfer']['quantity'];
									$tong=$tong+$cua['Transfer']['moneyCalculate'];

								}
															# code...
							}
							if($tongSL==0){
								$titrongsl=0;
							}else{
								$titrongsl=($soluong/$tongSL)*100;
							}
							if($tongTien==0){
								$titrongt=0;
							}else{
								$titrongt=($tong/$tongTien)*100;
							}
						}
						$stt= $key+1;
						$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
						$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
						$chan=$listChannelProduct['Option']['value']['allData'][$value['Place']['idChannel']]['name'];
						$data[]= array( $stt,
							$value['Place']['code'],
							$value['Place']['name'],
							$chan,
							$soluong,
							$so,
							$tong,
							$so1
						);

					}
					$cua=array('','','','Tổng cộng',$tongSL,'',$tongTien,'');
					array_push($data,$cua);

				}
				$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
				$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-ban-hang-theo-diem-dat')));
			}
			setVariable('listData',$listData);
			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
			setVariable('listPlace',$listPlace);
			setVariable('listTransfer',$listTransfer);
			setVariable('tongTien',$tongTien);
			setVariable('tongSL',$tongSL);
		}

		$listChannelProduct= $modelOption->getOption('listChannelProduct');
		setVariable('listChannelProduct',$listChannelProduct);

	}else{
		$modelProduct->redirect($urlHomes.'dashboard');
	}
}else{
	$modelProduct->redirect($urlHomes.'login?status=-2');
}
}
//báo cáo doanh thu địa điểm theo sản phẩm
function listRevenueByPlaceOrderProduct($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo bán hàng theo điểm đặt theo sản phẩm';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByPlaceOrderProduct', $_SESSION['infoStaff']['Staff']['permission']))){
			$id=$input['request']->params['pass']['1'];
			if($id){
				$place=$modelPlace->getPlace($id,array('name'));
				if (!empty($_GET)) {
					# code...
					if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByPlaceOrderProduct', $_SESSION['infoStaff']['Staff']['permission'])) {
						$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
					}
					$conditionsProduct['lock']=(int)0;
					if(!empty($_GET['name'])){
						$key= createSlugMantan($_GET['name']);
						$conditionsProduct['slugKeys']= array('$regex' => $key);
					}
					if(!empty($_GET['code'])){
						$code=trim($_GET['code']);
						$conditionsProduct['code']= array('$regex' => $code);
					}
					if(!empty($_GET['idSupplier'])){
						$idSupplier=trim($_GET['idSupplier']);
						$conditionsProduct['idSupplier']= array('$regex' => $idSupplier);
					}
					$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
					if($page<1) $page=1;
					$limit= 15;
					$listData= $modelProduct->getPage($page, $limit , $conditionsProduct, $order=array(), $fields=array('name','code') );
					$totalData= $modelProduct->find('count',array('conditions' => $conditionsProduct));
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
					$listProduct=$modelProduct->find('all', array('conditions'=>$conditionsProduct,'fields'=>array('code','name')));
					$conditions['idPlace']=$id;
					$conditions['status']=(int)1;
					if(!empty($_GET['dayTo'])){
						$date= explode('/', $_GET['dayTo']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditions['timeServer']['$gte']= $time;
					}
					if(!empty($_GET['dayForm'])){
						$date= explode('/', $_GET['dayForm']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditions['timeServer']['$lte']= $time;
					}
					$listTransfer= $modelTransfer->find('all', array('conditions'=>$conditions,'fields'=>array('idProduct','quantity','moneyCalculate','moneyInput','idPlace')));
				// tính tổng
					$tongSL=0;
					$tongTien=0;
					if(!empty($listProduct)){
						foreach ($listProduct as $key => $value) {
							$soluong=0;
							$tong=0;
							if($listTransfer){
								foreach ($listTransfer as $key1 => $cua) {
									if($value['Product']['id']==$cua['Transfer']['idProduct']){
										$soluong=$soluong+$cua['Transfer']['quantity'];
										$tong=$tong+$cua['Transfer']['moneyCalculate'];
									}
								}
								$tongSL=$tongSL+$soluong;
								$tongTien=$tongTien+$tong;
							}
						}
					}
				//xử lý excel
					if(!empty($_POST['inport'])){
						$table = array(
							array('label' => __('STT'), 'width' => 5),
							array('label' => __('Mã sản phẩm'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Tên sản phẩm'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Sản lượng bán(lẻ)'), 'width' => 15, 'filter' => true, 'wrap' => true),
							array('label' => __('Tỷ trọng SL bán(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
							array('label' => __('Doanh thu'), 'width' => 15, 'filter' => true),
							array('label' => __('Tỷ trọng doanh thu(%)'), 'width' => 15, 'filter' => true),
						);
						$data= array();
						if(!empty($listProduct)){
							foreach ($listProduct as $key => $value) {
								$soluong=0;
								$tong=0;
								$titrongsl=0;
								$titrongt=0;
								if(!empty($listTransfer)){
									foreach ($listTransfer as $key1 => $cua) {
										if($value['Product']['id']==$cua['Transfer']['idProduct']){
											$soluong=$soluong+$cua['Transfer']['quantity'];
											$tong=$tong+$cua['Transfer']['moneyCalculate'];
										}
									}
									if($tongSL==0){
										$titrongsl=0;
									}else{
										$titrongsl=($soluong/$tongSL)*100;
									}
									if($tongTien==0){
										$titrongt=0;
									}else{
										$titrongt=($tong/$tongTien)*100;
									}

								}
								$stt= $key+1;
								$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
								$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
								$data[]= array( $stt,
									$value['Product']['code'],
									$value['Product']['name'],
									$soluong,
									$so,
									$tong,
									$so1
								);

							}
							$cua=array('','','Tổng cộng',$tongSL,'',$tongTien,'');
							array_push($data,$cua);

						}
						$exportsController = new ExportsController();
					//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
						$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-ban-hang-diem-dat-theo-san-pham')));
					}
					setVariable('listData',$listData);
					setVariable('listTransfer',$listTransfer);
					setVariable('page',$page);
					setVariable('totalPage',$totalPage);
					setVariable('back',$back);
					setVariable('next',$next);
					setVariable('urlPage',$urlPage);
					setVariable('tongSL',$tongSL);
					setVariable('tongTien',$tongTien);
				}

				$listSupplier=$modelSupplier->find('all', array('conditions'=>array(),'fields'=>array('name')));
				setVariable('listSupplier',$listSupplier);
				setVariable('place',$place);

			}

		}else{
			$modelProduct->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelProduct->redirect($urlHomes.'login?status=-2');
	}

}
// báo cáo doanh thu địa điểm theo máy
function listRevenueByPlaceOrderMachine($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo bán hàng điểm đặt theo máy';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByPlaceOrderMachine', $_SESSION['infoStaff']['Staff']['permission']))){
			$id=$input['request']->params['pass']['1'];
			if($id){
				$place=$modelPlace->getPlace($id,array('name'));
				if (!empty($_GET)) {
					# code...
					if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByPlaceOrderMachine', $_SESSION['infoStaff']['Staff']['permission'])) {
						$conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
					}
					$conditionsMachine['lock']=(int)0;
					$conditionsMachine['idPlace']=$id;
					if(!empty($_GET['name'])){
						$key= createSlugMantan($_GET['name']);
						$conditionsMachine['slug.name']= array('$regex' => $key);
					}
					if(!empty($_GET['code'])){
						$key= createSlugMantan($_GET['code']);
						$conditionsMachine['slug.code']= array('$regex' => $key);
					}
					$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
					if($page<1) $page=1;
					$limit= 15;
				//$order = array('created'=>'DESC');
					$listData= $modelMachine->getPage($page, $limit , $conditionsMachine, $order=array(), $fields=array('name','code') );

					$totalData= $modelMachine->find('count',array('conditions' => $conditionsMachine));
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
					$conditions['idPlace']=$id;
					$conditions['status']=(int)1;
					if(!empty($_GET['dayTo'])){
						$date= explode('/', $_GET['dayTo']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditions['timeServer']['$gte']= $time;
					}
					if(!empty($_GET['dayForm'])){
						$date= explode('/', $_GET['dayForm']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditions['timeServer']['$lte']= $time;
					}

					if(!empty($_GET['idProduct'])){
						$conditions['idProduct']= array('$regex' => $_GET['idProduct']);
					}
					$listTransfer= $modelTransfer->find('all', array('conditions'=>$conditions,'fields'=>array('idMachine','quantity','moneyCalculate','moneyInput','idPlace')));
					$allMachine=$modelMachine->find('all', array('conditions'=>$conditionsMachine,'fields'=>array('code','name')));
				// tính tổng
					$tongSL=0;
					$tongTien=0;
					if(!empty($allMachine)){
						foreach ($allMachine as $key => $value) {
							$soluong=0;
							$tong=0;
							if($listTransfer){
								foreach ($listTransfer as $key1 => $cua) {
												# code...
									if($cua['Transfer']['idMachine']==$value['Machine']['id']){
										$soluong=$soluong+$cua['Transfer']['quantity'];
										$tong=$tong+$cua['Transfer']['moneyCalculate'];
									}
								}
								$tongSL=$tongSL+$soluong;
								$tongTien=$tongTien+$tong;
							}
						}
					}
				// xử lý excel
					if(!empty($_POST['inport'])){
						$table = array(
							array('label' => __('STT'), 'width' => 5),
							array('label' => __('Mã máy'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Tên máy'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Sản lượng bán(lẻ)'), 'width' => 15, 'filter' => true, 'wrap' => true),
							array('label' => __('Tỷ trọng SL bán(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
							array('label' => __('Doanh thu'), 'width' => 15, 'filter' => true),
							array('label' => __('Tỷ trọng doanh thu(%)'), 'width' => 15, 'filter' => true),
						);
						$data= array();
						if(!empty($allMachine)){
							$totalSales=0;
							$totalMoneyCalculation=0;
							foreach ($allMachine as $key => $value) {
								$soluong=0;
								$tong=0;
								$titrongsl=0;
								$titrongt=0;
								if($listTransfer){
									foreach ($listTransfer as $key1 => $cua) {
												# code...
										if($cua['Transfer']['idMachine']==$value['Machine']['id']){
											$soluong=$soluong+$cua['Transfer']['quantity'];
											$tong=$tong+$cua['Transfer']['moneyCalculate'];
										}
									}
									if($tongSL==0){
										$titrongsl=0;
									}else{
										$titrongsl=($soluong/$tongSL)*100;
									}
									if($tongTien==0){
										$titrongt=0;
									}else{
										$titrongt=($tong/$tongTien)*100;
									}
									$totalSales=$totalSales+$soluong;
									$totalMoneyCalculation=$totalMoneyCalculation+$tong;
								}
								$stt= $key+1;
								$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
								$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
								$data[]= array( $stt,
									$value['Machine']['code'],
									$value['Machine']['name'],
									$soluong,
									$so,
									$tong,
									$so1
								);

							}
							$cua=array('','','Tổng cộng',$tongSL,'',$tongTien,'');
							array_push($data,$cua);
						}

						$exportsController = new ExportsController();
					//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
						$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-ban-hang-diem-dat-theo-may')));
					}
					setVariable('id',$id);
					setVariable('listTransfer',$listTransfer);
					setVariable('listData',$listData);
					setVariable('page',$page);
					setVariable('totalPage',$totalPage);
					setVariable('back',$back);
					setVariable('next',$next);
					setVariable('urlPage',$urlPage);
					setVariable('tongSL',$tongSL);
					setVariable('tongTien',$tongTien);
				}

				$listProduct=$modelProduct->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
				setVariable('listProduct',$listProduct);
				setVariable('place',$place);

			}

		}else{
			$modelProduct->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelProduct->redirect($urlHomes.'login?status=-2');
	}
}
// xem chi tiết lịch sử doanh thu máy: tên máy
function viewDetailHistoryMachineRevenue($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Xem chi tiết lịch sử doanh thu máy';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewDetailHistoryMachineRevenue', $_SESSION['infoStaff']['Staff']['permission']))){
			$id=$input['request']->params['pass']['1'];
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
			setVariable('listPlace',$listPlace);
			if($id){
				$machine= $modelMachine->getMachine($id,$fields=array('name') );
				setVariable('machine',$machine);
				if(isset($_GET['codeProduct'])){
					$conditionsTransfer['status']=(int)1;
					$conditionsTransfer['idMachine']=$id;
					if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewDetailHistoryMachineRevenue', $_SESSION['infoStaff']['Staff']['permission'])) {
						$conditionsTransfer= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
					}
					$oder=array('timeServer'=>'DESC');
					if(!empty($_GET['dayTo'])){
						$date= explode('/', $_GET['dayTo']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$gte']= $time;
					}
					if(!empty($_GET['dayForm'])){
						$date= explode('/', $_GET['dayForm']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$lte']= $time;
					}
					if(!empty($_GET['codeMachine'])){
						$codeMachine= trim($_GET['codeMachine']);
						$conditionsTransfer['codeMachine']= array('$regex' => $codeMachine);
					}
					if(!empty($_GET['codeProduct'])){
						$codeProduct= trim($_GET['codeProduct']);
						$conditionsTransfer['codeProduct']= array('$regex' => $codeProduct);
					}
					if(!empty($_GET['idPlace'])){
						$idPlace= trim($_GET['idPlace']);
						$conditionsTransfer['idPlace']= array('$regex' => $idPlace);
					}
					$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
					if($page<1) $page=1;
					$limit= 15;
				//$order = array('created'=>'DESC');
					$listData= $modelTransfer->getPage($page, $limit , $conditionsTransfer,$oder, $fields=array('name','quantity','moneyCalculate','codeMachine','codeProduct','timeServer','codeMachine','idPlace') );

					$totalData= $modelTransfer->find('count',array('conditions' => $conditionsTransfer));
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
					$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditionsTransfer,'order'=>$oder,'fields'=>array('idMachine','quantity','moneyCalculate','moneyInput','idPlace','codeMachine','codeProduct','timeServer','idPlace')));
				// tính tổng
					$tongSL=0;
					$tongTien=0;
					if($listTransfer){
						$soluong=0;
						$tong=0;
						foreach ($listTransfer as $key => $value) {
						# code...
							$tongSL=$tongSL+$value['Transfer']['quantity'];
							$tongTien=$tongTien+$value['Transfer']['moneyCalculate'];

						}
					}
				// xử lý excel
					if(!empty($_POST['inport'])){
						$table = array(
							array('label' => __('STT'), 'width' => 5),
							array('label' => __('Thời gian'), 'width' => 17),
							array('label' => __('Mã sản phẩm'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Mã điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Tên điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Sản lượng bán(lẻ)'), 'width' => 15, 'filter' => true, 'wrap' => true),
							array('label' => __('Tỷ trọng SL bán(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
							array('label' => __('Doanh thu'), 'width' => 15, 'filter' => true),
							array('label' => __('tỷ trọng doanh thu(%)'), 'width' => 15, 'filter' => true),
						);
						$data= array();
						if(!empty($listTransfer)){
							foreach ($listTransfer as $key => $value) {
								$i++;
								$titrongsl=0;
								$titrongt=0;
								$tong=$value['Transfer']['moneyCalculate'];
								if($tongSL==0){
									$titrongsl=0;
								}else{
									$titrongsl=($value['Transfer']['quantity']/$tongSL)*100;
								}
								if($tongTien==0){
									$titrongt=0;
								}else{
									$titrongt=($tong/$tongTien)*100;
								}
								$place=$modelPlace->getPlace($value['Transfer']['idPlace'],array('name','code') );
								$stt= $key+1;
								$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
								$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
								$time=date('d/m/Y H:i:s',$value['Transfer']['timeServer']);
								$data[]= array( $stt,
									$time,
									$value['Transfer']['codeProduct'],
									$place['Place']['code'],
									$place['Place']['name'],
									$value['Transfer']['quantity'],
									$so,
									$tong,
									$so1
								);


							}
							$cua=array('','','','','Tổng cộng',$tongSL,'',$tongTien,'');
							array_push($data,$cua);
						}


						$exportsController = new ExportsController();
					//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
						$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Xem-chi-tiet-lich-su-giao-dich-theo-may')));
					}

					setVariable('tongSL',$tongSL);
					setVariable('tongTien',$tongTien);
					setVariable('listTransfer',$listTransfer);
					setVariable('listData',$listData);
					setVariable('page',$page);
					setVariable('totalPage',$totalPage);
					setVariable('back',$back);
					setVariable('next',$next);
					setVariable('urlPage',$urlPage);
				}


			}
		}else{
			$modelProduct->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelProduct->redirect($urlHomes.'login?status=-2');
	}
}

// báo cáo doanh thu địa diderm theo thời gian
function listRevenueByPlaceOrderTime($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo  bán hàng điểm đặt theo thời gian';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByPlaceOrderTime', $_SESSION['infoStaff']['Staff']['permission']))){
			$id=$input['request']->params['pass']['1'];
			if($id){
				$place=$modelPlace->getPlace($id,array('name'));
				if (!empty($_GET)) {
					# code...
					$conditionsTransfer['status']=(int)1;
					$conditionsTransfer['idPlace']=$id;
					if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByPlaceOrderTime', $_SESSION['infoStaff']['Staff']['permission'])) {
						$conditionsTransfer['idMachine']= array('$in'=>$_SESSION['listIdMachine']);
					}
					$oder=array('timeServer'=>'DESC');
					if(!empty($_GET['dayTo'])){
						$date= explode('/', $_GET['dayTo']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$gte']= $time;
					}
					if(!empty($_GET['dayForm'])){
						$date= explode('/', $_GET['dayForm']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$lte']= $time;
					}
					if(!empty($_GET['codeMachine'])){
						$codeMachine= trim($_GET['codeMachine']);
						$conditionsTransfer['codeMachine']= array('$regex' => $codeMachine);
					}
					if(!empty($_GET['codeProduct'])){
						$codeProduct= trim($_GET['codeProduct']);
						$conditionsTransfer['codeProduct']= array('$regex' => $codeProduct);
					}
					$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
					if($page<1) $page=1;
					$limit= 15;
				//$order = array('created'=>'DESC');
					$listData= $modelTransfer->getPage($page, $limit , $conditionsTransfer,$oder, $fields=array('name','quantity','moneyCalculate','codeMachine','codeProduct','timeServer','codeMachine','codeStaff') );

					$totalData= $modelTransfer->find('count',array('conditions' => $conditionsTransfer));
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
					$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditionsTransfer,'order'=>$oder,'fields'=>array('idMachine','quantity','moneyCalculate','moneyInput','idPlace','codeMachine','codeProduct','timeServer')));
				// tính tổng
					$tongSL=0;
					$tongTien=0;
					if($listTransfer){
						$soluong=0;
						$tong=0;
						foreach ($listTransfer as $key => $value) {
						# code...
							$tongSL=$tongSL+$value['Transfer']['quantity'];
							$tongTien=$tongTien+$value['Transfer']['moneyCalculate'];

						}
					}
				// xử lý excel
					if(!empty($_POST['inport'])){
						$table = array(
							array('label' => __('STT'), 'width' => 5),
							array('label' => __('Thời gian'), 'width' => 17),
							array('label' => __('Mã máy'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Mã sản phẩm'),'width' => 17, 'filter' => true, 'wrap' => true),
							array('label' => __('Sản lượng bán(lẻ)'), 'width' => 15, 'filter' => true, 'wrap' => true),
							array('label' => __('Tỷ trọng SL bán(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
							array('label' => __('Doanh thu'), 'width' => 15, 'filter' => true),
							array('label' => __('tỷ trọng doanh thu(%)'), 'width' => 15, 'filter' => true),
						);
						$data= array();
						if(!empty($listTransfer)){
							foreach ($listTransfer as $key => $value) {
								$titrongsl=0;
								$titrongt=0;
								$tong=$value['Transfer']['moneyCalculate'];
								if($tongSL==0){
									$titrongsl=0;
								}else{
									$titrongsl=($value['Transfer']['quantity']/$tongSL)*100;
								}
								if($tongTien==0){
									$titrongt=0;
								}else{
									$titrongt=($tong/$tongTien)*100;
								}
								$stt= $key+1;
								$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
								$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
								$time=date('d/m/Y H:i:s',$value['Transfer']['timeServer']);
								$data[]= array( $stt,
									$time,
									$value['Transfer']['codeMachine'],
									$value['Transfer']['codeProduct'],
									$value['Transfer']['quantity'],
									$so,
									$tong,
									$so1
								);


							}
							$cua=array('','','','Tổng cộng',$tongSL,'',$tongTien,'');
							array_push($data,$cua);
						}


						$exportsController = new ExportsController();
					//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
						$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-ban-hang-diem-dat-theo-thoi-gian')));
					}

					setVariable('tongSL',$tongSL);
					setVariable('tongTien',$tongTien);
					setVariable('listTransfer',$listTransfer);
					setVariable('listData',$listData);
					setVariable('page',$page);
					setVariable('totalPage',$totalPage);
					setVariable('back',$back);
					setVariable('next',$next);
					setVariable('urlPage',$urlPage);
				}
				setVariable('place',$place);
			}
		}else{
			$modelProduct->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelProduct->redirect($urlHomes.'login?status=-2');
	}
}

// thống kê  máy theo tỉnh
function listReportMachineByProvince(){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo phân bổ máy theo tỉnh';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportMachineByProvince', $_SESSION['infoStaff']['Staff']['permission']))){
			$cityKiosk = $modelOption->getOption('cityKiosk');
			if (!empty($_GET)) {
				# code...
				$listCity=array();
				if(!empty($cityKiosk['Option']['value']['allData'])){
					if(empty($_GET['idCity'])){
						$listCity=$cityKiosk['Option']['value']['allData'];
					}else{
						$listCity[0]=$cityKiosk['Option']['value']['allData'][$_GET['idCity']];
					}
				}
				$conditions['lock']=(int)0;
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportMachineByProvince', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions['id']=array('$in'=>$_SESSION['listIdMachine']);
					// pr($_SESSION['listIdMachine']);
				}
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['dateStartRunInt']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['dateStartRunInt']['$lte']= $time;
				}
				$listMachine=$modelMachine->find('all', array('conditions'=>$conditions,'fields'=>array('idPlace')));
			// tính tổng máy
				$tongmay=0;
				if(!empty($listCity)){
					foreach ($listCity as $key => $value) {
						$soluong=0;
						if(!empty($listMachine)){
							foreach ($listMachine as $key1 => $cua) {
								$place=$modelPlace->getPlace($cua['Machine']['idPlace'],$fields=array('idCity') );
								if(!empty($place)&&$place['Place']['idCity']==$value['id']){
									$soluong=$soluong+1;
								}
							}
						}
						$tongmay=$tongmay+$soluong;
					}

				}
			// xử lý excel
				if(!empty($_POST['inport'])){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Tỉnh/Thành phố'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Số lượng máy'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Tỷ trọng(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
					);

					$data= array();
					if(!empty($listCity)){
						foreach ($listCity as $key => $value) {
							$soluong=0;
							$tytrong=0;
							if(!empty($listMachine)){
								foreach ($listMachine as $key1 => $cua) {
														# code...
									$place=$modelPlace->getPlace($cua['Machine']['idPlace'],$fields=array('idCity') );
									if($place['Place']['idCity']==$value['id']){
										$soluong=$soluong+1;
									}
								}
							}
							if($tongmay!=0){
								$tytrong=($soluong/$tongmay)*100;
							}
							$stt= $key+1;
							$so=round($tytrong,2, PHP_ROUND_HALF_UP);
							$data[$key]= array( $stt,
								$value['name'],
								$soluong,
								$so
							);
						}
						$cua=array('','Tổng cộng',$tongmay,'');
						array_push($data,$cua);
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-phan-bo-may-theo-tinh')));

				}
				setVariable('listCity',$listCity);
				setVariable('tongmay',$tongmay);
				setVariable('listMachine',$listMachine);
			}

			setVariable('cityKiosk',$cityKiosk);
		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}

}
// báo cáo thống kê máy theo điểm đặt
function listReportMachineByPlace(){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo phân bổ máy theo điểm đặt';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportMachineByPlace', $_SESSION['infoStaff']['Staff']['permission']))){
			$listChannelProduct=$modelOption->getOption('listChannelProduct');
			setVariable('listChannelProduct',$listChannelProduct);
			if (!empty($_GET)) {
				# code...
				$conditionsPlace['lock']=(int)0;
				if(!empty($_GET['name'])){
					$key= createSlugMantan($_GET['name']);
					$conditionsPlace['slug.name']= array('$regex' => $key);
				}
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listReportMachineByPlace', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditions['id']= array('$in'=>$_SESSION['listIdMachine']);
				}
				if(!empty($_GET['code'])){
					$code=createSlugMantan(trim($_GET['code']));
					$conditionsPlace['$or'][0]['slug.code']= array('$regex' => $code);
					$conditionsPlace['$or'][1]['code']= array('$regex' => $code);
				//$conditions['code']=array('$regex' =>$code);
				}
				if(!empty($_GET['idChannel'])){
					$conditionsPlace['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;
				//$order = array('created'=>'DESC');
				$listData= $modelPlace->getPage($page, $limit , $conditionsPlace, $order=array(), $fields=array('name','code','idChannel') );

				$totalData= $modelPlace->find('count',array('conditions' => $conditionsPlace));
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
				$conditions['lock']=(int)0;
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['dateStartRunInt']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditions['dateStartRunInt']['$lte']= $time;
				}
				$listMachine=$modelMachine->find('all', array('conditions'=>$conditions,'fields'=>array('idPlace')));
				$listPlace=$modelPlace->find('all', array('conditions'=>$conditionsPlace,'fields'=>array('idPlace','code','name','idChannel')));
			// tính tổng
				$tongmay=0;
				if(!empty($listPlace)){
					foreach ($listPlace as $key => $value) {
						$somay=0;
						if($listMachine){
							foreach ($listMachine as $key1 => $cua) {
							# code...
								if($cua['Machine']['idPlace']==$value['Place']['id']){
									$somay=$somay+1;
								}
							}
						}
						$tongmay=$tongmay+$somay;
					}
				}
			//$tongmay= $modelMachine->find('count',array('conditions' =>$conditions));
			// xử lý excel
				if(!empty($_POST['inport'])){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Mã điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tên điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Kênh bán hàng'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Số lượng máy'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Tỷ trọng(%)'),'width' => 20, 'filter' => true, 'wrap' => true),
					);

					$data= array();
					if(!empty($listPlace)){
						foreach ($listPlace as $key => $value) {
							$somay=0;
							if($listMachine){
								foreach ($listMachine as $key1 => $cua) {
							# code...
									if($cua['Machine']['idPlace']==$value['Place']['id']){
										$somay=$somay+1;
									}
								}
							}
							if($tongmay==0){
								$titrong=0;
							}else{
								$titrong=($somay/$tongmay)*100;
							}
							$stt= $key+1;
							$so=round($titrong,2, PHP_ROUND_HALF_UP);
							$chan=$listChannelProduct['Option']['value']['allData'][$value['Place']['idChannel']]['name'];
							$data[$key]= array( $stt,
								$value['Place']['code'],
								$value['Place']['name'],
								$chan,
								$somay,
								$so
							);
						}
						$cua=array('','','','Tổng cộng',$tongmay,'');
						array_push($data,$cua);
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-phan-bo-may-theo-diem-dat')));
				}
				setVariable('listMachine',$listMachine);
				setVariable('tongmay',$tongmay);
				setVariable('listData',$listData);
				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
			}

		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
//// Tổng hợp doanh thu theo điểm bán hàng này
function lisstReportRevenueByPlaceOnDay(){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Tổng hợp doanh thu theo điểm bán hàng ngày';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelPlace= new Place;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('lisstReportRevenueByPlaceOnDay', $_SESSION['infoStaff']['Staff']['permission']))){
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name','code')));
			setVariable('listPlace',$listPlace);
			if (!empty($_GET)) {
				# code...
				$listChannelProduct= $modelOption->getOption('listChannelProduct');
				if(!empty($listChannelProduct['Option']['value']['allData'])){
					$listChannel=$listChannelProduct['Option']['value']['allData'];
					setVariable('listChannel',$listChannel);
				}
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('lisstReportRevenueByPlaceOnDay', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditionsMachine['id']= array('$in'=>$_SESSION['listIdMachine']);
				}

				if(!empty($_GET['idPlace'])){
					$conditionsMachine['idPlace']=$_GET['idPlace'];
				}
				if(!empty($_GET['codeMachine'])){
					$key= createSlugMantan(trim($_GET['codeMachine']));
					$conditionsMachine['slug.code']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.code'=>array('$regex' => $key));
				}
				$conditionsMachine['lock']=(int)0;
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;
				//$order = array('created'=>'DESC');
				$listData= $modelMachine->getPage($page, $limit , $conditionsMachine, $order=array(), $fields=array('name','code','idPlace','codeStaff') );

				$totalData= $modelMachine->find('count',array('conditions' => $conditionsMachine));
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
				$conditionsTransfer['status']=(int)1;
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$lte']= $time;
				}
				if(!empty($_GET['idCity'])){ // tỉnh/thành phố.
					$conditionsTransfer['idCity']= array('$regex' => $_GET['idCity']);
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditionsTransfer['area']=array('$regex' => $area);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditionsTransfer['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['wards'])){ //xã phường.
					$conditionsTransfer['wards']=array('$regex' => $_GET['wards']);
				}
				$listMachine=$modelMachine->find('all', array('conditions'=>$conditionsMachine,$order=array(),'fields'=>array('idPlace','code','codeStaff')));
				$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditionsTransfer,'fields'=>array('idMachine','quantity','moneyCalculate','typedateEndPay','idChannel')));
			// tính tổng
				$tongSL=0;
				$tongTien=0;
				$tongThe=0;
				$All=0;
				if(!empty($listMachine)){
					foreach ($listMachine as $key => $value) {
						$soluong=0;
						$tongtien=0;
						$the=0;
						$tien=0;
						if(!empty($listTransfer)){
							foreach ($listTransfer as $key1 => $cua) {
								if($cua['Transfer']['idMachine']==$value['Machine']['id']){
									$soluong=$soluong+$cua['Transfer']['quantity'];
									$tongtien=$tongtien+$cua['Transfer']['moneyCalculate'];
									if($cua['Transfer']['typedateEndPay']==1){
										$tien=$tien+$cua['Transfer']['moneyCalculate'];
									}
									if(($cua['Transfer']['typedateEndPay']==2)||($cua['Transfer']['typedateEndPay']==4)){
										$the=$the+$cua['Transfer']['moneyCalculate'];
									}
								}
							}
							$tongSL=$tongSL+$soluong;
							$tongTien=$tongTien+$tien;
							$tongThe=$tongThe+$the;
							$All=$All+$tongtien;
						}

					}
				}
			//xử lý excel
				if(!empty($_POST['inport'])){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Mã máy'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tên điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Kênh bán hàng'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Số lượng'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Doanh thu tiền mặt'), 'width' => 15, 'filter' => true),
						array('label' => __('Doanh thu tiền thẻ'), 'width' => 15, 'filter' => true),
						array('label' => __('Tổng'), 'width' => 15, 'filter' => true),
						array('label' => __('Mã nhân viên'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($listMachine)){
						foreach ($listMachine as $key => $value) {
							$i++;
							$soluong=0;
							$tongtien=0;
							$the=0;
							$tien=0;
							if(!empty( $value['Machine']['idPlace'])){
								$place[$key]=$modelPlace->getPlace( $value['Machine']['idPlace'],$fields=array('code','name','idChannel') );
												# code...
								if(!empty($place[$key])){
									@$channel=$listChannel[$place[$key]['Place']['idChannel']]['name'];
									@$name=$place[$key]['Place']['name'];
									@$code=$place[$key]['Place']['code'];
								}else{
									$channel='';
									$name='';
									$code='';
								}
							}else{
								$channel='';
								$name='';
								$code='';
							}
							if(!empty($listTransfer)){
								foreach ($listTransfer as $key1 => $cua) {
									if($cua['Transfer']['idMachine']==$value['Machine']['id']){
										$soluong=$soluong+$cua['Transfer']['quantity'];
										$tongtien=$tongtien+$cua['Transfer']['moneyCalculate'];
										if($cua['Transfer']['typedateEndPay']==1){
											$tien=$tien+$cua['Transfer']['moneyCalculate'];
										}
										if(($cua['Transfer']['typedateEndPay']==2)||($cua['Transfer']['typedateEndPay']==4)){
											$the=$the+$cua['Transfer']['moneyCalculate'];
										}
									}
								}
							}
							$stt= $key+1;
							$so=round($titrongsl,2, PHP_ROUND_HALF_UP);
							$so1=round($titrongt,2, PHP_ROUND_HALF_UP);
							$data[]= array( $stt,
								$value['Machine']['code'],
								$code,
								$name,
								$channel,
								$soluong,
								$tien,
								$the,
								$tongtien,
								$value['Machine']['codeStaff']
							);
						}
						$cua=array('','','','','Tổng cộng',$tongSL,$tongTien,$tongThe,$All,'');
						array_push($data,$cua);
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Tong-hop-doanh-thu-theo-diem-ban-hang-ngay')));

				}
				setVariable('All',$All);
				setVariable('tongSL',$tongSL);
				setVariable('tongTien',$tongTien);
				setVariable('tongThe',$tongThe);
				setVariable('listTransfer',$listTransfer);
				setVariable('listData',$listData);
				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
			}

		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
	// tổng hợp doanh thu tiền mặt
function listRevenueByCash(){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Tổng hợp doanh thu tiền mặt';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelPlace= new Place;
	$modelStaff= new Staff;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByCash', $_SESSION['infoStaff']['Staff']['permission']))){
			$listChannelProduct=$modelOption->getOption('listChannelProduct');
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name','code')));
			if (!empty($_GET)) {
				# code...
				if(!empty($listChannelProduct['Option']['value']['allData'])){
					$listChannel=$listChannelProduct['Option']['value']['allData'];
					setVariable('listChannel',$listChannel);
				}

				$conditionsTransfer['status']=(int)1;

				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByCash', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditionsTransfer= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['idChannel'])){
					$conditionsTransfer['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				if(!empty($_GET['idPlace'])){
					$conditionsTransfer['idPlace']=$_GET['idPlace'];
				}
				if(!empty($_GET['codeMachine'])){
					$code=trim($_GET['codeMachine']);
					$conditionsTransfer['codeMachine']=array('$regex' => $code);
				}
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$lte']= $time;
				}
				if(!empty($_GET['idCity'])){ // tỉnh/thành phố.
					$conditionsTransfer['idCity']= array('$regex' => $_GET['idCity']);
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditionsTransfer['area']=array('$regex' => $area);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditionsTransfer['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['wards'])){ //xã phường.
					$conditionsTransfer['wards']=array('$regex' => $_GET['wards']);
				}
				$conditionsTransfer['typedateEndPay']=(int)1;
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;
				$oder=array('timeServer'=>'DESC');
				//$order = array('created'=>'DESC');
				$listData= $modelTransfer->getPage($page, $limit , $conditionsTransfer, $oder, $fields=array('timeServer','codeMachine','idPlace','idStaff','idChannel','quantity','moneyCalculate','idMachine') );

				$totalData= $modelTransfer->find('count',array('conditions' => $conditionsTransfer));
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

				$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditionsTransfer,'order'=>$oder,'fields'=>array('idMachine','quantity','moneyCalculate','typedateEndPay','timeServer','codeMachine','idPlace','idChannel','idStaff')));
			// tính tổng
				$tongsl=0;
				$tongTien=0;
				if(!empty($listTransfer)){
					foreach ($listTransfer as $key => $value) {
						$tongTien=$tongTien+$value['Transfer']['moneyCalculate'];
						$tongsl=$tongsl+$value['Transfer']['quantity'];

					}
				}
			// xử lý excel
				if(!empty($_POST['inport'])){
					pr($listTransfer);
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Thời gian'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã máy'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tên điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Kênh bán hàng'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Số lượng'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Doanh thu tiền mặt'), 'width' => 15, 'filter' => true),
						array('label' => __('Mã nhân viên'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($listTransfer)){
						foreach ($listTransfer as $key => $value) {
							if(!empty($value['Transfer']['idPlace'])){
								$place[$key]=$modelPlace->getPlace( $value['Transfer']['idPlace'],$fields=array('code','name') );
							}
							if(!empty($value['Transfer']['idStaff'])){
								$codeStaff=$modelStaff->getStaff($value['Transfer']['idStaff'],array('code') );
							}
							$tong=$value['Transfer']['moneyCalculate'];
							$stt= $key+1;
							$time=date('d/m/Y H:i:s',$value['Transfer']['timeServer']);
							$chanel=isset($listChannelProduct['Option']['value']['allData'][$value['Transfer']['idChannel']]['name'])?$listChannelProduct['Option']['value']['allData'][$value['Transfer']['idChannel']]['name']:'';
							$name=isset($place[$key]['Place']['name'])?$place[$key]['Place']['name']:'';
							$code=isset($place[$key]['Place']['code'])?$place[$key]['Place']['code']:'';
							$data[]= array( $stt,
								$time,
								$value['Transfer']['codeMachine'],
								$code,
								$name,
								$chanel,
								$value['Transfer']['quantity'],
								$tong,
								$codeStaff['Staff']['code']
						);					# code...
						}
						$cua=array('','','','','','Tổng cộng',$tongsl,$tongTien,'');
						array_push($data,$cua);
					}
					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Tong-hop-doanh-thu-tien-mat')));
				}
				setVariable('tongsl',$tongsl);
				setVariable('tongTien',$tongTien);

				setVariable('listData',$listData);
				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
			}

			setVariable('listChannelProduct',$listChannelProduct);
			setVariable('listPlace',$listPlace);
		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
	// tổng hợp doanh thu theo thẻ
function listRevenueByCard(){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Tổng hợp doanh thu theo thẻ';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelPlace= new Place;
	$modelStaff= new Staff;
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByCard', $_SESSION['infoStaff']['Staff']['permission']))){
			$listChannelProduct=$modelOption->getOption('listChannelProduct');
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name','code')));
			setVariable('listPlace',$listPlace);
			setVariable('listChannelProduct',$listChannelProduct);
			if (!empty($_GET)) {
				# code...
				if(!empty($listChannelProduct['Option']['value']['allData'])){
					$listChannel=$listChannelProduct['Option']['value']['allData'];
					setVariable('listChannel',$listChannel);
				}
				$oder=array('timeServer'=>'DESC');
				$conditionsTransfer= array('typedateEndPay'=>array('$ne'=>1),'status'=>(int)1);
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByCard', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditionsTransfer= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
				}
				if(!empty($_GET['idChannel'])){
					$conditionsTransfer['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				if(!empty($_GET['idPlace'])){
					$conditionsTransfer['idPlace']=$_GET['idPlace'];
				}
				if(!empty($_GET['codeMachine'])){
					$code=trim($_GET['codeMachine']);
					$conditionsTransfer['codeMachine']=array('$regex' => $code);
				}
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$lte']= $time;
				}
				if(!empty($_GET['idCity'])){ // tỉnh/thành phố.
					$conditionsTransfer['idCity']= array('$regex' => $_GET['idCity']);
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditionsTransfer['area']=array('$regex' => $area);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditionsTransfer['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['wards'])){ //xã phường.
					$conditionsTransfer['wards']=array('$regex' => $_GET['wards']);
				}
				$conditionsTransfer['typedateEndPay']=array('$ne'=>(int)1);
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;
				$listData= $modelTransfer->getPage($page, $limit , $conditionsTransfer, $oder, $fields=array('timeServer','codeMachine','idPlace','idStaff','idChannel','quantity','moneyCalculate','idMachine') );

				$totalData= $modelTransfer->find('count',array('conditions' => $conditionsTransfer));
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
				$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditionsTransfer,'order'=>$oder,'fields'=>array('idMachine','quantity','moneyCalculate','typedateEndPay','timeServer','codeMachine','idPlace','idChannel','idStaff')));

			// tính tổng
				$tongsl=0;
				$tongTien=0;
				if(!empty($listTransfer)){
					foreach ($listTransfer as $key => $value) {
						if($value['Transfer']['typedateEndPay']=2||$value['Transfer']['typedateEndPay']=4){
							$tongTien=$tongTien+$value['Transfer']['moneyCalculate'];
							$tongsl=$tongsl+$value['Transfer']['quantity'];

						}		# code...
					}
				}
			// xử lý excel
				if(!empty($_POST['inport'])){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Thời gian'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã máy'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Mã điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tên điểm đặt'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Kênh bán hàng'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Số lượng'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Doanh thu thẻ'), 'width' => 15, 'filter' => true),
						array('label' => __('Mã nhân viên'), 'width' => 15, 'filter' => true),
					);
					$data= array();
					if(!empty($listTransfer)){
						foreach ($listTransfer as $key => $value) {
							if($value['Transfer']['typedateEndPay']=2||$value['Transfer']['typedateEndPay']=4){
								if(!empty($value['Transfer']['idPlace'])){
									$place[$key]=$modelPlace->getPlace( $value['Transfer']['idPlace'],$fields=array('code','name') );
								}
								if(!empty($value['Transfer']['idStaff'])){
									$codeStaff=$modelStaff->getStaff($value['Transfer']['idStaff'],array('code') );
								}
								$tong=$value['Transfer']['moneyCalculate'];
								$stt= $key+1;
								$time=date('d/m/Y H:i:s',$value['Transfer']['timeServer']);
								$chanel=isset($listChannelProduct['Option']['value']['allData'][$value['Transfer']['idChannel']]['name'])?$listChannelProduct['Option']['value']['allData'][$value['Transfer']['idChannel']]['name']:'';
								$name=isset($place[$key]['Place']['name'])?$place[$key]['Place']['name']:'';
								$code=isset($place[$key]['Place']['code'])?$place[$key]['Place']['code']:'';
								$data[]= array( $stt,
									$time,
									$value['Transfer']['codeMachine'],
									$code,
									$name,
									$chanel,
									$value['Transfer']['quantity'],
									$tong,
									$codeStaff['Staff']['code']
								);
						}		# code...
					}
					$cua=array('','','','','','Tổng cộng',$tongsl,$tongTien,'');
					array_push($data,$cua);
				}
				$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
				$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Tong-hop-doanh-thu-theo-the')));
			}
			setVariable('tongsl',$tongsl);
			setVariable('tongTien',$tongTien);
			setVariable('listData',$listData);
			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
		}

	}else{
		$modelMachine->redirect($urlHomes.'dashboard');
	}
}else{
	$modelMachine->redirect($urlHomes.'login?status=-2');
}
}
// báo cáo doanh thu các chi nhánh
function listRevenueByBranch(){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo bán hàng theo chi nhánh';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelPlace= new Place;
	$modelBranch= new Branch();
	$modelStaff = new Staff();
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByBranch', $_SESSION['infoStaff']['Staff']['permission']))){
			$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name','code')));
			if (!empty($_GET)) {
				# code...
				$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
				if($page<1) $page=1;
				$limit= 15;
				$conditions = array('status'=>'active');
				if(!empty($_GET['code'])){
					$conditions['slug.code']= array('$regex' => createSlugMantan(trim($_GET['code'])));
				}

				if(!empty($_GET['name'])){
					$key= createSlugMantan(trim($_GET['name']));
					$conditions['slug.name']= array('$regex' => $key);
				}
				$order = array('created'=>'DESC');
				$fields= array('name','code');
				$listData= $modelBranch->getPage($page, $limit , $conditions, $order, $fields );

				$totalData= $modelBranch->find('count',array('conditions' => $conditions));
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
				$conditionsTransfer['status']=(int)1;
				if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByBranch', $_SESSION['infoStaff']['Staff']['permission'])) {
					$conditionsTransfer['idMachine']= array('$in'=>$_SESSION['listIdMachine']);
				}
				if(!empty($_GET['dayTo'])){
					$date= explode('/', $_GET['dayTo']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$gte']= $time;
				}
				if(!empty($_GET['dayForm'])){
					$date= explode('/', $_GET['dayForm']);
					$date1=explode(' ',$date[2]);
					$date2=explode(':',$date1[1]);
					$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
					$conditionsTransfer['timeServer']['$lte']= $time;
				}
				if(!empty($_GET['idCity'])){ // tỉnh/thành phố.
					$conditionsTransfer['idCity']= array('$regex' => $_GET['idCity']);
				}
				if(!empty($_GET['idChannel'])){
					$conditionsTransfer['idChannel']=array('$regex' =>$_GET['idChannel']);
				}
				if(!empty($_GET['area'])){ //vùng miền
					$area=trim($_GET['area']);
					$conditionsTransfer['area']=array('$regex' => $area);
				}
				if(!empty($_GET['idDistrict'])){ //quận/huyện
					$idDistrict=trim($_GET['idDistrict']);
					$conditionsTransfer['idDistrict']=array('$regex' => $idDistrict);
				}
				if(!empty($_GET['idPlace'])){ //điểm đặt.
					$idPlace=trim($_GET['idPlace']);
					$conditionsTransfer['idPlace']=array('$regex' => $idPlace);
				}
				if(!empty($_GET['wards'])){ //xã phường.
					$conditionsTransfer['wards']=array('$regex' => $_GET['wards']);
				}
				$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditionsTransfer,'fields'=>array('idMachine','quantity','moneyCalculate','typedateEndPay','timeServer','codeMachine','idPlace','idChannel','idStaff')));
            // tính tổng
				$listBranch=$modelBranch->find('all', array('conditions'=>$conditions,'order'=>$order,'fields'=>array('name')));
				$tongTien=0;
				$tongSL=0;
				if($listBranch){
					foreach ($listBranch as $key => $value) {
						$tien=0;
						$sl=0;
					$tytrong=0;			# code...
					if(!empty($listTransfer)){
						foreach ($listTransfer as $key1 => $cua) {
													# code... trường hợp có idStaff trong bảng
							if(!empty($cua['Transfer']['idStaff'])){
								$staff=$modelStaff->getStaff($cua['Transfer']['idStaff'],$fields=array('idBranch'));
								if((!empty($staff['Staff']['idBranch']))&&$staff['Staff']['idBranch']== $value['Branch']['id']){
									$tien= $tien+$cua['Transfer']['moneyCalculate'];
									$sl= $sl+$cua['Transfer']['quantity'];
								}
							}

						}
					}
					$tongTien=$tongTien+$tien;
					$tongSL=$tongSL+$sl;
				}
			}
			// xử lý excel
			if(!empty($_POST['inport'])){
				$table = array(
					array('label' => __('STT'), 'width' => 5),
					array('label' => __('Chi nhánh'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Sản lượng bán(lẻ)'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Tỷ trọng SL(%)'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Doanh thu'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Tỷ trọng doanh thu(%)'),'width' => 17, 'filter' => true, 'wrap' => true),

				);
				$data= array();
				if(!empty($listBranch)){
					foreach ($listBranch as $key => $value) {
						$tien=0;
						$tytrong=0;
						$sl=0;
						$tytrongsl=0;
						if(!empty($listTransfer)){
							foreach ($listTransfer as $key1 => $cua) {
								if(!empty($cua['Transfer']['idStaff'])){
									$staff=$modelStaff->getStaff($cua['Transfer']['idStaff'],$fields=array('idBranch'));
									if((!empty($staff['Staff']['idBranch']))&&$staff['Staff']['idBranch']== $value['Branch']['id']){
										$tien= $tien+$cua['Transfer']['moneyCalculate'];
										$sl= $sl+$cua['Transfer']['quantity'];
									}
								}
							}
						}
						if($tongTien!=0){
							$tytrong=($tien/$tongTien)*100;
						}
						if($tongSL!=0){
							$tytrongsl=($sl/$tongSL)*100;
						}
						$so=round($tytrong,2, PHP_ROUND_HALF_UP);
						$so1=round($tytrongsl,2, PHP_ROUND_HALF_UP);
						$stt= $key+1;
						$data[]= array( $stt,
							$value['Branch']['name'],
							$sl,
							$so1,
							$tien,
							$so,

						);
					}
					$cua=array('','Tổng cộng',$tongSL,'',$tongTien,'');
					array_push($data,$cua);
				}
				$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
				$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Bao-cao-doanh-thu-theo-chi-nhanh')));
			}
			setVariable('tongTien',$tongTien);
			setVariable('tongSL',$tongSL);
			setVariable('listData',$listData);

			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
			setVariable('listTransfer',$listTransfer);


		}
		setVariable('listPlace',$listPlace);
	}else{
		$modelMachine->redirect($urlHomes.'dashboard');
	}
}else{
	$modelMachine->redirect($urlHomes.'login?status=-2');
}

}
// báo cáo daonh thu chi nhánh thoe nhà cung cấp
function listRevenueByBranchOrderSupplier($input){
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;
	global $modelOption;
	$metaTitleMantan= 'Báo cáo  doanh thu chi nhánh theo nhà cung cấp';
	$modelMachine= new Machine();
	$modelTransfer= new Transfer();
	$modelProduct= new Product();
	$modelSupplier= new Supplier;
	$modelPlace= new Place;
	$modelBranch= new Branch();
	$modelStaff = new Staff();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByBranchOrderSupplier', $_SESSION['infoStaff']['Staff']['permission']))){
			$id=$input['request']->params['pass']['1'];
			if(!empty($id)){
				$branch=$modelBranch->getBranch($id,array('name') );
				if(!empty($_GET)){
					$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
					if($page<1) $page=1;
					$limit= 15;
					$conditions = array();
					if(!empty($_GET['name'])){
						$key= createSlugMantan(trim($_GET['name']));
						$conditions['slug.name']= array('$regex' => $key);
					}
					$order = array('created'=>'DESC');
					$fields= array('name','code');
					$listData= $modelSupplier->getPage($page, $limit , $conditions, $order, $fields );
					$totalData= $modelSupplier->find('count',array('conditions' => $conditions));
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
					$conditionsTransfer['status']=(int)1;
					if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listRevenueByBranchOrderSupplier', $_SESSION['infoStaff']['Staff']['permission'])) {
						$conditionsTransfer['idMachine']= array('$in'=>$_SESSION['listIdMachine']);
					}
					if(!empty($_GET['dayTo'])){
						$date= explode('/', $_GET['dayTo']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$gte']= $time;
					}
					if(!empty($_GET['dayForm'])){
						$date= explode('/', $_GET['dayForm']);
						$date1=explode(' ',$date[2]);
						$date2=explode(':',$date1[1]);
						$time= mktime($date2[0],$date2[1],$date2[2],$date[1],$date[0],$date1[0]);
						$conditionsTransfer['timeServer']['$lte']= $time;
					}
					$listTransfer=$modelTransfer->find('all', array('conditions'=>$conditionsTransfer,'fields'=>array('quantity','moneyCalculate','typedateEndPay','timeServer','idChannel','idStaff','idProduct')));
					$listSupplier=$modelSupplier->find('all', array('conditions'=>$conditions,'order'=>$order,'fields'=>array('name','code')));
				// láy bản ghi thỏa mãn điều kiện
					$allTransfer=array();
					if(!empty($listTransfer)){
						foreach ($listTransfer as $key1 => $cua) {
							if(!empty($cua['Transfer']['idStaff'])){
								$staff=$modelStaff->getStaff($cua['Transfer']['idStaff'],$fields=array('idBranch') );
							}
							if(!empty($staff['Staff']['idBranch'])&&$staff['Staff']['idBranch']==$branch['Branch']['id']){
								array_push($allTransfer, $cua);
							}

						}
					}
				// tính tổng
					$tongSL=0;
					$tongTien=0;
					if(!empty($listSupplier)){
						foreach ($listSupplier as $key => $value) {
						$soluong=0;
						$sotien=0;
						if(!empty($allTransfer)){
							foreach ($allTransfer as $key1 => $cua) {
								$product=$modelProduct->getProduct($cua['Transfer']['idProduct'],$fields=array('idSupplier') );
								if($product['Product']['idSupplier']==$value['Supplier']['id']){
									$soluong=$soluong+$cua['Transfer']['quantity'];
								//	$sotien=$sotien+($cua['Transfer']['moneyCalculate']*$cua['Transfer']['quantity']);//xem lại công thức.
									$sotien=$sotien+$cua['Transfer']['moneyCalculate'];
								}
							}
						}
						$tongSL=$tongSL+$soluong;
						$tongTien=$tongTien+$sotien;

					}
				}
				// xử lý excel
				if(!empty($_POST['inport'])){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Nhà cung cấp'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Sản lượng bán(lẻ)'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tỷ trọng SL bán(%)'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Doanh thu'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Tỷ trọng(%)'),'width' => 17, 'filter' => true, 'wrap' => true),

					);
					$data= array();
					if(!empty($listSupplier)){
						foreach ($listSupplier as $key => $value) {
							$soluong=0;
							$sotien=0;
							$ttsl=0;
							$ttt=0;
												# code...
							if(!empty($allTransfer)){
								foreach ($allTransfer as $key1 => $cua) {
													# code...
									$product=$modelProduct->getProduct($cua['Transfer']['idProduct'],$fields=array('idSupplier') );
									if($product['Product']['idSupplier']==$value['Supplier']['id']){
										$soluong=$soluong+$cua['Transfer']['quantity'];
										$sotien=$sotien+$cua['Transfer']['moneyCalculate'];
									}
								}
							}
							if($tongSL!=0){
								$ttsl=($soluong/$tongSL)*100;
							}
							if($tongTien!=0){
								$ttt=($sotien/$tongTien)*100;
							}
							$so=round($ttsl,2, PHP_ROUND_HALF_UP);
							$so1=round($ttt,2, PHP_ROUND_HALF_UP);
							$stt= $key+1;
							$data[]= array( $stt,
								$value['Supplier']['name'],
								$soluong,
								$so,
								$sotien,
								$so1,

							);
						}
						$cua=array('','Tổng cộng',$tongSL,'',$tongTien,'');
						array_push($data,$cua);

					}
					$exportsController = new ExportsController();
					//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'bao-cao-doanh-thu-chi-nhanh-theo-ncc')));
				}
				setVariable('tongSL',$tongSL);
				setVariable('tongTien',$tongTien);
				setVariable('allTransfer',$allTransfer);
				setVariable('listTransfer',$listTransfer);
				setVariable('listData',$listData);
				setVariable('page',$page);
				setVariable('totalPage',$totalPage);
				setVariable('back',$back);
				setVariable('next',$next);
				setVariable('urlPage',$urlPage);
			}

			setVariable('branch',$branch);
		}
	}else{
		$modelProduct->redirect($urlHomes.'dashboard');
	}
}else{
	$modelProduct->redirect($urlHomes.'login?status=-2');
}

}
?>
