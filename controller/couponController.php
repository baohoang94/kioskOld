<?php
function listCoupon($input)
{
	global $urlHomes;
	global $isRequestPost;
	global $contactSite;
	global $urlNow;
	global $modelOption;
	global $metaTitleMantan;
	$metaTitleMantan= 'Danh sách mã coupon';

	$dataSend = $input['request']->data;
	$modelCoupon= new Coupon();

	$mess= '';
	$data= array();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listCoupon', $_SESSION['infoStaff']['Staff']['permission']))){
			$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
			if($page<1) $page=1;
			$limit= 15;
			$conditions = array('delete'=>'false');
			$order = array('expires'=>'ASC');
			// $fields= array('codeCoupon','dateStart','dateEnd','status','codeProduct','quantity','codeMachine','quantityActive');
			$fields= array();
			if(!empty($_GET['name'])){
				$name=trim($_GET['name']);
				$conditions['slug.name']= array('$regex' => createSlugMantan($name));
			}
			if(!empty($_GET['codeCoupon'])){
				$codeCoupon=trim($_GET['codeCoupon']);
				$conditions['slug.codeCoupon']= array('$regex' => createSlugMantan( $codeCoupon));
			}

			if(!empty($_GET['codeProduct'])){
				$codeProduct=trim($_GET['codeProduct']);
				$conditions['slug.codeProduct']= array('$regex' => createSlugMantan( $codeProduct));
			}

			if(!empty($_GET['codeMachine'])){
				$codeMachine=trim($_GET['codeMachine']);
				$conditions['slug.codeMachine']= array('$regex' => createSlugMantan($codeMachine));
			}

			if(!empty($_GET['dateStart'])){
				$date= explode('/', $_GET['dateStart']);
				$time= mktime(0,0,0,$date[1],$date[0],$date[2]);
				$conditions['dateStart.time']['$gte']= $time;
			}

			if(!empty($_GET['dateEnd'])){
				$date= explode('/', $_GET['dateEnd']);
				$time= mktime(23,59,59,$date[1],$date[0],$date[2]);
				$conditions['dateEnd.time']['$lte']= $time;
			}


			if(!empty($_GET['status'])){
				$conditions['status']= $_GET['status'];
			}
			if(!empty($_GET['idChannel'])){
				$conditions['idChannel']=(int) $_GET['idChannel'];
			}
			if(!empty($_GET['idPlace'])){
				$conditions['idPlace']= $_GET['idPlace'];
			}
			if(isset($_GET['quantity'])&&$_GET['quantity']!=null){
				$conditions['quantity']= (int)str_replace(array('.',',',' '),'',$_GET['quantity']);
			}
			if(isset($_GET['quantityActive'])&&$_GET['quantityActive']!=null){
				$conditions['quantityActive']= (int)$_GET['quantityActive'];
			}
			$listData= $modelCoupon->getPage($page, $limit , $conditions, $order, $fields );
			// pr($listData);die;

			$totalData= $modelCoupon->find('count',array('conditions' => $conditions));
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
			setVariable('listChannelProduct',$listChannelProduct);

			setVariable('listData',$listData);

			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
			setVariable('mess',$mess);
		}else{
			$modelCoupon->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelCoupon->redirect($urlHomes.'login?status=-2');
	}
}

