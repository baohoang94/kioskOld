<?php 
function addErrorMachine($input){
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	global $contactSite;
	global $smtpSite;
	$metaTitleMantan= 'Thông lỗi mới';
	$modelErrormachine = new Errormachine;
	$modelPlace= new Place();
	$modelSupplier = new Supplier();
	$modelLog= new Log();
	$modelMachine= new Machine();
	$modelPatner= new Patner();
	$modelError= new Error();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addErrorMachine', $_SESSION['infoStaff']['Staff']['permission']))){

			$mess= '';
			$data= array();
			if(!empty($_GET['id'])){
				$data= $modelError->getError($_GET['id']);
			}
			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			$listCityKiosk = $modelOption->getOption('cityKiosk');
			if($isRequestPost){
				$dataSend=$input['request']->data;
				$machine=$modelMachine->getMachineCode($dataSend['codeMachine'],array('name'));
				if(!empty($machine)){
					$data['Error']['codeMachine']=$dataSend['codeMachine'];
					$data['Error']['idMachine']=$machine['Machine']['id'];
					$data['Error']['codeError']=$dataSend['codeError'];
					$data['Error']['name']=$dataSend['name'];
					$data['Error']['note']=$dataSend['note'];
					$data['Error']['nameTechnicians']=$dataSend['nameTechnicians'];
					$data['Error']['dayError']=$dataSend['dayError'];
					$data['Error']['dayReportError']=$dataSend['dayReportError'];
					$data['Error']['dayStart']=$dataSend['dayStart'];
					$data['Error']['dayEnd']=$dataSend['dayEnd'];
					$data['Error']['status']=(int)$dataSend['status'];
					$data['Error']['idCity']=(int)$dataSend['idCity'];
					$data['Error']['delete']='false';
					$data['Error']['slug']['codeMachine']=createSlugMantan(trim($dataSend['codeMachine']));
					$data['Error']['slug']['codeError']=createSlugMantan(trim($dataSend['codeError']));
					$data['Error']['slug']['name']=createSlugMantan(trim($dataSend['name']));
					$data['Error']['slug']['nameTechnicians']=createSlugMantan(trim($dataSend['nameTechnicians']));
					if($modelError->save($data)){
						$mess= 'Lưu thành công';
						if($dataSend['status']==4){
							$update['Machine']['status']=(int)1;
							$dk= array('_id'=>new mongoId($machine['Machine']['id']));
							$modelMachine->updateAll($update['Machine'],$dk);
						}
						if($dataSend['status']==1||$dataSend['status']==2||$dataSend['status']==3){
							$update['Machine']['status']=(int)3;
							$dk= array('_id'=>new mongoId($machine['Machine']['id']));
							$modelMachine->updateAll($update['Machine'],$dk);
						}
						if(!empty($dataSend['reason'])){

							$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa mã lỗi: '.$dataSend['codeError'].'. Lý do sửa:'.$dataSend['reason'];
							$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
							$to = array(trim($contactSite['Option']['value']['email']));
							$cc = array();
							$bcc = array();
							$subject = '[' . $smtpSite['Option']['value']['show'] . '] Cập nhật thông tin lỗi cũ ';
							switch ($data['Error']['status']) {
								case '1':
								$trangthai="Mới tạo";
								break;
								case '2':
								$trangthai="Đang chờ xử lý";
								break;
								case '3':
								$trangthai="Đang xử lý";
								break;
								case '4':
								$trangthai="Hoàn thành";
								break;
								case '5':
								$trangthai="Dóng";
								break;

								default:
            		# code...
								break;
							}

							$content = 'Xin chào <br/>';
							$content.= '
							<br>'.$_SESSION['infoStaff']['Staff']['fullName'].' đã cập nhật thông tin lỗi như sau:</br>
							<br>Tên máy: '.$machine['Machine']['name'].'</br>
							<br>Mã máy: '.$data['Error']['codeMachine'].'</br>
							<br>Mã lỗi: '.$data['Error']['codeError'].'</br>
							<br>Tên lỗi: '.$data['Error']['name'].'</br>
							<br>Trạng thái: '.$trangthai.'</br>
							<br>Lý do sửa: '.$dataSend['reason'].'
							<hr>
							Thông tin đăng nhập:<br/>
							Tên đăng nhập: '.$_SESSION['infoStaff']['Staff']['code'].'<br/>
							Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

							$modelMachine->sendMail($from, $to, $cc, $bcc, $subject, $content);
						}else{
							$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm lỗi mới có mã:'.$dataSend['codeError'];
							$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
							$to = array(trim($contactSite['Option']['value']['email']));
							$cc = array();
							$bcc = array();
							$subject = '[' . $smtpSite['Option']['value']['show'] . '] Thêm máy bị lỗi ';
							switch ($data['Error']['status']) {
								case '1':
								$trangthai="Mới tạo";
								break;
								case '2':
								$trangthai="Đang chờ xử lý";
								break;
								case '3':
								$trangthai="Đang xử lý";
								break;
								case '4':
								$trangthai="Hoàn thành";
								break;
								case '5':
								$trangthai="Dóng";
								break;

								default:
            		# code...
								break;
							}

							$content = 'Xin chào <br/>';
							$content.= '
							<br>'.$_SESSION['infoStaff']['Staff']['fullName'].' đã cập nhật thông tin lỗi như sau:</br>
							<br>Tên máy: '.$machine['Machine']['name'].'</br>
							<br>Mã máy: '.$data['Error']['codeMachine'].'</br>
							<br>Mã lỗi: '.$data['Error']['codeError'].'</br>
							<br>Tên lỗi: '.$data['Error']['name'].'</br>
							<br>Trạng thái: '.$trangthai.'</br>
							<br>Lý do sửa: '.$dataSend['reason'].'
							<hr>
							Thông tin đăng nhập:<br/>
							Tên đăng nhập: '.$_SESSION['infoStaff']['Staff']['code'].'<br/>
							Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';
							$modelMachine->sendMail($from, $to, $cc, $bcc, $subject, $content);
						}
						$saveLog['Log']['time']= time();
						$modelLog->save($saveLog);
					}else{
						$modelError->redirect($urlHomes.'listErrorMachine');
					}
				}else{
					$mess= 'Mã máy không tồn tại';
				}
			}
			setVariable('mess',$mess);
			setVariable('data',$data);
			setVariable('listCityKiosk',$listCityKiosk);
		}
		else{
		$modelMachine->redirect($urlHomes.'dashboard');
	}
	}
	else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
