<?php
function logout($input)
{
	global $urlHomes;
	$modelStaff= new Staff();

	session_destroy();
	$modelStaff->redirect($urlHomes);
}

function infoStaff($input)
{
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;
	global $metaTitleMantan;
	global $contactSite;
	global $smtpSite;
	$metaTitleMantan= 'Thông tin tài khoản';

	$modelStaff= new Staff();
	$listData = array();
	$dataSend= $input['request']->data;
	$mess= '';
	$today= getdate();

	if(empty($_SESSION['infoStaff'])){
		$modelStaff->redirect($urlHomes.'loginStaff');
	}else{
		$data= $modelStaff->getStaff($_SESSION['infoStaff']['Staff']['id']);

		if($isRequestPost){
			if($dataSend['typeSubmit']=='changeInfo'){
				if(!empty($dataSend['fullName']) && !empty($dataSend['email'])) {
					$data['Staff']['fullName']= $dataSend['fullName'];
					$data['Staff']['email']= $dataSend['email'];
					$data['Staff']['address']= $dataSend['address'];
					$data['Staff']['sex']= $dataSend['sex'];
					$data['Staff']['phone']= $dataSend['phone'];
					$data['Staff']['birthday']= $dataSend['birthday'];
					$data['Staff']['desc']= $dataSend['desc'];

					if($modelStaff->save($data)){
						$_SESSION['infoStaff']= $data;
						$mess= 'Lưu dữ liệu thành công';
					}else{
						$mess= 'Lưu dữ liệu thất bại';
					}

				}else{
					$mess= 'Nhập thiếu dữ liệu';
				}
			}elseif($dataSend['typeSubmit']=='changePass'){
				if(!empty($dataSend['passOld']) && !empty($dataSend['passNew']) && !empty($dataSend['passAgain'])) {

					if($data['Staff']['pass']==md5($dataSend['passOld'])){

					if($dataSend['passNew']==$dataSend['passAgain']){
						if($data['Staff']['pass']==md5($dataSend['passNew'])){
							$mess= 'Nhập mật khẩu mới không trùng với mật khẩu cũ';
						}else{
								$data['Staff']['pass']= md5($dataSend['passNew']);

								if($modelStaff->save($data)){
									$_SESSION['infoStaff']= $data;
									$mess= 'Lưu dữ liệu thành công';
									$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
						$to = array(trim($data['Staff']['email']));
						$cc = array();
						$bcc = array();
						$subject = '[' . $smtpSite['Option']['value']['show'] . '] Thay đổi mật khẩu thành công';


						$content = 'Xin chào '.$_SESSION['infoStaff']['Staff']['fullName'].'<br/>';
						$content.= '
						<br>Bạn đã thay đổi mật khẩu thành công</br>
						<br/>Thông tin đăng nhập của bạn là:<br/>
						Tên đăng nhập: '.$_SESSION['infoStaff']['Staff']['code'].'<br/>
						Mật khẩu: '.$dataSend['passNew'].'<br/>
						Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

						$modelStaff->sendMail($from, $to, $cc, $bcc, $subject, $content);
								}else{
									$mess= 'Lưu dữ liệu thất bại';
								}

						}

					}
					else
					{
						$mess= 'Xác nhận mật khẩu mới nhập chưa khớp';

					}
				}else{
						$mess= 'Nhập sai mật khẩu cũ';
					}
				}else{
					$mess= 'Nhập thiếu dữ liệu';
				}
			}
		}

		setVariable('mess',$mess);
		setVariable('data',$data);
	}
}

