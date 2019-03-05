<?php
function listStaff($input) {
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	if (checkAdminLogin()) {
		$modelStaff = new Staff();
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		$order = array('created'=>'desc');
		if(!empty($_GET['name'])){
			$conditions['slug.fullName']=array('$regex' => createSlugMantan(trim($_GET['name'])));
		}
		if(!empty($_GET['birthday'])){
			$conditions['birthday']=array('$regex' => $_GET['birthday']);
		}
		if(!empty($_GET['email'])){
			$conditions['slug.email']=array('$regex' => createSlugMantan(trim($_GET['email'])));
		}
		if(!empty($_GET['phone'])){
			$conditions['phone']=array('$regex' => trim($_GET['phone']));
		}
		if(!empty($_GET['idCity'])){
			$conditions['idCity']=array('$regex' => $_GET['idCity']);
		}
		if(!empty($_GET['area'])){
			$conditions['area']=array('$regex' => $_GET['area']);
		}
		if(!empty($_GET['idDistrict'])){
			$conditions['idDistrict']=array('$regex' => $_GET['idDistrict']);
		}
		if(!empty($_GET['wards'])){
			$conditions['wards']=array('$regex' => $_GET['wards']);
		}
			// if(!empty($_GET['idDistrict'])){
			// 	$conditions['idDistrict']=array('$regex' => $_GET['idDistrict']);
			// }
		if(!empty($_GET['address'])){
			$conditions['address']=array('$regex' => createSlugMantan(trim($_GET['address'])));
		}
		if(!empty($_GET['code'])){
			$conditions['slug.code']=array('$regex' => createSlugMantan(trim($_GET['code'])));
		}
		if(!empty($_GET['position'])){
			$conditions['slug.position']=array('$regex' => createSlugMantan(trim($_GET['position'])));
		}if(!empty($_GET['indirectManager'])){
			$conditions['slug.indirectManager']=array('$regex' => createSlugMantan(trim($_GET['indirectManager'])));
		}if(!empty($_GET['directManager'])){
			$conditions['slug.directManager']=array('$regex' => createSlugMantan(trim($_GET['directManager'])));
		}
		if(!empty($_GET['dateTrial'])){
			$conditions['dateTrial']=array('$regex' => $_GET['dateTrial']);
		}
		
		if(!empty($_GET['dateStart'])){
			$conditions['dateStart']=array('$regex' => $_GET['dateStart']);
		}
		$listData = $modelStaff->getPage($page, $limit, $conditions, $order);

		$totalData = $modelStaff->find('count', array('conditions' => $conditions));

		$balance = $totalData % $limit;
		$totalPage = ($totalData - $balance) / $limit;
		if ($balance > 0)
			$totalPage+=1;

		$back = $page - 1;
		$next = $page + 1;
		if ($back <= 0)
			$back = 1;
		if ($next >= $totalPage)
			$next = $totalPage;

		if (isset($_GET['page'])) {
			$urlNow = str_replace("?mess=-2", "", $urlNow);
			$urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
			$urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
		} else {
			$urlPage = $urlNow;
		}
		if (strpos($urlPage, '?') !== false) {
			if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
				$urlPage = $urlPage . '&page=';
			} else {
				$urlPage = $urlPage . 'page=';
			}
		} else {
			$urlPage = $urlPage . '?page=';
		}

		setVariable('listData', $listData);
		setVariable('limit', $limit);

		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function addStaff($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlPlugins;
	global $contactSite;
	global $smtpSite;

	if (checkAdminLogin()) {
		$modelStaff = new Staff();
		$save= array();
		if(!empty($_GET['id'])){
			$save = $modelStaff->getStaff($_GET['id']);
		}

		if ($isRequestPost) {

			$dataSend = arrayMap($input['request']->data);
			$modelPermission = new Permission();
			if (empty($_GET['id']) && $modelStaff->isExistUser($dataSend['code'])) {
				$mess = 'Tài khoản đã tồn tại!';
				setVariable('mess', $mess);
			} else {
				if(!empty($dataSend['code'])){
					$save['Staff']['code']= $dataSend['code'];
					$save['Staff']['slug']['code']= createSlugMantan(trim($dataSend['code']));
				}
				$save['Staff']['status']= $dataSend['status'];
                          // $save['Staff']['idCompany']= $dataSend['idCompany'];
                          // $save['Staff']['idBranch']= $dataSend['idBranch'];
                          // $save['Staff']['idPermission']= $dataSend['idPermission'];
				$save['Staff']['fullName']= $dataSend['fullName'];
				$save['Staff']['sex']= $dataSend['sex'];
				$save['Staff']['birthday']= $dataSend['birthday'];
				$save['Staff']['email']= $dataSend['email'];
				$save['Staff']['slug']['email']= createSlugMantan($dataSend['email']);
				$save['Staff']['phone']= $dataSend['phone'];
				$save['Staff']['area']= $dataSend['area'];
				$save['Staff']['idCity']= $dataSend['idCity'];
				$save['Staff']['idDistrict']= $dataSend['idDistrict'];
				$save['Staff']['slug']['wards']= createSlugMantan($dataSend['wards']);
				$save['Staff']['slug']['address']= createSlugMantan($dataSend['address']);
				$save['Staff']['wards']= $dataSend['wards'];
				$save['Staff']['address']= $dataSend['address'];
				$save['Staff']['dateTrial']= $dataSend['dateTrial'];
				$save['Staff']['dateStart']= $dataSend['dateStart'];
				$save['Staff']['position']= $dataSend['position'];
				$save['Staff']['slug']['position']= createSlugMantan($dataSend['position']);
				$save['Staff']['slug']['directManager']= createSlugMantan($dataSend['directManager']);
				$save['Staff']['slug']['indirectManager']= createSlugMantan($dataSend['indirectManager']);
				$save['Staff']['directManager']= $dataSend['directManager'];
				$save['Staff']['indirectManager']= $dataSend['indirectManager'];
				$save['Staff']['desc']= $dataSend['desc'];
				$save['Staff']['pass'] = md5($dataSend['password']);
				$save['Staff']['type'] = 'admin';
				$save['$set']['status'] = $dataSend['status'];

				if(!empty($_GET['id'])){
					$dk= array('_id'=>new MongoId($_GET['id']));
					$staff=$modelStaff->getStaff($_GET['id']);
					
					if ($dataSend['status']=='active'&&$staff['Staff']['status']!=$dataSend['status']) {
			            $savePermission['$inc']['numberStaff']= 1;
			            $dkPermission= array('_id'=> new MongoId($staff['Staff']['idPermission']));
			            $modelPermission->updateAll($savePermission,$dkPermission);
					}elseif ($dataSend['status']=='lock'&&$staff['Staff']['status']!=$dataSend['status']) {
			            $savePermission['$inc']['numberStaff']= -1;
			            $dkPermission= array('_id'=> new MongoId($staff['Staff']['idPermission']));
			            $modelPermission->updateAll($savePermission,$dkPermission);
					}
				}
            
				if (!empty($dataSend['reason'])) {
				$save['Staff']['reason'] = $dataSend['reason'];
				}

				$save['Staff']['slug']['fullName']= createSlugMantan($dataSend['fullName']);
                 // $save['Staff']['slug']['code'] =  createSlugMantan(trim($dataSend['code']));

				if ($modelStaff->save($save)) {
                    // send email for user and admin
					if(empty($_GET['id'])){
						$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
						$to = array(trim($dataSend['email']));
						$cc = array();
						$bcc = array();
						$subject = '[' . $smtpSite['Option']['value']['show'] . '] Tài khoản của bạn đã được khởi tạo thành công';


						$content = 'Xin chào '.$save['Staff']['fullName'].'<br/>';
						$content.= '<br/>Thông tin đăng nhập của bạn là:<br/>
						Tên đăng nhập: '.$save['Staff']['code'].'<br/>
						Mật khẩu: '.$dataSend['password'].'<br/>
						Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

						$modelStaff->sendMail($from, $to, $cc, $bcc, $subject, $content);
						$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới tài khoản nhân viên có tên: '.$dataSend['fullName'].', mã nhân viên: '.$dataSend['code'];
                    $modelLog->save($saveLog);
					}
					else
					{
						$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa thông tin tài khoản nhân viên có tên: '.$dataSend['fullName'].', mã nhân viên: '.$save['Staff']['code'].' Lý do sửa: '.@$dataSend['reason'];
                    $modelLog->save($saveLog);
					}
					$modelStaff->redirect($urlPlugins . 'admin/kiosk-admin-staff-listStaff.php?stt=1');
				} else {
					$modelStaff->redirect($urlPlugins . 'admin/kiosk-admin-staff-addStaff.php?stt=-1');
				}
			}
		}
		$listCityKiosk = $modelOption->getOption('cityKiosk');
		setVariable('listCityKiosk', $listCityKiosk);

		setVariable('data', $save);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function updateStatusStaff($input) {
	global $modelOption;
	global $urlHomes;
	global $urlPlugins;

	if (checkAdminLogin()) {
		$modelStaff = new Staff();
		$modelPermission = new Permission();
		if (isset($_GET['id']) && isset($_GET['status'])) {
			$save['$set']['status'] = $_GET['status'];
			$dk= array('_id'=>new MongoId($_GET['id']));
			$staff=$modelStaff->getStaff($_GET['id']);
			if ($_GET['status']=='active') {
            $savePermission['$inc']['numberStaff']= 1;
			}
			elseif ($_GET['status']=='lock') {
            $savePermission['$inc']['numberStaff']= -1;
			}
            $dkPermission= array('_id'=> new MongoId($staff['Staff']['idPermission']));
            $modelPermission->updateAll($savePermission,$dkPermission);
			$modelStaff->updateALL($save,$dk);
		}
		$modelStaff->redirect($urlPlugins . 'admin/kiosk-admin-staff-listStaff.php?stt=4');
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function listCityAdmin($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlPlugins;
	if (checkAdminLogin()) {
		$listData = $modelOption->getOption('cityKiosk');
		if ($isRequestPost) {
			$dataSend =arrayMap( $input['request']->data);
			if (mb_strlen($dataSend['name']) > 0) {
				if ($dataSend['id'] == '') {
					if (!isset($listData['Option']['value']['tData'])) {
						$listData['Option']['value']['tData'] = 1;
					} else {
						$listData['Option']['value']['tData'] += 1;
					}

					$listData['Option']['value']['allData'][$listData['Option']['value']['tData']] = array('id' => $listData['Option']['value']['tData'], 'name' => $dataSend['name']);
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới Tỉnh/Thành phố: '.$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]['name'];
                    $modelLog->save($saveLog);
				} else {
					$idEdit = (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idEdit]['name'] = $dataSend['name'];
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa Tỉnh/Thành phố:  '.$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]['name'];
                    $modelLog->save($saveLog);
				}
				$modelOption->saveOption('cityKiosk', $listData['Option']['value']);
				$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-city-listCityAdmin.php?code=1');
			} else {
				$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-city-listCityAdmin.php');
			}
		}
		setVariable('listData', $listData);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function deleteCityAdmin($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	if (checkAdminLogin()) {
		if ($isRequestPost) {

			$dataSend = $input['request']->data;
			$listData = $modelOption->getOption('cityKiosk');
			$idDelete = (int) $dataSend['id'];
			$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa thành phố: '.$listData['Option']['value']['allData'][$idDelete]['name'];
                    $modelLog->save($saveLog);
			unset($listData['Option']['value']['allData'][$idDelete]);
			$modelOption->saveOption('cityKiosk', $listData['Option']['value']);
		}
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function listDistrictAdmin($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlPlugins;
	if (checkAdminLogin()) {
		$listData = $modelOption->getOption('cityKiosk');

		if (!isset($_GET['idCity']) || !isset($listData['Option']['value']['allData'][$_GET['idCity']])) {
			$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-city-listCityAdmin.php');
		}

		if ($isRequestPost) {
			$dataSend = $input['request']->data;
			if (!empty($input['request']->query['idCity'])) {
				$idCity = $input['request']->query['idCity'];
			} else {
				$idCity = '';
			}
			if (mb_strlen($dataSend['name']) > 0) {
				if ($dataSend['id'] == '') {
					if (!isset($listData['Option']['value']['allData'][$idCity]['tDistrict'])) {
						$listData['Option']['value']['allData'][$idCity]['tDistrict'] = 1;
					} else {
						$listData['Option']['value']['allData'][$idCity]['tDistrict'] += 1;
					}
					$tDistrict = $listData['Option']['value']['allData'][$idCity]['tDistrict'];
					$listData['Option']['value']['allData'][$idCity]['district'][$tDistrict] = array(
						'id' => $tDistrict,
						'name' => $dataSend['name']
					);
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới quận/huyện: '.$dataSend['name'];
                    $modelLog->save($saveLog);
				} else {
					if (!empty($input['request']->query['idCity'])) {
						$idCity = $input['request']->query['idCity'];
					} else {
						$idCity = '';
					}
					$idEdit = (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idCity]['district'][$idEdit]['name'] = $dataSend['name'];
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa quận/huyện: '.$dataSend['name'];
                    $modelLog->save($saveLog);
				}
				$modelOption->saveOption('cityKiosk', $listData['Option']['value']);
			} else {
				$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-city-listDistrictAdmin.php');
			}
		}
		setVariable('listData', $listData);
	} else {
		$modelOption->redirect($urlHomes);
	}
}


function deleteDistrictAdmin($input) {
	if (checkAdminLogin()) {
		global $modelOption;
		global $isRequestPost;

		if ($isRequestPost) {
			$dataSend = $input['request']->data;
			$listData = $modelOption->getOption('cityKiosk');

			$idCity = $dataSend['idCity'];
			$idDelete = $dataSend['id'];
			$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa quận/huyện: '.$listData['Option']['value']['allData'][$idCity]['district'][$idDelete]['name'];
                    $modelLog->save($saveLog);
			unset($listData['Option']['value']['allData'][$idCity]['district'][$idDelete]);
			$modelOption->saveOption('cityKiosk', $listData['Option']['value']);
		}
	} else {
		$modelOption->redirect($urlHomes);
	}
}
function listWardsAdmin($input){
	$modelWards= new Wards;
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlNow;
	global $urlPlugins;
	if (checkAdminLogin()) {
		if(!empty($_GET['idEdit'])){
			$data=$modelWards->getWards($_GET['idEdit'],$fields=array());
			setVariable('data',$data);
		}
		$listCityKiosk = $modelOption->getOption('cityKiosk');
		if($isRequestPost){
			$dataSend=arrayMap($input['request']->data);
			$name=isset($dataSend['name'])?$dataSend['name']:'';
			$idDistrict=$dataSend['idDistrict'];
			$idCity=$dataSend['idCity'];
			if(empty($dataSend['id'])){
				$save=array(
					'name'=>$name,
					'idDistrict'=>(int)$idDistrict,
					'idCity'=>(int)$dataSend['idCity']
				);
				$modelWards->create();
				if($modelWards->save($save)){
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới xã/phường: '.$dataSend['name'];
                    $modelLog->save($saveLog);
					$modelWards->redirect($urlPlugins . 'admin/kiosk-admin-city-listWardsAdmin.php?idDistrict='.$idDistrict.'&idCity='.$idCity);
					
				}else{
					$modelWards->redirect($urlPlugins . 'admin/kiosk-admin-city-listWardsAdmin.php?idDistrict='.$idDistrict.'&idCity='.$idCity);
				}
			}else{
				$save['Wards']['name']=$name;
				$dk= array('_id'=>new MongoId($_GET['idEdit']));
				if($modelWards->updateAll($save['Wards'],$dk)){
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa xã/phường: '.$dataSend['name'];
                    $modelLog->save($saveLog);
					$modelWards->redirect($urlPlugins . 'admin/kiosk-admin-city-listWardsAdmin.php?idDistrict='.$idDistrict.'&idCity='.$idCity);
					
				}else{
					$modelWards->redirect($urlPlugins . 'admin/kiosk-admin-city-listWardsAdmin.php?idDistrict='.$idDistrict.'&idCity='.$idCity);
				}
			}
		}
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		if(!empty($_GET['idDistrict'])){
			$conditions['idDistrict']=(int)$_GET['idDistrict'];
		}
		if(!empty($_GET['idCity'])){
			$conditions['idCity']=(int)$_GET['idCity'];
		}
		$order = array();
		$listData = $modelWards->getPage($page, $limit, $conditions, $order);

		$totalData = $modelWards->find('count', array('conditions' => $conditions));

		$balance = $totalData % $limit;
		$totalPage = ($totalData - $balance) / $limit;
		if ($balance > 0)
			$totalPage+=1;

		$back = $page - 1;
		$next = $page + 1;
		if ($back <= 0)
			$back = 1;
		if ($next >= $totalPage)
			$next = $totalPage;

		if (isset($_GET['page'])) {
			$urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
			$urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
		} else {
			$urlPage = $urlNow;
		}
		if (strpos($urlPage, '?') !== false) {
			if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
				$urlPage = $urlPage . '&page=';
			} else {
				$urlPage = $urlPage . 'page=';
			}
		} else {
			$urlPage = $urlPage . '?page=';
		}

		setVariable('listData', $listData);
		setVariable('limit', $limit);
		setVariable('listCityKiosk', $listCityKiosk);

		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}
}
function deleteWardsAdmin(){
	$modelWards = new Wards;
	global $urlPlugins;
	global $modelOption;
	if(checkAdminLogin()){
		if(!empty($_GET['idDistrict'])&& !empty($_GET['idCity'])&& !empty($_GET['idDelete'])){
			$idDelete = new mongoId($_GET['idDelete']);
			$listData = $modelWards->getWards($_GET['idDelete']);
			$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa xã/phường: '.$listData['Wards']['name'];
                    $modelLog->save($saveLog);
			$modelWards->delete($idDelete);
			$modelWards->redirect($urlPlugins . 'admin/kiosk-admin-city-listWardsAdmin.php?idDistrict='.$_GET['idDistrict'].'&idCity='.$_GET['idCity']);
		}
	} else {
		$modelOption->redirect($urlHomes);
	}

}
function listSupplier($input) {
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	if (checkAdminLogin()) {
		$modelSupplier = new Supplier();
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		$order = array();

		if(!empty($_GET['code'])){
			$key= trim($_GET['code']);
			$conditions['slug.code']= array('$regex' => createSlugMantan(trim($key)));
		}

		if(!empty($_GET['name'])){
			$key= createSlugMantan(trim($_GET['name']));
			$conditions['slug.name']= array('$regex' => $key);
		}
		if(!empty($_GET['phone'])){
			$phone= trim($_GET['phone']);
			$conditions['phone']= array('$regex' => $phone);
		}
		if(!empty($_GET['email'])){
			$email= trim($_GET['email']);
			$conditions['slug.email']= array('$regex' => createSlugMantan($email));
		}
		if(!empty($_GET['status'])){
			$status= trim($_GET['status']);
			$conditions['status']= array('$regex' => $status);
		}
		$listData = $modelSupplier->getPage($page, $limit, $conditions, $order);

		$totalData = $modelSupplier->find('count', array('conditions' => $conditions));

		$balance = $totalData % $limit;
		$totalPage = ($totalData - $balance) / $limit;
		if ($balance > 0)
			$totalPage+=1;

		$back = $page - 1;
		$next = $page + 1;
		if ($back <= 0)
			$back = 1;
		if ($next >= $totalPage)
			$next = $totalPage;

		if (isset($_GET['page'])) {
			$urlNow = str_replace("?mess=-2", "", $urlNow);
			$urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
			$urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
		} else {
			$urlPage = $urlNow;
		}
		if (strpos($urlPage, '?') !== false) {
			if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
				$urlPage = $urlPage . '&page=';
			} else {
				$urlPage = $urlPage . 'page=';
			}
		} else {
			$urlPage = $urlPage . '?page=';
		}

		setVariable('listData', $listData);
		setVariable('limit', $limit);

		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function addSupplier($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlPlugins;
	global $contactSite;
	global $smtpSite;

	if (checkAdminLogin()) {
		$modelSupplier = new Supplier();
		$save= array();
		if(!empty($_GET['id'])){
			$save = $modelSupplier->getSupplier($_GET['id']);
		}

		if ($isRequestPost) {
			$dataSend = arrayMap($input['request']->data);
			$name=trim($dataSend['name']);
			$email=trim($dataSend['email']);
			$address=trim($dataSend['address']);
			

			if (empty($_GET['id']) && $modelSupplier->isExistUser($dataSend['code'])) {
				$mess = 'Mã nhà cung cấp đã tồn tại!';
				setVariable('mess', $mess);
			} else {
				if(empty($_GET['id'])){
					$save['Supplier']['code'] = $dataSend['code'];
					$save['Supplier']['slug']['code'] = createSlugMantan(trim($dataSend['code']));

				}

				$save['Supplier']['slug']['name'] = @createSlugMantan($name);
				$save['Supplier']['slug']['email'] = @createSlugMantan($email);
				$save['Supplier']['slug']['address'] = @createSlugMantan($address);
				$save['Supplier']['name'] = $dataSend['name'];
				$save['Supplier']['email'] = $dataSend['email'];
				$save['Supplier']['phone'] = $dataSend['phone'];
				$save['Supplier']['address'] = $dataSend['address'];
				$save['Supplier']['status'] =  $dataSend['status'];
				$save['Supplier']['desc'] =  $dataSend['desc'];

				if ($modelSupplier->save($save)) {
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
					if (empty($_GET['id'])) {
						$saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới NCC có mã là: '.$save['Supplier']['code'];
					}
					else
					{
						$saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa NCC có mã là: '.$save['Supplier']['code'];
					}
                    $modelLog->save($saveLog);
					$modelSupplier->redirect($urlPlugins . 'admin/kiosk-admin-supplier-listSupplier.php?stt=1');
				} else {
					$modelSupplier->redirect($urlPlugins . 'admin/kiosk-admin-supplier-addSupplier.php?stt=-1');
				}
			}
		}

		setVariable('data', $save);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function updateStatusSupplier($input) {
	global $modelOption;
	global $urlHomes;
	global $urlPlugins;

	if (checkAdminLogin()) {
		$modelSupplier = new Supplier();
		if (isset($_GET['id']) && isset($_GET['status'])) {
			$save['$set']['status'] = $_GET['status'];
			$dk= array('_id'=>new MongoId($_GET['id']));
			$supplier= $modelSupplier->getSupplier($_GET['id']);
			$modelSupplier->updateALL($save,$dk);
			$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thay đổi trạng thái NCC có mã là: '.$supplier['Supplier']['code'];
                    $modelLog->save($saveLog);
		}
		$modelSupplier->redirect($urlPlugins . 'admin/kiosk-admin-supplier-listSupplier.php?stt=4');
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function listCategory($input)
{
	global $modelOption;
	global $urlHomes;

	if(checkAdminLogin()){
		$listData= $modelOption->getOption('listCategoryProduct');

		setVariable('listData',$listData);
	}else{
		$modelOption->redirect($urlHomes);
	}
}

function saveCategory($input)
{
	global $modelOption;
	global $urlPlugins;
	global $urlHomes;

	if(checkAdminLogin()){
		$dataSend= $input['request']->data;
		$name= $dataSend['name'];
		$type= $dataSend['type'];
		$slug = createSlugMantan($dataSend['name']);

		if($name!='' && $type=='save')
		{
			$listData= $modelOption->getOption('listCategoryProduct');

			if($dataSend['idCat']!='')
			{
				
				if (empty($listData['Option']['value']['allData'][ $dataSend['idCat'] ])) {
					$listData['Option']['value']['tData'] = (isset($dataSend['idCat']))?$dataSend['idCat']:'';
				$listData['Option']['value']['allData'][ $dataSend['idCat'] ]= array( 'id'=>$dataSend['idCat'], 'name'=>$name,'slug'=>$slug );
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới ngành hàng có mã là: '.$dataSend['idCat'];
                    $modelLog->save($saveLog);
                    $modelOption->saveOption('listCategoryProduct',$listData['Option']['value']);
			$modelOption->redirect($urlPlugins.'admin/kiosk-admin-category-listCategory.php?mess=1');
				}
				elseif(!empty($listData['Option']['value']['allData'][ $dataSend['idCat'] ])&&!empty($dataSend['type2']))
				{
					$listData['Option']['value']['tData'] = (isset($dataSend['idCat']))?$dataSend['idCat']:'';
				$listData['Option']['value']['allData'][ $dataSend['idCat'] ]= array( 'id'=>$dataSend['idCat'], 'name'=>$name,'slug'=>$slug );
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa ngành hàng có mã là: '.$dataSend['idCat'];
                    $modelLog->save($saveLog);
                    $modelOption->saveOption('listCategoryProduct',$listData['Option']['value']);
			$modelOption->redirect($urlPlugins.'admin/kiosk-admin-category-listCategory.php?mess=2');
				}
				else
				{
					$modelOption->redirect($urlPlugins.'admin/kiosk-admin-category-listCategory.php?mess=-3');
				}
				
			}

			

		}else{
			$modelOption->redirect($urlPlugins.'admin/kiosk-admin-category-listCategory.php');
		}
		//  if($type=='delete')
		// {	
		// 	$modelProduct= new Product();
		// $prod= $modelProduct->find('all',array('conditions'=>array('idCategory'=>$dataSend['id'])));
		// pr($prod);
		// // if (empty($prod)) {
		// // 	$idDelete= $dataSend['id'];
		// // 	$listData= $modelOption->getOption('listCategoryProduct');
		// // 	unset($listData['Option']['value']['allData'][$idDelete]);
		// // 	$modelOption->saveOption('listCategoryProduct',$listData['Option']['value']);
		// // }
		// // else
		// // {
		// 	$modelOption->redirect($urlPlugins.'admin/kiosk-admin-category-listCategory.php?mess=-2');			
		// // }
		// }

	}else{
		$modelOption->redirect($urlHomes);
	}
}
function deleteCategory($input)
{
	global $modelOption;
	global $urlPlugins;
	global $urlHomes;

	if(checkAdminLogin()){
			$modelProduct= new Product();
		$prod= $modelProduct->find('first',array('conditions'=>array('idCategory'=>$_GET['id'],'lock'=>0)));
		if (empty($prod)) {
		$idDelete= $_GET['id'];
		$listData= $modelOption->getOption('listCategoryProduct');
		$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa ngành hàng có mã là: '.$_GET['id'];
                    $modelLog->save($saveLog);
		unset($listData['Option']['value']['allData'][$idDelete]);
		$modelOption->saveOption('listCategoryProduct',$listData['Option']['value']);
			$modelOption->redirect($urlPlugins.'admin/kiosk-admin-category-listCategory.php');			
		}
		else
		{
			$modelOption->redirect($urlPlugins.'admin/kiosk-admin-category-listCategory.php?mess=-2');			
		}
		

	}else{
		$modelOption->redirect($urlHomes);
	}
}

function listChannel($input)
{
	global $modelOption;
	global $urlHomes;

	if(checkAdminLogin()){
		$listData= $modelOption->getOption('listChannelProduct');

		setVariable('listData',$listData);
	}else{
		$modelOption->redirect($urlHomes);
	}
}

function saveChannel($input)
{
	global $modelOption;
	global $urlPlugins;
	global $urlHomes;

	if(checkAdminLogin()){
		$dataSend= $input['request']->data;
		$name= $dataSend['name'];
		$type= $dataSend['type'];
		$slug = createSlugMantan($dataSend['name']);

		if($name!='' && $type=='save')
		{
			$listData= $modelOption->getOption('listChannelProduct');

			if($dataSend['id']=='')
			{
				$listData['Option']['value']['tData'] = (isset($listData['Option']['value']['tData']))?$listData['Option']['value']['tData']+1:1;
				$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=>(int)$listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug );
				$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới kênh bán hàng có tên là: '.$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]['name'];
                    $modelLog->save($saveLog);
			}
			else
			{
				$idClassEdit= (int) $dataSend['id'];
				$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
				$listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
				$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa kênh bán hàng có tên là: '.$listData['Option']['value']['allData'][$idClassEdit]['name'];
                    $modelLog->save($saveLog);
			}

			$modelOption->saveOption('listChannelProduct',$listData['Option']['value']);

		}
		else if($type=='delete')
		{
			$idDelete= (int) $dataSend['id'];
			$listData= $modelOption->getOption('listChannelProduct');
			$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa kênh bán hàng có tên là: '.$listData['Option']['value']['allData'][$idDelete]['name'];
                    $modelLog->save($saveLog);
			unset($listData['Option']['value']['allData'][$idDelete]);
			$modelOption->saveOption('listChannelProduct',$listData['Option']['value']);
		}

		if($dataSend['redirect']>0)
		{
			$modelOption->redirect($urlPlugins.'admin/kiosk-admin-channel-listChannel.php');
		}
	}else{
		$modelOption->redirect($urlHomes);
	}
}

function listLog($input) {
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	if (checkAdminLogin()) {
		$modelLog = new Log();
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		$order = array('created'=>'DESC');

		$listData = $modelLog->getPage($page, $limit, $conditions, $order);

		$totalData = $modelLog->find('count', array('conditions' => $conditions));

		$balance = $totalData % $limit;
		$totalPage = ($totalData - $balance) / $limit;
		if ($balance > 0)
			$totalPage+=1;

		$back = $page - 1;
		$next = $page + 1;
		if ($back <= 0)
			$back = 1;
		if ($next >= $totalPage)
			$next = $totalPage;

		if (isset($_GET['page'])) {
			$urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
			$urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
		} else {
			$urlPage = $urlNow;
		}
		if (strpos($urlPage, '?') !== false) {
			if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
				$urlPage = $urlPage . '&page=';
			} else {
				$urlPage = $urlPage . 'page=';
			}
		} else {
			$urlPage = $urlPage . '?page=';
		}

		setVariable('listData', $listData);
		setVariable('limit', $limit);
		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}
}
function addPatnerAdmin($input){
	global $modelOption;
	global $urlHomes;
	global $urlNow;
	global $isRequestPost;
	global $modelOption;
	global $urlPlugins;
	$modelPatner= new Patner();
	if (checkAdminLogin()) {
		$listChannel=$modelOption->getOption('listChannelProduct');
		$listCityKiosk = $modelOption->getOption('cityKiosk');
		setVariable('listChannel',$listChannel);
		setVariable('listCityKiosk',$listCityKiosk);
		if(!empty($_GET['idEdit'])){
			$dataEdit=$modelPatner->getPatner($_GET['idEdit']);
			setVariable('dataEdit',$dataEdit);
		}
		if($isRequestPost){
			$dataSend =arrayMap( $input['request']->data);

			$name=trim($dataSend['name']);
			$idChannel=$dataSend['idChannel'];
			$location=trim($dataSend['location']);
			$note=$dataSend['note'];
			$code=isset($dataSend['code'])?$dataSend['code']:'';
			$dateStartConfig= $dataSend['dateStartConfig'];
			$dateStart= $dataSend['dateStart'];
			$dateContract= $dataSend['dateContract'];
			$phone= $dataSend['phone'];
			$email= $dataSend['email'];
			$dateStartRun= $dataSend['dateStartRun'];
			$developmentStaff= $dataSend['developmentStaff'];
			$salesStaff= $dataSend['salesStaff'];
			$managementAgency=(int)$dataSend['managementAgency'];
			$rentalChannel= $dataSend['rentalChannel'];
			$salesChannel= $dataSend['salesChannel'];
			$area=(int)$dataSend['area'];
			$idCity=(int)$dataSend['idCity'];
			$idDistrict= (int)$dataSend['idDistrict'];
			$wards= $dataSend['wards'];
			$numberHouse= $dataSend['numberHouse'];
			$reason= isset($dataSend['reason'])?$dataSend['reason']:'';

			if(!empty($dataSend['id'])){
				$save['Patner']['name']=$name;
				$save['Patner']['idChannel']=(int)$idChannel;
				$save['Patner']['location']=$location;
				$save['Patner']['note']=$note;
				$save['Patner']['code']=$code;
				$save['Patner']['dateStartConfig']=$dateStartConfig;
				$save['Patner']['dateStart']=$dateStart;
				$save['Patner']['dateContract']=$dateContract;
				$save['Patner']['phone']=$phone;
				$save['Patner']['email']=$email;
				$save['Patner']['dateStartRun']=$dateStartRun;
				$save['Patner']['developmentStaff']=$developmentStaff;
				$save['Patner']['salesStaff']=$salesStaff;
				$save['Patner']['managementAgency']=$managementAgency;
				$save['Patner']['rentalChannel']=$rentalChannel;
				$save['Patner']['salesChannel']=$salesChannel;
				$save['Patner']['area']=$area;
				$save['Patner']['idCity']=$idCity;
				$save['Patner']['idDistrict']=$idDistrict;
				$save['Patner']['wards']=$wards;
				$save['Patner']['numberHouse']=$numberHouse;
				// $save['Patner']['reason']=$reason;
				$save['Patner']['slug']['name']=createSlugMantan($name);
				$save['Patner']['slug']['developmentStaff']=createSlugMantan($developmentStaff);
				$save['Patner']['slug']['location']=createSlugMantan($location);
				$save['Patner']['slug']['code']=createSlugMantan($code);
				$save['Patner']['slug']['phone']=createSlugMantan($phone);
				$save['Patner']['slug']['email']=createSlugMantan($email);
				$save['Patner']['slug']['salesStaff']=createSlugMantan($salesStaff);
				$save['Patner']['slug']['managementAgency']=createSlugMantan($managementAgency);
				$save['Patner']['slug']['rentalChannel']=createSlugMantan($rentalChannel);
				$save['Patner']['slug']['salesChannel']=createSlugMantan($salesChannel);
				$save['Patner']['slug']['area']=createSlugMantan($area);
				$save['Patner']['slug']['wards']=createSlugMantan($wards);
				$save['Patner']['slug']['numberHouse']=createSlugMantan($numberHouse);
				$dk= array('_id'=>new mongoId($dataSend['id']));
				// if ($reason!=null) {
				// 	$saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa thông tin NCC điểm đặt: '.$save['Patner']['name'].', ID là '.$dataSend['id'].'.Với lý do:'.$dataSend['reason'];
				// }
				if($modelPatner->updateAll($save['Patner'],$dk)){
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa NCC điểm đặt có mã là: '.$code.' Lý do sửa: '.$dataSend['reason'];
                    $modelLog->save($saveLog);
					$modelPatner->redirect($urlPlugins.'admin/kiosk-admin-patner-listPatnerAdmin.php?stt=1');
				}else{
					$modelPatner->redirect($urlPlugins.'admin/kiosk-admin-patner-addPatnerAdmin.php?idEdit='.$dataSend['id'].'&stt=-1');
				}

			}else{
				$save=array(
					'name'=>$name,
					'idChannel'=>(int)$idChannel,
					'location'=>$location,
					'note'=>$note,
					'code'=>$code,
					'dateStartConfig'=>$dateStartConfig,
					'dateStart'=>$dateStart,
					'dateContract'=>$dateContract,
					'phone'=>$phone,
					'email'=>$email,
					'dateStartRun'=>$dateStartRun,
					'developmentStaff'=>$developmentStaff,
					'salesStaff'=>$salesStaff,
					'managementAgency'=>$managementAgency,
					'rentalChannel'=>$rentalChannel,
					'salesChannel'=>$salesChannel,
					'area'=>$area,
					'idCity'=>$idCity,
					'idDistrict'=>$idDistrict,
					'wards'=>$wards,
					'numberHouse'=>$numberHouse,

				);
				$modelPatner->create();
				if($modelPatner->save($save)){
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới NCC điểm đặt có mã là: '.$code;
                    $modelLog->save($saveLog);
					$modelPatner->redirect($urlPlugins.'admin/kiosk-admin-patner-listPatnerAdmin.php?stt=1');
				}else{
					$modelPatner->redirect($urlPlugins.'admin/kiosk-admin-patner-addPatnerAdmin.php?stt=-1');
				}

			}
		}
	}
}
function deletePatnerAdmin(){
	$modelPatner= new Patner();
	global $urlPlugins;
	if(checkAdminLogin()){
		$idDelete = new mongoId($_GET['idPatner']);
		$modelPlace = new Place();
		$partner = $modelPatner->getPatner($_GET['idPatner']);
		$place = $modelPlace->find('first', array('conditions'=>array('idPatner'=>$_GET['idPatner'],'lock'=>0)));
		if (empty($place)) {
		$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa NCC điểm đặt có mã là: '.$partner['Patner']['code'];
                    $modelLog->save($saveLog);
		$modelPatner->delete($idDelete);
		$modelPatner->redirect($urlPlugins . 'admin/kiosk-admin-patner-listPatnerAdmin.php?mess=2');
	}
	else{
		$modelPatner->redirect($urlPlugins . 'admin/kiosk-admin-patner-listPatnerAdmin.php?mess=-2');

	}
	}
}
function listPatnerAdmin(){
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	if (checkAdminLogin()) {
		$modelPatner= new Patner();
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		$order = array();
		$fields=array('code','name');
		if(!empty($_GET['code'])){
			$code=trim($_GET['code']);
			$conditions['slug.code']=array('$regex' => createSlugMantan($code));
		}
		if(!empty($_GET['name'])){
			$name=trim($_GET['name']);
			$conditions['slug.name']=array('$regex' => createSlugMantan($name));
		}
		if(!empty($_GET['dateStartConfig'])){
			$dateStartConfig=trim($_GET['dateStartConfig']);
			$conditions['dateStartConfig']=array('$regex' => $dateStartConfig);
		}
		if(!empty($_GET['dateStart'])){
			$dateStart=trim($_GET['dateStart']);
			$conditions['dateStart']=array('$regex' => $dateStart);
		}
		if(!empty($_GET['dateContract'])){
			$dateContract=trim($_GET['dateContract']);
			$conditions['dateContract']=array('$regex' => $dateContract);
		}
		if(!empty($_GET['phone'])){
			$phone=trim($_GET['phone']);
			$conditions['slug.phone']=array('$regex' => createSlugMantan($phone));
		}
		if(!empty($_GET['email'])){
			$email=trim($_GET['email']);
			$conditions['slug.email']=array('$regex' => createSlugMantan($email));
		}
		if(!empty($_GET['dateStartRun'])){
			$dateStartRun=trim($_GET['dateStartRun']);
			$conditions['dateStartRun']=array('$regex' => $dateStartRun);
		}
		if(!empty($_GET['developmentStaff'])){
			$developmentStaff=trim($_GET['developmentStaff']);
			$conditions['slug.developmentStaff']=array('$regex' => createSlugMantan($developmentStaff));
		}
		if(!empty($_GET['salesStaff'])){
			$salesStaff=trim($_GET['salesStaff']);
			$conditions['slug.salesStaff']=array('$regex' => createSlugMantan($salesStaff));
		}
		if(!empty($_GET['idChanel'])){
			$idChanel=trim($_GET['idChanel']);
			$conditions['idChannel']=(int) $idChanel;
		}
		if(!empty($_GET['managementAgency'])){
			$managementAgency=trim($_GET['managementAgency']);
			$conditions['managementAgency']=(int) $managementAgency;
		}
		if(!empty($_GET['area'])){
			$area=trim($_GET['area']);
			$conditions['area']=(int) $area;
		}
		if(!empty($_GET['idCity'])){
			$idCity=trim($_GET['idCity']);
			$conditions['idCity']=(int) $idCity;
		}
		if(!empty($_GET['idDistrict'])){
			$idDistrict=trim($_GET['idDistrict']);
			$conditions['idDistrict']=(int) $idDistrict;
		}
		if(!empty($_GET['rentalChannel'])){
			$rentalChannel=trim($_GET['rentalChannel']);
			$conditions['slug.rentalChannel']=array('$regex' => createSlugMantan($rentalChannel));
		}
		if(!empty($_GET['salesChannel'])){
			$salesChannel=trim($_GET['salesChannel']);
			$conditions['slug.salesChannel']=array('$regex' => createSlugMantan($salesChannel));
		}
		if(!empty($_GET['location'])){
			$location=trim($_GET['location']);
			$conditions['slug.location']=array('$regex' => createSlugMantan($location));
		}
		if(!empty($_GET['wards'])){
			$wards=trim($_GET['wards']);
			$conditions['slug.wards']=array('$regex' => createSlugMantan($wards));
		}
		if(!empty($_GET['numberHouse'])){
			$numberHouse=trim($_GET['numberHouse']);
			$conditions['slug.numberHouse']=array('$regex' => createSlugMantan($numberHouse));
		}
		$listData = $modelPatner->getPage($page, $limit, $conditions, $order,$fields);

		$totalData = $modelPatner->find('count', array('conditions' => $conditions));

		$balance = $totalData % $limit;
		$totalPage = ($totalData - $balance) / $limit;
		if ($balance > 0)
			$totalPage+=1;

		$back = $page - 1;
		$next = $page + 1;
		if ($back <= 0)
			$back = 1;
		if ($next >= $totalPage)
			$next = $totalPage;

		if (isset($_GET['page'])) {
			$urlNow = str_replace("?mess=-2", "", $urlNow);
			$urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
			$urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
		} else {
			$urlPage = $urlNow;
		}
		if (strpos($urlPage, '?') !== false) {
			if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
				$urlPage = $urlPage . '&page=';
			} else {
				$urlPage = $urlPage . 'page=';
			}
		} else {
			$urlPage = $urlPage . '?page=';
		}

		if(!empty($_POST['inport'])){
          $table = array(
            array('label' => __('STT'), 'width' => 5),
            array('label' => __('Tên NCC điểm đặt'), 'width' => 20),
            array('label' => __('Mã NCC điểm đặt'), 'width' => 20),
          );
		$listDataExcel = $modelPatner->getPage($page, $limit, $conditions, $order,$fields);
          $modelPatner = new Patner();
          $data= array();
          $stt=0;
          if(!empty($listDataExcel)){
            foreach ($listDataExcel as $key => $value) {
              $stt++;
              
              $data[]= array( $stt,
                @$value['Patner']['name'],
                @$value['Patner']['code'],
              );
            }
          }
          $exportsController = new ExportsController();
        //$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
          $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-NCC-diem-dat')));
        }

		setVariable('listData', $listData);
		setVariable('limit', $limit);

		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}
}
// danh mục lỗi
function listCategoryError($input){
	global $modelOption;
	global $urlPlugins;
	global $urlHomes;
	global $isRequestPost;
	global $urlPlugins;
	if(checkAdminLogin()){
		$listData= $modelOption->getOption('listCategoryError');

		if(!empty($_GET['idEdit'])){
			$dataEdit= $listData['Option']['value']['allData'][$_GET['idEdit']];
			setVariable('dataEdit',$dataEdit);
		}
		if($isRequestPost){
			$dataSend= $input['request']->data;
			$name= $dataSend['name'];
			$slug = createSlugMantan($dataSend['name']);
			if($dataSend['id']==''){
				$listData['Option']['value']['tData'] = (isset($listData['Option']['value']['tData']))?$listData['Option']['value']['tData']+1:1;
				$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=>(int)$listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug );
				$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới nhóm lỗi có tên là: '.$name;
                    $modelLog->save($saveLog);
			}else{
				$idClassEdit= (int) $dataSend['id'];
				$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
				$listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
				$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa nhóm lỗi có tên là: '.$name;
                    $modelLog->save($saveLog);

			}
			$modelOption->saveOption('listCategoryError',$listData['Option']['value']);
			$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-error-listCategoryError.php?status=1');

		}
		setVariable('listData',$listData);

	}
	else{
		$modelOption->redirect($urlHomes);
	}
}
function deleteCategoryError(){
	global $urlPlugins;
	global $modelOption;
	if(checkAdminLogin()){
		$idDelete= (int)$_GET['id'];
		$listData= $modelOption->getOption('listCategoryError');
		$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa nhóm lỗi có tên là: '.$listData['Option']['value']['allData'][$idDelete]['name'];
                    $modelLog->save($saveLog);
		unset($listData['Option']['value']['allData'][$idDelete]);
		$modelOption->saveOption('listCategoryError',$listData['Option']['value']);
		$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-error-listCategoryError.php?status=1');
	}
}
function listErrorAdmin(){
	$modelErrormachine = new Errormachine;
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	if (checkAdminLogin()) {
		$category=$modelOption->getOption('listCategoryError');
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		$order = array();
		if(!empty($_GET['name'])){
			$name=createSlugMantan(trim($_GET['name']));
			$conditions['slug.name']= array('$regex' => $name);
		}
		if(!empty($_GET['code'])){
			$code=createSlugMantan(trim($_GET['code']));
			$conditions['slug.code']= array('$regex' => $code);
		}
		if(!empty($_GET['evaluate'])){
			$evaluate=createSlugMantan(trim($_GET['evaluate']));
			$conditions['slug.evaluate']= array('$regex' => $evaluate);
		}
		if(!empty($_GET['category'])){
			$cat=(int)($_GET['category']);
			$conditions['errorCat']= $cat;
		}
		$listData = $modelErrormachine->getPage($page, $limit, $conditions, $order);

		$totalData = $modelErrormachine->find('count', array('conditions' => $conditions));

		$balance = $totalData % $limit;
		$totalPage = ($totalData - $balance) / $limit;
		if ($balance > 0)
			$totalPage+=1;

		$back = $page - 1;
		$next = $page + 1;
		if ($back <= 0)
			$back = 1;
		if ($next >= $totalPage)
			$next = $totalPage;

		if (isset($_GET['page'])) {
			$urlNow = str_replace("?mess=-2", "", $urlNow);
			$urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
			$urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
		} else {
			$urlPage = $urlNow;
		}
		if (strpos($urlPage, '?') !== false) {
			if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
				$urlPage = $urlPage . '&page=';
			} else {
				$urlPage = $urlPage . 'page=';
			}
		} else {
			$urlPage = $urlPage . '?page=';
		}

		setVariable('listData', $listData);
		setVariable('category',$category);
		setVariable('page', $page);
		setVariable('limit', $limit);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}

}
function addErrorAdmin($input){
	global $isRequestPost;
	global $urlPlugins;
	global $modelOption;
	$modelErrormachine = new Errormachine ;
	if(checkAdminLogin()){
		$category=$modelOption->getOption('listCategoryError');
		if(!empty($_GET['idEdit'])){
			$dataEdit=$modelErrormachine->getErrorMachine($_GET['idEdit'],array());
			setVariable('dataEdit',$dataEdit);
		}
		setVariable('category',$category);
		if($isRequestPost){
			$dataSend =arrayMap( $input['request']->data);
			$name=$dataSend['name'];
			$code=trim($dataSend['code']);
			$errorCat=(int)$dataSend['errorCat'];
			$info=$dataSend['info'];
			$evaluate=$dataSend['evaluate'];
			if(!empty($dataSend['id'])){
				$save['Errormachine']['name']=$name;
				$save['Errormachine']['code']=$code;
				$save['Errormachine']['errorCat']=$errorCat;
				$save['Errormachine']['info']=$info;
				$save['Errormachine']['evaluate']=$evaluate;
				$save['Errormachine']['slug']['name']=createSlugMantan(trim($name));
				$save['Errormachine']['slug']['code']=createSlugMantan(trim($code));
				$save['Errormachine']['slug']['evaluate']=createSlugMantan(trim($evaluate));
				$dk= array('_id'=>new mongoId($dataSend['id']));
				if($modelErrormachine->updateALL($save['Errormachine'],$dk)){
					$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Sửa lỗi có mã là: '.$code;
                    $modelLog->save($saveLog);
					$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php?status=1');
				}else{
					$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php?status=-1');
				}

			}else{
				$save=array(
					'name'=>$name,
					'code'=>$code,
					'errorCat'=>$errorCat,
					'info'=>$info,
					'evaluate'=>$evaluate,
					'slug'=>array('name'=>createSlugMantan($name),'code'=>createSlugMantan($code),'evaluate'=>createSlugMantan($evaluate))
				);
				$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Thêm mới lỗi có mã là: '.$code;
                    $modelLog->save($saveLog);
				$modelErrormachine -> create();
				if($modelErrormachine->save($save)){
					$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php?status=1');
				}else{
					$modelOption->redirect($urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php?status=-1');
				}
			}
		}
	}
}
function deleteErrorMachineAdmin(){
	global $urlNow;
	global $modelOption;
	global $urlPlugins;
	$modelErrormachine = new Errormachine ;
	if(checkAdminLogin()){
		if(!empty($_GET['id'])){
			$idDelete = new mongoId($_GET['id']);
			$errorMachine = $modelErrormachine->getErrorMachine($_GET['id']);
			$modelLog = new Log();
						$saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= 'Quản trị viên '.$_SESSION['infoAdminLogin']['Admin']['user'].' Xóa lỗi có mã là: '.$errorMachine['Errormachine']['code'];
                    $modelLog->save($saveLog);
			$modelErrormachine->delete($idDelete);
			$modelErrormachine->redirect($urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php?cod=1');
		}else{
			$modelErrormachine->redirect($urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php?cod=-1');
		}
	}
}
?>