function infoErrorMachine($input){
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	global $contactSite;
	global $smtpSite;
	$metaTitleMantan= 'Thông lỗi mới';
	$modelErrormachine = new Errormachine;
	$modelPlace= new Place();
	$modelSupplier = new Supplier();
	$modelLog= new Log();
	$modelMachine= new Machine();
	$modelPatner= new Patner();
	$modelError= new Error();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoErrorMachine', $_SESSION['infoStaff']['Staff']['permission']))){

			$mess= '';
			$data= array();
			if(!empty($_GET['id'])){
				$data= $modelError->getError($_GET['id']);
			}
			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			$listCityKiosk = $modelOption->getOption('cityKiosk');
			if($isRequestPost){
				$dataSend=$input['request']->data;
				$machine=$modelMachine->getMachineCode($dataSend['codeMachine'],array('name'));
				if(!empty($machine)){
					$data['Error']['codeMachine']=$dataSend['codeMachine'];
					$data['Error']['idMachine']=$machine['Machine']['id'];
					$data['Error']['codeError']=$dataSend['codeError'];
					$data['Error']['name']=$dataSend['name'];
					$data['Error']['note']=$dataSend['note'];
					$data['Error']['nameTechnicians']=$dataSend['nameTechnicians'];
					$data['Error']['dayError']=$dataSend['dayError'];
					$data['Error']['dayReportError']=$dataSend['dayReportError'];
					$data['Error']['dayStart']=$dataSend['dayStart'];
					$data['Error']['dayEnd']=$dataSend['dayEnd'];
					$data['Error']['status']=(int)$dataSend['status'];
					$data['Error']['idCity']=(int)$dataSend['idCity'];
					$data['Error']['delete']='false';
					$data['Error']['slug']['codeMachine']=createSlugMantan(trim($dataSend['codeMachine']));
					$data['Error']['slug']['codeError']=createSlugMantan(trim($dataSend['codeError']));
					$data['Error']['slug']['name']=createSlugMantan(trim($dataSend['name']));
					$data['Error']['slug']['nameTechnicians']=createSlugMantan(trim($dataSend['nameTechnicians']));
					if($modelError->save($data)){
						$mess= 'Lưu thành công';
						if($dataSend['status']==4){
							$update['Machine']['status']=(int)1;
							$dk= array('_id'=>new mongoId($machine['Machine']['id']));
							$modelMachine->updateAll($update['Machine'],$dk);
						}
						if($dataSend['status']==1||$dataSend['status']==2||$dataSend['status']==3){
							$update['Machine']['status']=(int)3;
							$dk= array('_id'=>new mongoId($machine['Machine']['id']));
							$modelMachine->updateAll($update['Machine'],$dk);
						}
						if(!empty($dataSend['reason'])){

							$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa lỗi cũ có mã: '.$dataSend['codeError'].'. Lý do sửa:'.$dataSend['reason'];
							$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
							$to = array(trim($contactSite['Option']['value']['email']));
							$cc = array();
							$bcc = array();
							$subject = '[' . $smtpSite['Option']['value']['show'] . '] Cập nhật thông tin lỗi cũ ';
							switch ($data['Error']['status']) {
								case '1':
								$trangthai="Mới tạo";
								break;
								case '2':
								$trangthai="Đang chờ xử lý";
								break;
								case '3':
								$trangthai="Đang xử lý";
								break;
								case '4':
								$trangthai="Hoàn thành";
								break;
								case '5':
								$trangthai="Dóng";
								break;

								default:
            		# code...
								break;
							}

							$content = 'Xin chào <br/>';
							$content.= '
							<br>'.$_SESSION['infoStaff']['Staff']['fullName'].' đã cập nhật thông tin lỗi như sau</br>
							<br>Tên máy: '.$machine['Machine']['name'].'</br>
							<br>Mã máy: '.$data['Error']['codeMachine'].'</br>
							<br>Mã lỗi: '.$data['Error']['codeError'].'</br>
							<br>Tên lỗi: '.$data['Error']['name'].'</br>
							<br>Trạng thái: '.$trangthai.'</br>
							<br>Lý do sửa:'.$dataSend['reason'].'</br>
							<br/>Thông tin đăng nhập:<br/>
							Tên đăng nhập: '.$_SESSION['infoStaff']['Staff']['code'].'<br/>
							Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

							$modelMachine->sendMail($from, $to, $cc, $bcc, $subject, $content);
						}else{
							$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm lỗi mới có mã: '.$dataSend['codeError'];
							$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
							$to = array(trim($contactSite['Option']['value']['email']));
							$cc = array();
							$bcc = array();
							$subject = '[' . $smtpSite['Option']['value']['show'] . '] Thêm máy bị lỗi ';
							switch ($data['Error']['status']) {
								case '1':
								$trangthai="Mới tạo";
								break;
								case '2':
								$trangthai="Đang chờ xử lý";
								break;
								case '3':
								$trangthai="Đang xử lý";
								break;
								case '4':
								$trangthai="Hoàn thành";
								break;
								case '5':
								$trangthai="Dóng";
								break;

								default:
            		# code...
								break;
							}

							$content = 'Xin chào <br/>';
							$content.= '
							<br>'.$_SESSION['infoStaff']['Staff']['fullName'].' đã cập nhật thông tin lỗi như sau</br>
							<br>Tên máy: '.$machine['Machine']['name'].'</br>
							<br>Mã máy: '.$data['Error']['codeMachine'].'</br>
							<br>Mã lỗi: '.$data['Error']['codeError'].'</br>
							<br>Tên lỗi: '.$data['Error']['name'].'</br>
							<br>Trạng thái: '.$trangthai.'</br>
							<br/>Thông tin đăng nhập:<br/>
							Tên đăng nhập: '.$_SESSION['infoStaff']['Staff']['code'].'<br/>
							Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

							$modelMachine->sendMail($from, $to, $cc, $bcc, $subject, $content);
						}
						$saveLog['Log']['time']= time();
						$modelLog->save($saveLog);
					}else{
						$modelError->redirect($urlHomes.'listErrorMachine');
					}
				}else{
					$mess= 'Mã máy không tồn tại';
				}
			}
			setVariable('mess',$mess);
			setVariable('data',$data);
			setVariable('listCityKiosk',$listCityKiosk);
		}
		else{
		$modelMachine->redirect($urlHomes.'dashboard');
	}
	}
	else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