function login($input)
{
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;

	$modelStaff= new Staff();
	$modelMachine = new Machine();
	if(!empty($_SESSION['infoStaff'])){
		$modelStaff->redirect($urlHomes.'dashboard');
	}else{
		$mess= '';
		if(!empty($_GET['forgetPass'])){
			if($_GET['forgetPass']==1){
				$mess= "Lấy lại mật khẩu thành công";
			}
		}
		if($isRequestPost){
			$dataSend= $input['request']->data;

			if(!empty($dataSend['code']) && !empty($dataSend['pass'])){
				$userByFone  = $modelStaff->checkLogin($dataSend['code'],$dataSend['pass']);
				$listMachine = array();
				$listIdMachine = array();
				if($userByFone){
					$_SESSION['infoStaff']= $userByFone;
					$_SESSION['CheckAuthentication']= true;
					$_SESSION['urlBaseUpload']= '/app/webroot/upload/admin/staff/'.$userByFone['Staff']['code'].'/';
					if (!empty($userByFone['Staff']['type'])&&$userByFone['Staff']['type']=='admin') {
					$listMachine = $modelMachine->find('all',array('conditions'=>array('lock'=>0)));
					foreach ($listMachine as $key => $value) {
						$listIdMachine[] = $value['Machine']['id'];
					}
				}
				else
				{
					$listMachine = $modelMachine->find('all',array('conditions'=>array('lock'=>0,'idStaff'=>$_SESSION['infoStaff']['Staff']['id'])));
					foreach ($listMachine as $key => $value) {
						$listIdMachine[] = $value['Machine']['id'];
					}

				}
					$_SESSION['listIdMachine']= $listIdMachine;

					$modelStaff->redirect($urlHomes.'dashboard');
				}else{
					$mess= 'Sai mã nhân viên hoặc mật khẩu';
				}
			}else{
				$mess= 'Không được để trống mã nhân viên hoặc mật khẩu';
			}
		}

		setVariable('mess',$mess);
	}
}

function dashboard($input)
{
	global $urlHomes;
	global $metaTitleMantan;
	global $modelOption;
	global $metaTitleMantan;
	$metaTitleMantan= 'Trang chủ';

	$modelStaff= new Staff();
	if(!empty($_SESSION['infoStaff'])){

	}else{
        $modelStaff->redirect($urlHomes.'login?status=-2');
	}
}

function forgetPassStaff($input)
{
	$modelStaff= new Staff();
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;

	if($isRequestPost){
		$dataSend= $input['request']->data;
		$data= $modelStaff->getStaffByCode($dataSend['code']);
		if ($data!=null) {
			if ($data['Staff']['status']!='lock') {
		if($data['Staff']['email']){
			$data['Staff']['codeForgetPass']= rand(100000,999999);
			$modelStaff->save($data);

            // Gửi email thông báo
			$from=array($contactSite['Option']['value']['email']);
			$to=array($data['Staff']['email']);
			$cc=array();
			$bcc=array();
			$subject='[Kiosk] Mã cấp lại mật khẩu';
			$content= ' <p>Xin chào '.$data['Staff']['fullName'].' !</p>
			<br/>Thông tin đăng nhập của bạn là:<br/>
			Tên đăng nhập: '.$dataSend['code'].'<br/>
			Bạn vui lòng nhập mã sau để lấy lại mật khẩu: <b>'.$data['Staff']['codeForgetPass'].'</b><br>
			Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';


			$modelStaff->sendMail($from,$to,$cc,$bcc,$subject,$content);
		}

		$modelStaff->redirect($urlHomes.'forgetPassStaffProcess?code='.$dataSend['code']);
	}else
$modelStaff->redirect($urlHomes.'forgetPassStaff?mess=1');
}
	else
$modelStaff->redirect($urlHomes.'forgetPassStaff?mess=-1');
}
}