function addCoupon($input)
{
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	global $listStatusCoupon;
	$metaTitleMantan= 'Thông tin mã Coupon';

	$modelCoupon= new Coupon();
	$modelLog= new Log();
	$modelStaff= new Staff();
	$modelProduct= new Product();
	$modelMachine= new Machine();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addCoupon', $_SESSION['infoStaff']['Staff']['permission']))){

			$mess= '';
			$data= array();
			if(!empty($_GET['id'])){
				$data= $modelCoupon->getCoupon($_GET['id']);
			}
			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			if ($isRequestPost) {
				$dataSend= arrayMap($input['request']->data);
				if(!empty(trim($dataSend['codeCoupon']))){
					$checkCode= $modelCoupon->getCouponCode($dataSend['codeCoupon'],array('codeCoupon'));

					if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Coupon']['id'] ) ){
						if(!empty($dataSend['codeProduct'])){
							$infoProduct= $modelProduct->getProductCode(trim($dataSend['codeProduct']),array('code'));
						}

						if(!empty($dataSend['codeMachine'])){
							$infoMachine= $modelMachine->getMachineCode(trim($dataSend['codeMachine']),array('code'));
						}

						$data['Coupon']['name']= $dataSend['name'];
						$data['Coupon']['codeCoupon']= $dataSend['codeCoupon'];
						$data['Coupon']['codeProduct']= $dataSend['codeProduct'];
						$data['Coupon']['quantity']= (int)str_replace(array('.',',',' '),'',$dataSend['quantity']);
						$data['Coupon']['codeMachine']= $dataSend['codeMachine'];
						$data['Coupon']['status']= $dataSend['status'];
						$data['Coupon']['value']= $dataSend['value'];
						$data['Coupon']['dateStart']['text']= $dataSend['dateStart'];
						$data['Coupon']['dateEnd']['text']= $dataSend['dateEnd'];
						$data['Coupon']['note']= $dataSend['note'];
						$data['Coupon']['delete']= 'false';
						//$data['Coupon']['dateTrading']= $dataSend['dateTrading'];
						$data['Coupon']['idChannel']= isset($dataSend['idChannel'])?(int)$dataSend['idChannel']:'';
						$data['Coupon']['idPlace']=  isset($dataSend['idPlace'])?$dataSend['idPlace']:'';
						$data['Coupon']['slug']['name']= createSlugMantan($dataSend['name']);
						$data['Coupon']['slug']['codeCoupon']= createSlugMantan($dataSend['codeCoupon']);
						$data['Coupon']['slug']['codeProduct']= createSlugMantan($dataSend['codeProduct']);
						$data['Coupon']['slug']['codeMachine']= createSlugMantan($dataSend['codeMachine']);
						$date= explode('/', $dataSend['dateStart']);
						$data['Coupon']['dateStart']['time']= mktime(0,0,0,$date[1],$date[0],$date[2]);
						$date= explode('/', $dataSend['dateEnd']);
						$data['Coupon']['dateEnd']['time']= mktime(23,59,59,$date[1],$date[0],$date[2]);
						if(empty($_GET['id'])){
							$data['Coupon']['quantityActive']= 0;
							$data['Coupon']['usedvalue']=0;
						}
						//đánh dấu hết hạn
						if($dataSend['status']=='lock'){
							$data['Coupon']['expires']=(int)1;

						}

						$data['Coupon']['idProduct']= (!empty($infoProduct['Product']['id']))?$infoProduct['Product']['id']:null;
						$data['Coupon']['idMachine']= (!empty($infoMachine['Machine']['id']))?$infoMachine['Machine']['id']:null;

						if($modelCoupon->save($data)){
							$mess= 'Lưu thành công';
							$id= '';
							if(empty($_GET['id'])){
								$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm mã Coupon mới: '.$dataSend['codeCoupon'];
							}else{
								if(!empty($dataSend['reason'])){
									$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa mã Coupon cũ: '.$dataSend['codeCoupon'].' Lý do sửa:'.$dataSend['reason'];
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
						$mess= 'Mã Coupon đã tồn tại';
					}
				}else{
					$mess= 'Bạn không được để trống mã Coupon';
				}
			}
			setVariable('mess',$mess);
			setVariable('data',$data);
			setVariable('listStatusCoupon',$listStatusCoupon);
			setVariable('listChannelProduct',$listChannelProduct);

		}else{
			$modelOption->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelOption->redirect($urlHomes.'login?status=-2');
	}
}
function infoCoupon($input)
{
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	global $listStatusCoupon;
	$metaTitleMantan= 'Thông tin mã Coupon';

	$modelCoupon= new Coupon();
	$modelLog= new Log();
	$modelStaff= new Staff();
	$modelProduct= new Product();
	$modelMachine= new Machine();

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoCoupon', $_SESSION['infoStaff']['Staff']['permission']))){

			$mess= '';
			$data= array();
			if(!empty($_GET['id'])){
				$data= $modelCoupon->getCoupon($_GET['id']);
			}
			$listChannelProduct= $modelOption->getOption('listChannelProduct');
			if ($isRequestPost) {
				$dataSend= arrayMap($input['request']->data);
				if(!empty(trim($dataSend['codeCoupon']))){
					$checkCode= $modelCoupon->getCouponCode($dataSend['codeCoupon'],array('codeCoupon'));

					if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Coupon']['id'] ) ){
						if(!empty($dataSend['codeProduct'])){
							$infoProduct= $modelProduct->getProductCode(trim($dataSend['codeProduct']),array('code'));
						}

						if(!empty($dataSend['codeMachine'])){
							$infoMachine= $modelMachine->getMachineCode(trim($dataSend['codeMachine']),array('code'));
						}

						$data['Coupon']['name']= $dataSend['name'];
						$data['Coupon']['codeCoupon']= $dataSend['codeCoupon'];
						$data['Coupon']['codeProduct']= $dataSend['codeProduct'];
						$data['Coupon']['quantity']= (int) $dataSend['quantity'];
						$data['Coupon']['codeMachine']= $dataSend['codeMachine'];
						$data['Coupon']['status']= $dataSend['status'];

						$data['Coupon']['dateStart']['text']= $dataSend['dateStart'];
						$data['Coupon']['dateEnd']['text']= $dataSend['dateEnd'];
						$data['Coupon']['note']= $dataSend['note'];
						$data['Coupon']['delete']= 'false';
						$data['Coupon']['dateTrading']= $dataSend['dateTrading'];
						$data['Coupon']['idChannel']= isset($dataSend['idChannel'])?(int)$dataSend['idChannel']:'';
						$data['Coupon']['idPlace']=  isset($dataSend['idPlace'])?$dataSend['idPlace']:'';
						$data['Coupon']['slug']['name']= createSlugMantan($dataSend['name']);
						$data['Coupon']['slug']['codeCoupon']= createSlugMantan($dataSend['codeCoupon']);
						$data['Coupon']['slug']['codeProduct']= createSlugMantan($dataSend['codeProduct']);
						$data['Coupon']['slug']['codeMachine']= createSlugMantan($dataSend['codeMachine']);
						$date= explode('/', $dataSend['dateStart']);
						$data['Coupon']['dateStart']['time']= mktime(0,0,0,$date[1],$date[0],$date[2]);
						$date= explode('/', $dataSend['dateEnd']);
						$data['Coupon']['dateEnd']['time']= mktime(23,59,59,$date[1],$date[0],$date[2]);
						if(empty($_GET['id'])){
							$data['Coupon']['quantityActive']= 0;
						}
						//đánh dấu hết hạn
						if($dataSend['status']=='lock'){
							$data['Coupon']['expires']=(int)1;

						}
						if($infoProduct){
							if($infoMachine){
								$data['Coupon']['idProduct']= $infoProduct['Product']['id'];
								$data['Coupon']['idMachine']= $infoMachine['Machine']['id'];

								if($modelCoupon->save($data)){
									$mess= 'Lưu thành công';
									$id= '';
									if(empty($_GET['id'])){
										$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm mã Coupon mới: '.$dataSend['codeCoupon'];
									}else{
										if(!empty($dataSend['reason'])){
											$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa mã Coupon cũ: '.$dataSend['codeCoupon'].' Lý do sửa:'.$dataSend['reason'];
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
								$mess= 'Mã máy không tồn tại';
							}
						}else{
							$mess= 'Mã sản phẩm không tồn tại';
						}
					}else{
						$mess= 'Mã Coupon đã tồn tại';
					}
				}else{
					$mess= 'Bạn không được để trống mã Coupon';
				}
			}
			setVariable('mess',$mess);
			setVariable('data',$data);
			setVariable('listStatusCoupon',$listStatusCoupon);
			setVariable('listChannelProduct',$listChannelProduct);

		}else{
			$modelOption->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelOption->redirect($urlHomes.'login?status=-2');
	}
}

function deleteCoupon($input)
{
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;
	global $metaTitleMantan;
	global $urlNow;
	$metaTitleMantan= 'Khóa mã Coupon';

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteCoupon', $_SESSION['infoStaff']['Staff']['permission']))){
			$dataSend= $input['request']->data;
			$mess= '';
			$modelCoupon= new Coupon();
			$modelLog= new Log();

			if(!empty($_GET['id'])){
				$data['$set']['delete']= 'true';
				$dk= array('_id'=>new MongoId($_GET['id']));
				$coupon= $modelCoupon->getCoupon($_GET['id']);
				if($modelCoupon->updateAll($data,$dk)){
                	// lưu lịch sử tạo sản phẩm
					$saveLog['Log']['time']= time();
					$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa mã Coupon: '.$coupon['Coupon']['codeCoupon'];
					$modelLog->save($saveLog);

					$modelOption->redirect($urlHomes.'listCoupon');
				}else{
					$modelOption->redirect($urlHomes.'listCoupon');
				}

			}else{
				$modelOption->redirect($urlHomes.'listCoupon');
			}
		}else{
			$modelOption->redirect($urlHomes.'dashboard');
		}
	}else{
		$modelOption->redirect($urlHomes.'login?status=-2');
	}
}
// --------------function uploadCoupon--------------
// * Ngay tao:
// * Ghi chú:
// * Mục đích: đọc file excel nhập mã coupon theo mẫu
// * Lịch sử sửa:
//
// --------------------------------------------------
function uploadCoupon($input){
	global $modelOption;
	global $urlHomes;


	$modelLog= new Log();
	$modelStaff= new Staff();
	$modelProduct= new Product();
	$modelMachine= new Machine();



		if(!empty($_SESSION['infoStaff'])){
			if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin')
			|| (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('uploadCoupon', $_SESSION['infoStaff']['Staff']['permission']))){

			if(!empty($_POST['submit'])){
			 require("PHPExcel/PHPExcel.php");
			 $file = $_FILES['file']['tmp_name'];
			 $name = $_FILES['file']['name'];
			 //  Tiến hành đọc file excel
			$inputFileType = PHPExcel_IOFactory::identify($file);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($file);

			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			//in ra xem có bao nhiêu dòng.
			//echo $highestRow;

			$highestColumn = $sheet->getHighestColumn();
			$TotalCol = PHPExcel_Cell::columnIndexFromString($highestColumn);



			for ($i = 5; $i <= $highestRow; $i++){ //bắt đầu đọc từ dòng thứ 5 theo cấu trúc file excel được soạn sẵn.
				$modelCoupon= new Coupon();
				$data=$modelCoupon->getCoupon(@$_GET['id']);
				$data['Coupon']['name']=$sheet->getCellByColumnAndRow(0, $i)->getFormattedValue();
				$data['Coupon']['codeCoupon']=$sheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
				if(!empty($data['Coupon']['codeCoupon'])){ //nếu cột mã coupon không trống thì tiếp tục đọc và gán giá trị của dòng đó.
								$data['Coupon']['codeProduct']=$sheet->getCellByColumnAndRow(2, $i)->getFormattedValue();
								$data['Coupon']['quantity']=$sheet->getCellByColumnAndRow(3, $i)->getFormattedValue();
								$data['Coupon']['codeMachine']=$sheet->getCellByColumnAndRow(4, $i)->getFormattedValue();
								$data['Coupon']['status']=$sheet->getCellByColumnAndRow(5, $i)->getFormattedValue();
								$data['Coupon']['value']= $sheet->getCellByColumnAndRow(10, $i)->getValue();

								$dateStart=$sheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
								$dateEnd=$sheet->getCellByColumnAndRow(7,$i)->getFormattedValue();

								$date1 = explode('/', $dateStart);
								$data['Coupon']['dateStart']['text']= $date1[1].'/'.$date1[0].'/'.$date1[2];
								$data['Coupon']['dateStart']['time']= mktime(0,0,0,$date1[0],$date1[1],$date1[2]);
								$date2 = explode('/', $dateEnd);
								$data['Coupon']['dateEnd']['text']=$date2[1].'/'.$date2[0].'/'.$date2[2];
								$data['Coupon']['dateEnd']['time']= mktime(23,59,59,$date2[0],$date2[1],$date2[2]);

								$data['Coupon']['note']= '';
								$data['Coupon']['delete']= 'false';

								$data['Coupon']['slug']['codeCoupon']= $sheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
								$data['Coupon']['slug']['codeProduct']= $sheet->getCellByColumnAndRow(2, $i)->getFormattedValue();
								$data['Coupon']['slug']['codeMachine']= $sheet->getCellByColumnAndRow(4, $i)->getFormattedValue();
								$data['Coupon']['idChannel'] =$sheet->getCellByColumnAndRow(8, $i)->getFormattedValue();
								$data['Coupon']['idPlace'] = $sheet->getCellByColumnAndRow(9, $i)->getFormattedValue();

								if(empty($_GET['id'])){
									$data['Coupon']['quantityActive']= 0;
									$data['Coupon']['usedvalue']= 0;
								}
								if($data['Coupon']['status']=='lock'){
									$data['Coupon']['expires']=(int)1;
								}
					}

								if(!empty($data['Coupon']['codeCoupon'])){
									$checkCode= $modelCoupon->getCouponCode($data['Coupon']['codeCoupon'],array('code'));
									if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Coupon']['id'] )){
										if(!empty($data['Coupon']['codeProduct'])){
											$infoProduct= $modelProduct->getProductCode(trim($data['Coupon']['codeProduct']),array('code'));
										}

										if(!empty($data['Coupon']['codeMachine'])){
											$infoMachine= $modelMachine->getMachineCode(trim($data['Coupon']['codeMachine']),array('code'));
										}
										$data['Coupon']['idProduct']= (!empty($infoProduct['Product']['id']))?$infoProduct['Product']['id']:null;
										$data['Coupon']['idMachine']= (!empty($infoMachine['Machine']['id']))?$infoMachine['Machine']['id']:null;
										if($modelCoupon->save($data)){
											echo 'Lưu thành công<br>';
											$id= '';
											if(empty($_GET['id'])){
												$saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].'đã upload mã Coupon mới: ';
											}

											$saveLog['Log']['time']= time();
											$modelLog->save($saveLog);

											if(empty($_GET['id'])){
												$data= array();
											}
										}
										else{
											echo 'Lưu thất bại dòng thứ '.$i.'<br>';
										}
									}
									else{
										echo 'file up chứa dòng mã thứ '.$i.' bị trùng<br>';
									}
								}

				}

			}
		}
	}
}
?>