function deleteErrorMachine(){
	global $urlHomes;
	$modelError=new Error;
	$modelLog= new Log();
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteErrorMachine', $_SESSION['infoStaff']['Staff']['permission']))){
			$update['Error']['delete']='true';
			$dk= array('_id'=>new mongoId($_GET['idDelete']));
			$dataa=$modelError->getError($_GET['idDelete']);
			if($modelError->updateAll($update['Error'],$dk)){
				$saveLog['Log']['time']= time();
				$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Xóa lỗi cũ có mã: '.$dataa['Error']['codeError'];
				$modelLog->save($saveLog);
				$modelError->redirect($urlHomes. 'listErrorMachine');
			}else{
				$modelError->redirect($urlHomes. 'listErrorMachine');
			}
		}
		else{
		$modelError->redirect($urlHomes.'dashboard');
	}

	}
	else{
		$modelError->redirect($urlHomes.'login?status=-2');
	}
}
function listErrorMachine(){
	global $urlHomes;
	global $isRequestPost;
	global $contactSite;
	global $urlNow;
	global $modelOption;
	global $metaTitleMantan;
	global $listManagementAgency;
	global $listArea;
	global $listStatusMachine;
	global $listStatusErrorMachine;
	$metaTitleMantan= 'Danh sách lỗi';
	$modelError= new Error();
	$modelMachine= new Machine();

	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listErrorMachine', $_SESSION['infoStaff']['Staff']['permission']))){
			$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
			if($page<1) $page=1;
			$limit= 15;
			$conditions = array();
			$order = array('created'=>'DESC');
			$fields= array();
			$conditions['delete']='false';
			if(!empty($_GET['codeError'])){
				$conditions['slug.codeError']= array('$regex' => createSlugMantan(trim($_GET['codeError'])));
			}
			if(!empty($_GET['code'])){
				$code=trim($_GET['code']);
				$conditions['slug.codeMachine']= array('$regex' => createSlugMantan($code));
			}
			if(!empty($_GET['name'])){
				$conditions['slug.name']= array('$regex' => createSlugMantan(trim($_GET['name'])));
			}
			if(!empty($_GET['nameTechnicians'])){
				$conditions['slug.nameTechnicians']= array('$regex' => createSlugMantan(trim($_GET['nameTechnicians'])));
			}
			if(!empty($_GET['status'])){
				$conditions['status']= (int)$_GET['status'];
			}
			if(!empty($_GET['idCity'])){
				$conditions['idCity']= (int)$_GET['idCity'];
			}
			if(!empty($_GET['dayReportError'])){
				$conditions['dayReportError']= array('$regex' => $_GET['dayReportError']);
			}
			if(!empty($_GET['dayStart'])){
				$conditions['dayStart']= array('$regex' => $_GET['dayStart']);
			}
			if(!empty($_GET['dayEnd'])){
				$conditions['dayEnd']= array('$regex' => $_GET['dayEnd']);
			}
			if(!empty($_GET['dayTo'])){
				$conditions['dayReportError']= array('$gte' =>$_GET['dayTo']);
			}
			if(!empty($_GET['dayForm'])){
				$conditions['dayReportError']= array('$lte' => $_GET['dayForm']);
			}
			$listData= $modelError->getPage($page, $limit , $conditions, $order, $fields );
			$totalData= $modelError->find('count',array('conditions' => $conditions));
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
			$listCityKiosk = $modelOption->getOption('cityKiosk');
			// xử lý excel
			$listErorr=$modelError->find('all', array('conditions'=>$conditions, $order,'fields'=>array('codeMachine','name','status','idCity','dayError','dayReportError','dayStart','dayEnd','nameTechnicians')));
			if(!empty($_POST['inport'])){
				$table = array(
					array('label' => __('STT'), 'width' => 5),
					array('label' => __('Mã máy'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Tên lỗi'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Tỉnh/Thành phố'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Ngày bắt đầu hỏng'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Ngày báo hỏng'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Ngày khắc phục'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Thời gian hoàn thành khắc phục'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('KTV sửa chữa'),'width' => 17, 'filter' => true, 'wrap' => true),
					array('label' => __('Trạng thái'),'width' => 17, 'filter' => true, 'wrap' => true),

				);
				$data= array();
				if(!empty($listErorr)){
					foreach ($listErorr as $key => $value) {
						$so=round($ttsl,2, PHP_ROUND_HALF_UP);
						$so1=round($ttt,2, PHP_ROUND_HALF_UP);
						$stt= $key+1;
						$idCity=$listCityKiosk['Option']['value']['allData'][$value['Error']['idCity']]['name'];
						$status=$listStatusErrorMachine[$value['Error']['status']]['name'];
						$data[]= array( $stt,
							$value['Error']['codeMachine'],
							$value['Error']['name'],
							$idCity,
							$value['Error']['dayError'],
							$value['Error']['dayReportError'],
							$value['Error']['dayStart'],
							$value['Error']['dayEnd'],
							$value['Error']['nameTechnicians'],
							$status,

						);
					} 
				}
				$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
				$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-loi')));
			}
			setVariable('listData',$listData);
			setVariable('listStatusErrorMachine',$listStatusErrorMachine);
			setVariable('listCityKiosk',$listCityKiosk);
			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
			setVariable('mess',$mess);
		}else{
			$modelMachine->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelMachine->redirect($urlHomes.'login?status=-2');
	}
}
?>