function forgetPassStaffProcess($input)
{
	$modelStaff= new Staff();
	global $contactSite;
	global $urlHomes;
	global $isRequestPost;
	$mess= '';

	if($isRequestPost){
		$dataSend= $input['request']->data;
		$data= $modelStaff->getStaffByCode($dataSend['code']);

		if($data['Staff']['email'] && isset($data['Staff']['codeForgetPass']) && $data['Staff']['codeForgetPass']==$dataSend['codeForgetPass']){

			$save['$set']['pass']= md5($dataSend['pass']);
			if (md5($dataSend['codeForgetPass'])!=md5($dataSend['pass'])) {
			$save['$unset']['codeForgetPass']= true;
			$dk= array('_id'=>new MongoId($data['Staff']['id']));
			if($modelStaff->updateAll($save,$dk)){
                // Gửi email thông báo
				$from=array($contactSite['Option']['value']['email']);
				$to=array($data['Staff']['email']);
				$cc=array();
				$bcc=array();
				$subject='[Kiosk] Lấy mật khẩu thành công';
				$content= ' <p>Xin chào '.$data['Staff']['fullName'].' !</p>
				<br/>Thông tin đăng nhập của bạn là:<br/>
				Tên đăng nhập: '.$dataSend['code'].'<br>
				Mật khẩu mới của bạn là: <b>'.$dataSend['pass'].'</b><br>
				Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a>';

				$modelStaff->sendMail($from,$to,$cc,$bcc,$subject,$content);
				$modelStaff->redirect($urlHomes.'login?forgetPass=1');
			}else{
				$mess= "Lưu thất bại";
			}
		}
		else
		{
			$mess= "Không nhập mật khẩu mới trùng với mã lấy lại mật khẩu";
		}
		}else{
			$mess= "Sai tài khoản hoặc sai mã xác nhận";
		}
	}

	setVariable('mess',$mess);
}
function listAllStaff(){
	global $urlHomes;
	global $isRequestPost;
	global $contactSite;
	global $urlNow;
	global $modelOption;
	global $metaTitleMantan;
	global $listArea;
	$modelStaff= new Staff();
	$modelBranch= new Branch;
	$modelPermission= new Permission;
	$modelCompany = new Company();
	$metaTitleMantan= 'Danh sách nhân viên';
	if(!empty($_SESSION['infoStaff'])){
if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listAllStaff', $_SESSION['infoStaff']['Staff']['permission']))){
			$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
			if($page<1) $page=1;
			$limit= 15;
			$conditions = array();
			$order = array('created'=>'DESC');
			$fields= array();
			$conditions['status']='active';
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
				$conditions['phone']=array('$regex' => $_GET['phone']);
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

			if(!empty($_GET['address'])){
				$conditions['address']=array('$regex' => createSlugMantan(trim($_GET['address'])));
			}

			if(!empty($_GET['idCompany'])){
				$conditions['idCompany']=$_GET['idCompany'];
			}
			if(!empty($_GET['idBranch'])){
				$conditions['idBranch']=$_GET['idBranch'];
			}
			if(!empty($_GET['idPermission'])){
				$conditions['idPermission']=$_GET['idPermission'];
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
			$listData= $modelStaff->getPage($page, $limit , $conditions, $order, $fields );
			$totalData= $modelStaff->find('count',array('conditions' => $conditions));
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;


			$listBranch = $modelBranch->find('all',array('conditions'=>array('status'=>'active')));
			$listCompany = $modelCompany->find('all',array('conditions'=>array('status'=>'active')));
			$listPermission = $modelPermission->find('all',array('conditions'=>array('status'=>'active')));
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

// xuất file excel.
				if(!empty($_POST['inport'])){
					if(!empty($listData)){
					$table = array(
						array('label' => __('STT'), 'width' => 5),
						array('label' => __('Mã nhân viên'),'width' => 17, 'filter' => true, 'wrap' => true),
						array('label' => __('Họ tên'), 'width' => 15, 'filter' => true, 'wrap' => true),
						array('label' => __('Ngày sinh'),'width' => 20, 'filter' => true, 'wrap' => true),
						array('label' => __('Email'), 'width' => 15, 'filter' => true),
						array('label' => __('Số điện thoại'), 'width' => 15, 'filter' => true),
						array('label' => __('Địa chỉ'), 'width' => 30, 'filter' => true),
						array('label' => __('Ngày thử việc'), 'width' => 15, 'filter' => true),
						array('label' => __('Ngày làm chính thức'), 'width' => 15, 'filter' => true),
						array('label' => __('Vị trí'), 'width' => 25, 'filter' => true),
						array('label' => __('Tên chi nhánh'), 'width' => 30, 'filter' => true),
						array('label' => __('Khối phòng ban'), 'width' => 30, 'filter' => true),
					);
					$data= array();

						foreach ($listData as $key => $value) {
							$stt= $key+1;
							$branch=$modelBranch->getBranch($value['Staff']['idBranch'],array('name'));
							$permission=$modelPermission->getPermission($value['Staff']['idPermission'],array('name'));
							$data[]= array( $stt,
								$value['Staff']['code'],
								$value['Staff']['fullname'],
								$value['Staff']['birthday'],
								$value['Staff']['email'],
								$value['Staff']['phone'],
								$value['Staff']['address'],
								$value['Staff']['dateTrial'],
								$value['Staff']['dateStart'],
								$value['Staff']['position'],
								$branch['Branch']['name'],
								$permission['Permission']['name'],
							);
						}


					$exportsController = new ExportsController();
				//$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
					$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-nhan-vien')));
				}// đóng if(!empty($listData)).
			}// đóng export excel.
			$listCityKiosk = $modelOption->getOption('cityKiosk');
			setVariable('listData',$listData);
			setVariable('listArea',$listArea);
			setVariable('listCompany',$listCompany);
			setVariable('listPermission',$listPermission);
			setVariable('listBranch',$listBranch);
			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
		}else{
			$modelStaff->redirect($urlHomes.'login?status=-2');
		}
	}else{
		$modelStaff->redirect($urlHomes.'login?status=-2');
	}
}

