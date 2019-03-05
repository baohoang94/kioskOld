<?php
function listPlace($input)
{
	global $urlHomes;
	global $isRequestPost;
	global $contactSite;
	global $urlNow;
	global $modelOption;
	global $metaTitleMantan;
	global $listManagementAgency;
	global $listArea;
	$metaTitleMantan= 'Danh sách địa điểm';


	$dataSend = $input['request']->data;
	$modelPlace= new Place();
	$modelMachine= new Machine();
	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listPlace', $_SESSION['infoStaff']['Staff']['permission']))){
			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			$listCityKiosk = $modelOption->getOption('cityKiosk');

			$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
			if($page<1) $page=1;
			$limit= 15;
			$conditions = array('lock'=>0);
			$order = array('created'=>'DESC');
			$fields= array('name','numberHouse','wards','gps','dateStartConfig','idChannel','phone','idCity','idDistrict','managementAgency','idPatner','developmentStaff','code');
			if(!empty($_GET['name'])){
				$key= createSlugMantan($_GET['name']);
				$conditions['slug.name']= array('$regex' => $key);
			}
			if(!empty($_GET['idChannel'])){
				$conditions['idChannel']=$_GET['idChannel'];
			}
			
			if(!empty($_GET['developmentStaff'])){
				$key= createSlugMantan($_GET['developmentStaff']);
				$conditions['slug.developmentStaff']= array('$regex' => $key);
			}

			if(!empty($_GET['salesStaff'])){
				$key= createSlugMantan($_GET['salesStaff']);
				$conditions['slug.salesStaff']= array('$regex' => $key);
			}

			if(!empty($_GET['rentalChannel'])){
				$key= createSlugMantan($_GET['rentalChannel']);
				$conditions['slug.rentalChannel']= array('$regex' => $key);
			}

			if(!empty($_GET['salesChannel'])){
				$key= createSlugMantan($_GET['salesChannel']);
				$conditions['slug.salesChannel']= array('$regex' => $key);
			}

			if(!empty($_GET['wards'])){
				$key= createSlugMantan($_GET['wards']);
				$conditions['slug.wards']= array('$regex' => $key);
			}

			if(!empty($_GET['numberHouse'])){
				$key= createSlugMantan($_GET['numberHouse']);
				$conditions['slug.numberHouse']= array('$regex' => $key);
			}

			if(!empty($_GET['dateStartConfig'])){
				$conditions['dateStartConfig']= $_GET['dateStartConfig'];
			}

			if(!empty($_GET['dateContract'])){
				$conditions['dateContract']= $_GET['dateContract'];
			}

			if(!empty($_GET['dateStart'])){
				$conditions['dateStart']= $_GET['dateStart'];
			}

			if(!empty($_GET['phone'])){
				$conditions['phone']= array('$regex' =>  $_GET['phone']);
			}

			if(!empty($_GET['email'])){
				$conditions['slug.email']= array('$regex' =>  createSlugMantan($_GET['email']));
			}

			if(!empty($_GET['dateStartRun'])){
				$conditions['dateStartRun']= $_GET['dateStartRun'];
			}
			if(!empty($_GET['managementAgency'])){
				$conditions['managementAgency']=array('$regex' => $_GET['managementAgency']);
			}

			if(!empty($_GET['area'])){
				$conditions['area']= $_GET['area'];
			}

			if(!empty($_GET['idCity'])){
				$conditions['idCity']= array('$regex' =>  $_GET['idCity']);
			}

			if(!empty($_GET['idDistrict'])){
				$conditions['idDistrict']= array('$regex' =>  $_GET['idDistrict']);
			}
			if(!empty($_GET['code'])){
				$code=createSlugMantan(trim($_GET['code']));
				$conditions['$or'][0]['slug.code']= array('$regex' => $code);
				$conditions['$or'][1]['code']= array('$regex' => $code);
				//$conditions['code']=array('$regex' =>$code);
			}
			
			if(!empty($_GET['gps'])){
				$gps=trim($_GET['gps']);
				$conditions['gps']=array('$regex' =>$gps);
			}
			if(!empty($_GET['timeContract'])){
				$timeContract=trim($_GET['timeContract']);
				$conditions['timeContract']=array('$regex' =>$timeContract);
			}
			$listData= $modelPlace->getPage($page, $limit , $conditions, $order, $fields );

			$totalData= $modelPlace->find('count',array('conditions' => $conditions));
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;

			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;

			if(isset($_GET['page'])){
									$urlNow = str_replace("?mess=-2", "", $urlNow);
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
			if(!empty($_POST['inport'])){
          $table = array(
            array('label' => __('STT'), 'width' => 5),
            array('label' => __('Mã điểm đặt'), 'width' => 20),
            array('label' => __('Tên điểm đặt'), 'width' => 20),
            array('label' => __('Địa điểm'), 'width' => 20),
            array('label' => __('Kênh bán hàng'), 'width' => 20),
            array('label' => __('Tọa độ GPS'), 'width' => 20),
            array('label' => __('Ngày lắp đặt'), 'width' => 20),
            array('label' => __('Mã NCC điểm đặt'), 'width' => 20),
            array('label' => __('NCC điểm đặt'), 'width' => 20),
            array('label' => __('Nhân viên phụ trách'), 'width' => 20),

          );
          $modelPlace= new Place();
          $modelPatner = new Patner();
          $data= array();
          $stt=0;
          if(!empty($listData)){
            foreach ($listData as $key => $value) {
              $stt++;
              if(!empty($value['Place']['idPatner'])){
					$patner[$key]=$modelPatner->getPatner($value['Place']['idPatner']);
				}
              $id= $value['Machine']['id'];
              $place= $modelPlace->getPlace($id);
              $trangthai= $listStatusMachine[$data['Machine']['status']]['name'];
              $data[]= array( $stt,
                @$value['Place']['code'],
                @$value['Place']['name'],
                @$value['Place']['numberHouse'],
                @$listChannelProduct['Option']['value']['allData'][$value['Place']['idChannel']]['name'],
                @$value['Place']['gps'],
                @$value['Place']['dateStartConfig'],
                @$patner[$key]['Patner']['code'],
                @$patner[$key]['Patner']['name'],
                @$value['Place']['developmentStaff'],
              );
            }
          }
          $exportsController = new ExportsController();
        //$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
          $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-diem-dat')));
        }
			setVariable('listData',$listData);
			setVariable('listChannelProduct',$listChannelProduct);
			setVariable('listCityKiosk',$listCityKiosk);
			setVariable('listManagementAgency',$listManagementAgency);
			setVariable('listArea',$listArea);

			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
			setVariable('mess',$mess);
		}else{
			$modelPlace->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelPlace->redirect($urlHomes.'login?status=-2');
	}
}

