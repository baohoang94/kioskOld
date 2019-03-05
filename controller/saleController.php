<?php
// --------------function saleController.php--------------
// * Ngày tạo: tháng 2 năm 2019
// * Người tạo: Báo
// * Mục đích: code của chức năng giảm giá theo % giá trị đơn hàng.
// * Ghi chú:
// * Lịch sử sửa:
//  + Lần sửa: 
//  + Ngay: 
//  + Người sửa: 
//  + Nội dung sửa:
//    -
// --------------------------------------------------
	function listSale()
	{
		global $urlHomes;
	    $listData='';
	    $modelMachine= new Machine;
	    $modelPlace = new Place;
	    $modelSale = new Sale;
		$metaTitleMantan= 'Quản lý các chương trình khuyến mại';
	    $listPlace=$modelPlace->find('all',array('conditions'=>array('lock'=>(int)0)));
    	$listMachine=$modelMachine->find('all',array('conditions'=>array('lock'=>(int)0)));
    	$listData=$conditionsSale = [];
    	if (!empty($_GET)) {
    		if (!empty($_GET['name'])) {
    			$conditionsSale['name'] = $_GET['name'];
    		}
    		if (!empty($_GET['dateStart'])) {
    			$conditionsSale['dateStart'] = convertMktime($_GET['dateStart'].' 00:00:00');
    		}
    		if (!empty($_GET['dateEnd'])) {
    			$conditionsSale['dateEnd'] = convertMktime($_GET['dateEnd'].' 23:59:59');
    		}
    		if (!empty($_GET['value'])) {
    			$conditionsSale['value'] = (int)$_GET['value'];
    		}
    		if (!empty($_GET['maxValue'])) {
    			$conditionsSale['maxValue'] = (int)str_replace(array('.',',',' '),'',$_GET['maxValue']);
    		}
    		if (isset($_GET['lock'])) {
    			$conditionsSale['lock'] = (int)$_GET['lock'];
    		}
    		if (!empty($_GET['area'])) {
    			$conditionsSale['area']['$in'] = $_GET['area'];
    		}
    		if (!empty($_GET['idCity'])) {
    			$conditionsSale['idCity']['$in'] = $_GET['idCity'];
    		}
    		if (!empty($_GET['idDistrict'])) {
    			$conditionsSale['idDistrict']['$in'] = $_GET['idDistrict'];
    		}
    		if (!empty($_GET['wards'])) {
    			$conditionsSale['wards']['$in'] = $_GET['wards'];
    		}
    		if (!empty($_GET['idChannel'])) {
    			$conditionsSale['idChannel']['$in'] = $_GET['idChannel'];
    		}
    		if (!empty($_GET['idPlace'])) {
    			$conditionsSale['idPlace']['$in'] = $_GET['idPlace'];
    		}
    		if (!empty($_GET['typedateEndPay'])) {
    			$conditionsSale['typedateEndPay']['$in'] = $_GET['typedateEndPay'];
    		}
    		if (!empty($_GET['codeMachine'])) {
    			$conditionsSale['codeMachine']['$in'] = $_GET['codeMachine'];
    		}
    		$listData=$modelSale->find('all', array('conditions'=>$conditionsSale));
    	}
    	setVariable('listPlace',$listPlace);
    	setVariable('listData',$listData);
    	setVariable('listMachine',$listMachine);
	}
	function addSale()
	{
		global $urlHomes;
	    $mess='';
	    $modelMachine= new Machine;
	    $modelPlace = new Place;
	    $modelSale = new Sale;

	    $listPlace=$modelPlace->find('all',array('conditions'=>array('lock'=>(int)0)));
    	$listMachine=$modelMachine->find('all',array('conditions'=>array('lock'=>(int)0)));

    	if (!empty($_POST)) {
    		// khởi tạo mảng các trường giá trị điều kiện cần kiểm tra (if it empty)
    		$conditionsCheck = [
    			'area' => '',
    			'idCity' => '',
    			'idDistrict' => '',
    			'wards' => '',
    			'idChannel' => '',
    			'idPlaces' => '',
    			'typedateEndPay' => '',
    			'codeMachine' => ''
    		];
    		if (!empty($_POST['name'])) {
    			$data['Sale']['name'] = h(trim($_POST['name']));
    		}
    		if (!empty($_POST['dateStart'])) {
    			$data['Sale']['dateStart'] = convertMktime($_POST['dateStart'].' 00:00:00');
    		}
    		if (!empty($_POST['dateEnd'])) {
    			$data['Sale']['dateEnd'] = convertMktime($_POST['dateEnd'].' 23:59:59');
    		}
    		if (!empty($_POST['value'])) {
    			$data['Sale']['value'] = (int)$_POST['value'];
    		}
    		$data['Sale']['maxValue'] = '';
    		if (!empty($_POST['maxValue'])) {
    			$data['Sale']['maxValue'] = (int)str_replace(array('.',',',' '),'',$_POST['maxValue']);
    		}
    		if (isset($_POST['lock'])) {
    			$data['Sale']['lock'] = (int)$_POST['lock'];
    		}
    		$data['Sale']['area'] = '';
    		if (!empty($_POST['area'])) {
    			$data['Sale']['area'] = $_POST['area'];
    			$conditionsCheck['area'] = $data['Sale']['area'];
    		}
    		$data['Sale']['idCity'] = '';
    		if (!empty($_POST['idCity'])) {
    			$data['Sale']['idCity'] = $_POST['idCity'];
    			$conditionsCheck['idCity'] = $data['Sale']['idCity'];
    		}
    		$data['Sale']['idDistrict'] = '';
    		if (!empty($_POST['idDistrict'])) {
    			$data['Sale']['idDistrict'] = $_POST['idDistrict'];
    			$conditionsCheck['idDistrict'] = $data['Sale']['idDistrict'];
    		}
    		$data['Sale']['wards'] = '';
    		if (!empty($_POST['wards'])) {
    			$data['Sale']['wards'] = $_POST['wards'];
    			$conditionsCheck['wards'] = $data['Sale']['wards'];
    		}
    		$data['Sale']['idChannel'] = '';
    		if (!empty($_POST['idChannel'])) {
    			$data['Sale']['idChannel'] = $_POST['idChannel'];
    			$conditionsCheck['idChannel'] = $data['Sale']['idChannel'];
    		}
    		$data['Sale']['idPlaced'] = '';
    		if (!empty($_POST['idPlace'])) {
    			$data['Sale']['idPlace'] = $_POST['idPlace'];
    			$conditionsCheck['idPlace'] = $data['Sale']['idPlace'];
    		}
    		$data['Sale']['typedateEndPay'] = '';
    		if (!empty($_POST['typedateEndPay'])) {
    			$data['Sale']['typedateEndPay'] = $_POST['typedateEndPay'];
    			$conditionsCheck['typedateEndPay'] = $data['Sale']['typedateEndPay'];
    		}
    		$data['Sale']['codeMachine'] = '';
    		if (!empty($_POST['codeMachine'])) {
    			$data['Sale']['codeMachine'] = $_POST['codeMachine'];
    			$conditionsCheck['codeMachine'] = $data['Sale']['codeMachine'];
    		}
    		if (!empty($_POST['note'])) {
    			$data['Sale']['note'] = $_POST['note'];
    		}
    		// Tìm bản ghi có ngày kết thúc lớn nhất
    		$dataCheck = $modelSale->find('first', array('conditions'=>$conditionsCheck, 'order'=>array('dateEnd'=>'DESC')));
    		// ngày bắt đầu phải lớn hơn ngày kết thúc của bản ghi đã có và ngày bắt đầu ko đc lớn hơn ngày kết thúc
    		if (!empty($dataCheck) && $data['Sale']['dateStart'] <= $dataCheck['Sale']['dateEnd'] || $data['Sale']['dateStart'] > $data['Sale']['dateEnd']) {
    			$mess = 'Thời gian không hợp lệ';
    		}
    		elseif ($modelSale->save($data)) {
    			$mess = 'Lưu thành công';
    		}
    	}
    	setVariable('mess',$mess);
    	setVariable('listPlace',$listPlace);
    	setVariable('listMachine',$listMachine);
	}
	function infoSale() {
		$modelMachine= new Machine;
	    $modelPlace = new Place;
		$modelSale = new Sale;
		$listPlace=$modelPlace->find('all',array('conditions'=>array('lock'=>(int)0)));
    	$listMachine=$modelMachine->find('all',array('conditions'=>array('lock'=>(int)0)));
		if (!empty($_GET['id'])) {
			$data = $modelSale->find('first', array('conditions'=>array('id'=>$_GET['id'])));
		}
		setVariable('data', $data);
		setVariable('listPlace',$listPlace);
    	setVariable('listMachine',$listMachine);
	}
	function editSale()
	{
		global $urlHomes;
	    $mess='';
	    $modelMachine= new Machine;
	    $modelPlace = new Place;
	    $modelSale = new Sale;

	    $listPlace=$modelPlace->find('all',array('conditions'=>array('lock'=>(int)0)));
    	$listMachine=$modelMachine->find('all',array('conditions'=>array('lock'=>(int)0)));
    	if (!empty($_GET['id'])) {
			$data = $modelSale->find('first', array('conditions'=>array('id'=>$_GET['id'])));
			if (!empty($_POST)) {
	    		$conditionsCheck = [];
	    		if (!empty($_POST['name'])) {
	    			$data['Sale']['name'] = h(trim($_POST['name']));
	    			// $conditionsCheck['name'] = $data['Sale']['name'];
	    		}
	    		if (!empty($_POST['dateStart'])) {
	    			$data['Sale']['dateStart'] = convertMktime($_POST['dateStart'].' 00:00:00');
	    			// $conditionsCheck['dateStart'] = $data['Sale']['dateStart'];
	    		}
	    		if (!empty($_POST['dateEnd'])) {
	    			$data['Sale']['dateEnd'] = convertMktime($_POST['dateEnd'].' 00:00:00');
	    			// $conditionsCheck['dateEnd'] = $data['Sale']['dateEnd'];
	    		}
	    		if (!empty($_POST['value'])) {
	    			$data['Sale']['value'] = (int)$_POST['value'];
	    			$conditionsCheck['value'] = $data['Sale']['value'];
	    		}
	    		if (!empty($_POST['maxValue'])) {
	    			$data['Sale']['maxValue'] = (int)str_replace(array('.',',',' '),'',$_POST['maxValue']);
	    			$conditionsCheck['maxValue'] = $data['Sale']['maxValue'];
	    		}
	    		if (isset($_POST['lock'])) {
	    			$data['Sale']['lock'] = (int)$_POST['lock'];
	    		}
	    		if (!empty($_POST['area'])) {
	    			$data['Sale']['area'] = $_POST['area'];
	    			$conditionsCheck['area'] = $data['Sale']['area'];
	    		}
	    		if (!empty($_POST['idCity'])) {
	    			$data['Sale']['idCity'] = $_POST['idCity'];
	    			$conditionsCheck['idCity'] = $data['Sale']['idCity'];
	    		}
	    		if (!empty($_POST['idDistrict'])) {
	    			$data['Sale']['idDistrict'] = $_POST['idDistrict'];
	    			$conditionsCheck['idDistrict'] = $data['Sale']['idDistrict'];
	    		}
	    		if (!empty($_POST['wards'])) {
	    			$data['Sale']['wards'] = $_POST['wards'];
	    			$conditionsCheck['wards'] = $data['Sale']['wards'];
	    		}
	    		if (!empty($_POST['idChannel'])) {
	    			$data['Sale']['idChannel'] = $_POST['idChannel'];
	    			$conditionsCheck['idChannel'] = $data['Sale']['idChannel'];
	    		}
	    		if (!empty($_POST['idPlace'])) {
	    			$data['Sale']['idPlace'] = $_POST['idPlace'];
	    			$conditionsCheck['idPlace'] = $data['Sale']['idPlace'];
	    		}
	    		if (!empty($_POST['typedateEndPay'])) {
	    			$data['Sale']['typedateEndPay'] = $_POST['typedateEndPay'];
	    			$conditionsCheck['typedateEndPay'] = $data['Sale']['typedateEndPay'];
	    		}
	    		if (!empty($_POST['codeMachine'])) {
	    			$data['Sale']['codeMachine'] = $_POST['codeMachine'];
	    			$conditionsCheck['codeMachine'] = $data['Sale']['codeMachine'];
	    		}
	    		if (!empty($_POST['note'])) {
	    			$data['Sale']['note'] = $_POST['note'];
	    		}
	    		if (!empty($_POST['reason'])) {
	    			$data['Sale']['reason'] = $_POST['reason'];
	    		}
	    		$conditionsCheck['id']['$ne'] = $_GET['id'];
	    		// Tìm bản ghi có ngày kết thúc lớn nhất
	    		$dataCheck = $modelSale->find('first', array('conditions'=>$conditionsCheck, 'order'=>array('dateEnd'=>'DESC')));
	    		// ngày bắt đầu phải lớn hơn ngày kết thúc của bản ghi đã có và ngày bắt đầu ko đc lớn hơn ngày kết thúc
	    		if (!empty($dataCheck) && $data['Sale']['dateStart'] <= $dataCheck['Sale']['dateEnd'] || $data['Sale']['dateStart'] > $data['Sale']['dateEnd']) {
	    			$mess = 'Thời gian không hợp lệ';
	    		}
	    		elseif ($modelSale->save($data)) {
	    			$mess = 'Sửa thành công';
	    		}
	    	}
		}
		setVariable('data', $data);
		setVariable('mess', $mess);
		setVariable('listPlace',$listPlace);
    	setVariable('listMachine',$listMachine);
	}
	function ajaxMachine()
	{
		$modelMachine= new Machine;
		if (!empty($_GET['idPlace'])) {
			$idPlaces = explode(',', $_GET['idPlace']);
			$codeMachines = '';
			foreach ($idPlaces as $value) {
				$listMachine = $modelMachine->find('all',array('conditions'=>array('idPlace'=>$value, 'lock'=>(int)0), 'fields'=>array('code', 'name')));
				if (!empty($listMachine)) {
					foreach ($listMachine as  $machines) {
						// $codeMachines .= $machines['Machine']['code'] . '<br>';
						$codeMachines .= '<input type="checkbox" name="codeMachine[]" value="'.$machines['Machine']['code'].'">'.$machines['Machine']['code'].' ('.$machines['Machine']['name'].')<br>';
					}
				}
			}
			echo $codeMachines;
		} else {
			echo 'empty idPlace';
		}
	}
	function deleteSale()
	{
		$modelSale = new Sale;
		global $urlHomes;
	    if(!empty($_GET['id'])){
	      $modelSale->deleteAll(array('id'=>$_GET['id']),true);
	    }
	    $modelSale->redirect($urlHomes.'listSale');
	}
?>