function viewStaff($input){
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $listArea;

    global $contactSite;
    global $smtpSite;
    $metaTitleMantan= 'Cài đặt tài khoản nhân viên';

    $modelPermission= new Permission();
    $modelLog= new Log();
    $modelBranch= new Branch();
    $modelStaff= new Staff();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoStaffCompany', $_SESSION['infoStaff']['Staff']['permission']))){
			$id=$input['request']->params['pass']['1'];

                if(!empty($id)){
                    $data= $modelStaff->getStaff($id);
                }
                $listCityKiosk = $modelOption->getOption('cityKiosk');



        setVariable('data',$data);
        setVariable('listCityKiosk',$listCityKiosk);
        setVariable('listArea',$listArea);
    }else{
        $modelOption->redirect($urlHomes.'dashboard');
    }
}else{
    $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function deleteStaffByGovernance()
{
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	global $urlNow;

	if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteStaffByGovernance', $_SESSION['infoStaff']['Staff']['permission']))){
			$mess= '';
			$modelPermission= new Permission();
			$modelLog= new Log();
			$modelBranch= new Branch();
			$modelStaff= new Staff();

			if(!empty($_GET['id'])){
				$staff=$modelStaff->getStaff($_GET['id']);
				$data['$set']['status']= 'lock';
				$dk= array('_id'=>new MongoId($_GET['id']));

				if($modelStaff->updateAll($data,$dk)){
					$saveLog['Log']['time']= time();
					$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa tài khoản nhân viên có mã: '.$staff['Staff']['code'];
					$modelLog->save($saveLog);
					if(!empty($staff['Staff']['idPermission'])){
						$savePermission['$inc']['numberStaff']= -1;
						$dkPermission= array('_id'=> new MongoId($staff['Staff']['idPermission']));
						$modelPermission->updateAll($savePermission,$dkPermission);
					}

					$modelOption->redirect($urlHomes.'listAllStaff');
				}else{
					$modelOption->redirect($urlHomes.'listAllStaff');
				}

			}else{
				$modelOption->redirect($urlHomes.'listCompany');
			}
		}else{
			$modelOption->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelOption->redirect($urlHomes.'login?status=-2');
	}
}
// sửa nhân viên trực tiếp
function informationStaff($input){
	global $urlHomes;
	global $isRequestPost;
	global $contactSite;
	global $urlNow;
	global $modelOption;
	global $metaTitleMantan;
	global $listArea;
	global $isRequestPost;
	$modelStaff= new Staff();
	$modelLog= new Log();
	$metaTitleMantan= 'Chi tiết nhân viên';
	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('informationStaff', $_SESSION['infoStaff']['Staff']['permission']))){
			$mess='';
			$listCityKiosk = $modelOption->getOption('cityKiosk');
			setVariable('listCityKiosk',$listCityKiosk);
			$id=$input['request']->params['pass']['1'];
			if(!empty($id)){
				$data=$modelStaff->getStaff($id,$fields=array() );
				if($isRequestPost){
					$dataSend=$input['request']->data;
					$data['Staff']['fullName']= $dataSend['fullName'];
                          $data['Staff']['sex']= $dataSend['sex'];
                          $data['Staff']['birthday']= $dataSend['birthday'];
                          $data['Staff']['email']= $dataSend['email'];
                          $data['Staff']['slug']['email']= createSlugMantan($dataSend['email']);
                          $data['Staff']['phone']= $dataSend['phone'];
                          $data['Staff']['area']= $dataSend['area'];
                          $data['Staff']['idCity']= $dataSend['idCity'];
                          $data['Staff']['idDistrict']= $dataSend['idDistrict'];
                          $data['Staff']['wards']= $dataSend['wards'];
                          $data['Staff']['slug']['wards']= createSlugMantan($dataSend['wards']);
                          $data['Staff']['slug']['address']= createSlugMantan($dataSend['address']);
                          $data['Staff']['address']= $dataSend['address'];
                          $data['Staff']['dateTrial']= $dataSend['dateTrial'];
                          $data['Staff']['dateStart']= $dataSend['dateStart'];
                          $data['Staff']['position']= $dataSend['position'];
                    $data['Staff']['slug']['position']= createSlugMantan($dataSend['position']);
                    $data['Staff']['slug']['directManager']= createSlugMantan($dataSend['directManager']);
                    $data['Staff']['slug']['indirectManager']= createSlugMantan($dataSend['indirectManager']);
                          $data['Staff']['directManager']= $dataSend['directManager'];
                          $data['Staff']['indirectManager']= $dataSend['indirectManager'];
                          $data['Staff']['desc']= $dataSend['desc'];

                          $data['Staff']['slug']['fullName']= createSlugMantan($dataSend['fullName']);

					$data['Staff']['slug']['fullName']= createSlugMantan($dataSend['fullName']);
					if($modelStaff->save($data)){
						$mess= 'Lưu thành công';
						if(!empty($dataSend['reason'])){
                                 $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa thông tin tài khoản nhân viên có tên: '.$dataSend['fullName'].', mã nhân viên: '.$data['Staff']['code'].' Lý do sửa: '.$dataSend['reason'];
						}
						$saveLog['Log']['time']= time();
						$modelLog->save($saveLog);

					}else{
						$mess= 'Lưu thất bại';
					}

				}
									setVariable('data',$data);

			}
			setVariable('mess',$mess);
            setVariable('listArea',$listArea);
		}else{
			$modelStaff->redirect($urlHomes.'login?status=-2');
		}
	}else{
		$modelStaff->redirect($urlHomes.'login?status=-2');
	}
}

	function addNewStaff(){

		global $urlHomes;
		global $contactSite;
    global $smtpSite;

		$modelOption= new Option;
		$modelBranch = new Branch;
		$modelPermission = new Permission;
		$modelStaff=new Staff;
		$modelCompany= new Company;
		$modelLog= new Log;
		if(!empty($_SESSION['infoStaff'])){
			if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('informationStaff', $_SESSION['infoStaff']['Staff']['permission']))){
						$listBranch= $modelBranch->find('all',array('conditions'=>array('status'=>'active'),'fields'=>'name'));
						$listPermission=$modelPermission->find('all',array('conditions'=>array('status'=>'active'),'fields'=>'name'));
						$listCityKiosk=$modelOption->getOption('cityKiosk');
						$listCompany=$modelCompany->find('all',array('conditions'=>array('status'=>'active'),'fields'=>'name'));
									if(!empty($_GET)){
														if(!empty($_GET['code'])){
																$checkCode= $modelStaff->getStaffByCode($_GET['code'],array('code'));
														}
														if(empty($checkCode)){

																if(empty($_GET['id'])){
																		$data['Staff']['status']= 'active';
																}

																$data['Staff']['fullName']= $_GET['fullName'];
																if(!empty($_GET['code'])){
																	$data['Staff']['code']= $_GET['code'];
																	$data['Staff']['slug']['code']= createSlugMantan(trim($_GET['code']));
															}

															$permission= $modelPermission->getPermission($_GET['idPermission'],array('permission'));

															$data['Staff']['idCompany']= $_GET['idCompany'];
															$data['Staff']['pass']= md5($_GET['password']);
															$data['Staff']['idBranch']= $_GET['idBranch'];
															$data['Staff']['idPermission']= $_GET['idPermission'];
															$data['Staff']['fullName']= $_GET['fullName'];
															$data['Staff']['sex']= $_GET['sex'];
															$data['Staff']['birthday']= $_GET['birthday'];
															$data['Staff']['email']= $_GET['email'];
															$data['Staff']['slug']['email']= createSlugMantan($_GET['email']);
															$data['Staff']['phone']= $_GET['phone'];
															$data['Staff']['area']= $_GET['area'];
															$data['Staff']['idCity']= $_GET['idCity'];
															$data['Staff']['idDistrict']= $_GET['idDistrict'];
															$data['Staff']['slug']['wards']= createSlugMantan($_GET['wards']);
															$data['Staff']['slug']['address']= createSlugMantan($_GET['address']);
															$data['Staff']['wards']= $_GET['wards'];
															$data['Staff']['address']= $_GET['address'];
															$data['Staff']['dateTrial']= $_GET['dateTrial'];
															$data['Staff']['dateStart']= $_GET['dateStart'];
															$data['Staff']['position']= $_GET['position'];
															$data['Staff']['slug']['position']= createSlugMantan($_GET['position']);
															$data['Staff']['slug']['directManager']= createSlugMantan($_GET['directManager']);
															$data['Staff']['slug']['indirectManager']= createSlugMantan($_GET['indirectManager']);
															$data['Staff']['directManager']= $_GET['directManager'];
															$data['Staff']['indirectManager']= $_GET['indirectManager'];
															$data['Staff']['desc']= $_GET['desc'];
															$data['Staff']['permission']= $permission['Permission']['permission'];
															$data['Staff']['slug']['fullName']= createSlugMantan($_GET['fullName']);

															if($modelStaff->save($data)){
																$mess= 'Lưu thành công';
																$id= '';
																				$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm mới tài khoản nhân viên có tên: '.$_GET['fullName'].', mã nhân viên: '.$_GET['code'];
																				$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
																				$to = array(trim($_GET['email']));
																				$cc = array();
																				$bcc = array();
																				$subject = '[' . $smtpSite['Option']['value']['show'] . '] Tài khoản của bạn đã được khởi tạo thành công';


																				$content = 'Xin chào '.$data['Staff']['fullName'].'<br/>';
																				$content.= '<br/>Thông tin đăng nhập của bạn là:<br/>
																				Tên đăng nhập: '.$data['Staff']['code'].'<br/>
																				Mật khẩu: '.$_GET['password'].'<br/>
																				Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

																				$modelStaff->sendMail($from, $to, $cc, $bcc, $subject, $content);


																 $saveLog['Log']['time']= time();
																 $modelLog->save($saveLog);
														}else{
																$mess= 'Lưu thất bại';
														}
													}// đóng if(!empty($checkcode)).
											else{
													$mess= 'Mã nhân viên đã tồn tại';
											}
									setVariable('mess',$mess);
								}// đóng if(!empty($_GET)).
						setVariable('listCompany',$listCompany);
						setVariable('listCityKiosk',$listCityKiosk);
						setVariable('listBranch',$listBranch);
						setVariable('listPermission',$listPermission);
					}
				}
			}

?>