// thêm sản phẩm mới
function addPlace($input)
{
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	$metaTitleMantan= 'Thông tin điểm đặt';

	$modelPlace= new Place();
	$modelSupplier = new Supplier();
	$modelLog= new Log();
	$modelMachine= new Machine();
	$modelPatner= new Patner();
	if(!empty($_SESSION['infoStaff'])){
if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addPlace', $_SESSION['infoStaff']['Staff']['permission']))){

			$mess= '';
			$data= array();
			if(!empty($_GET['id'])){
				$data= $modelPlace->getPlace($_GET['id']);
			}

			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			$listCityKiosk = $modelOption->getOption('cityKiosk');
			$listPatner=$modelPatner->find('all', array(
				'order' =>  array(),
				'conditions' => array(),
				'fields'=> array('name')
			));

			if ($isRequestPost) {
				$dataSend= arrayMap($input['request']->data);
				if(!empty($dataSend['codeMachine'])){
					$machine= $modelMachine->getMachineCode($dataSend['codeMachine'],array('code'));
				}
				if(!empty($dataSend['idPatner'])){
					$patner=$modelPatner->getPatner($dataSend['idPatner'],$fields=array('idChannel') );
				}
				if(!empty(trim($dataSend['name']))){
					if(empty($dataSend['codeMachine']) || !empty($machine)){

						$data['Place']['slug']['name']= createSlugMantan($dataSend['name']);
						$data['Place']['slug']['developmentStaff']= createSlugMantan($dataSend['developmentStaff']);

						$data['Place']['slug']['salesStaff']= createSlugMantan($dataSend['salesStaff']);
						$data['Place']['slug']['rentalChannel']= createSlugMantan($dataSend['rentalChannel']);
						$data['Place']['slug']['salesChannel']= createSlugMantan($dataSend['salesChannel']);
						$data['Place']['slug']['wards']= createSlugMantan($dataSend['wards']);
						$data['Place']['slug']['numberHouse']= createSlugMantan($dataSend['numberHouse']);
						$data['Place']['slug']['code']= createSlugMantan($dataSend['code']);
						$data['Place']['name']= trim($dataSend['name']);
						$data['Place']['code']= trim($dataSend['code']);
						$data['Place']['gps']= $dataSend['gps'];
						$data['Place']['dateStartConfig']= $dataSend['dateStartConfig'];
						$data['Place']['dateContract']= $dataSend['dateContract'];
						$data['Place']['timeContract']= $dataSend['timeContract'];
						$data['Place']['dateStart']= $dataSend['dateStart'];
						$data['Place']['phone']= $dataSend['phone'];
						$data['Place']['email']= $dataSend['email'];
						$data['Place']['slug']['email']= createSlugMantan($dataSend['email']);

						$data['Place']['dateStartRun']= $dataSend['dateStartRun'];
						$data['Place']['developmentStaff']= $dataSend['developmentStaff'];
						$data['Place']['salesStaff']= $dataSend['salesStaff'];
						$data['Place']['idChannel']= $dataSend['idChannel'];
						$data['Place']['idPatner']= $dataSend['idPatner'];
						$data['Place']['managementAgency']= $dataSend['managementAgency'];
						$data['Place']['rentalChannel']= $dataSend['rentalChannel'];
						$data['Place']['salesChannel']= $dataSend['salesChannel'];
						$data['Place']['area']= $dataSend['area'];
						$data['Place']['idCity']= $dataSend['idCity'];
						$data['Place']['idDistrict']= $dataSend['idDistrict'];
						$data['Place']['wards']= $dataSend['wards'];
						$data['Place']['numberHouse']= $dataSend['numberHouse'];
						$data['Place']['note']= $dataSend['note'];
						$data['Place']['lock']= 0;
						//$data['Place']['codeMachine']= $dataSend['codeMachine'];
						$data['Place']['idMachine']= (!empty($machine['Machine']['id']))?$machine['Machine']['id']:'';

						if($modelPlace->save($data)){
							$mess= 'Lưu thành công';
							$id= '';
							if(empty($_GET['id'])){
								$id= $modelPlace->getLastInsertId();
								$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm mới điểm đặt có mã: '.$dataSend['code'];
							}else{
								if(!empty($dataSend['reason'])){
									$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa mã điểm đặt: '.$dataSend['code'].' Lý do sửa: '.$dataSend['reason'];
								}
								
							}

							$saveLog['Log']['time']= time();
							$modelLog->save($saveLog);

							if(empty($_GET['id'])){
								$data= array();
							}
						}else{
							$mess= 'Lưu thất bại';
						}
					}else{
						$mess= 'Mã máy Kiosk không tồn tại';
					}   
				}else{
					$mess= 'Bạn không được để trống tên điểm đặt';
				}
			}   
			setVariable('listPatner',$listPatner);
			setVariable('mess',$mess);
			setVariable('data',$data);
			setVariable('listChannelProduct',$listChannelProduct);
			setVariable('listCityKiosk',$listCityKiosk);

		}else{
			$modelOption->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelOption->redirect($urlHomes.'login?status=-2');
	}
}

function deletePlace($input)
{
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	global $urlNow;
	$metaTitleMantan= 'Khóa điểm đặt';

	if(!empty($_SESSION['infoStaff'])){
if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deletePlace', $_SESSION['infoStaff']['Staff']['permission']))){
			$dataSend= $input['request']->data;
			$mess= '';
			$modelPlace= new Place();
			$modelLog= new Log();
			$modelMachine = new Machine();
			if(!empty($_GET['id'])){
				$data['$set']['lock']= 1;
				$dk= array('_id'=>new MongoId($_GET['id']));
				$place=$modelPlace->getPlace($_GET['id']);
				$machine= $modelMachine->find('first', array('conditions'=>array('idPlace'=>$_GET['id'],'lock'=>0)));
				if (empty($machine)) {
				if($modelPlace->updateAll($data,$dk)){
                	// lưu lịch sử tạo sản phẩm
					$saveLog['Log']['time']= time();
					$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa điểm đặt có mã: '.$place['Place']['code'];
					$modelLog->save($saveLog);

					$modelOption->redirect($urlHomes.'listPlace?status=deletePlaceDone');
				}else{
					$modelOption->redirect($urlHomes.'listPlace?status=deletePlaceFail');
				}
			}
			else
			{
				$modelOption->redirect($urlHomes.'listPlace?mess=-2');
			}

			}else{
				$modelOption->redirect($urlHomes.'listPlace');
			}
		}else{
			$modelOption->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelOption->redirect($urlHomes.'login?status=-2');
	}
}
function infoPlace(){
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	$metaTitleMantan= 'Thông tin điểm đặt';

	$modelPlace= new Place();
	$modelSupplier = new Supplier();
	$modelLog= new Log();
	$modelMachine= new Machine();
	$modelPatner= new Patner();
	if(!empty($_SESSION['infoStaff'])){
if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoPlace', $_SESSION['infoStaff']['Staff']['permission']))){

			$mess= '';
			$data= array();
			if(!empty($_GET['id'])){
				$data= $modelPlace->getPlace($_GET['id']);
				setVariable('data',$data);
			}
			$listCityKiosk = $modelOption->getOption('cityKiosk');
			setVariable('listCityKiosk',$listCityKiosk);
		}else{
			$modelOption->redirect($urlHomes.'login?status=-2');
		}
	}else{
		$modelOption->redirect($urlHomes.'login?status=-2');
	}
}
?>