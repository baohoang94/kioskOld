<?php
function testEverything(){
  // global $modelOption;
      // $listCityKiosk=$modelOption->getOption('cityKiosk');
      // $i=0;
      
      // foreach ($listCityKiosk['Option']['value']['allData'][1] as $key => $city) {
          // $i++;
  
          // $cityData[$i]['name']=$city['name'];
          // $cityData[$i]['id']=$city['id'];
          // $cityData[$i]['district']=@$city['district'];
          // $j=0;
          // foreach($city['district'] as $key2=> $value){
          //   $j++;
          //   $district[$j]['name']= $value['name'];
          //   $district[$j]['id']=$value['id'];          
          // }
      // }

      // pr($cityData);
      // pr($city);
      // pr($district);

$a1=array("a"=>"red","b"=>"green","c"=>"blue");
// foreach ($a1 as $key => $value) {
//   $result[]= $key.'='.$value;
// }
// $stringSend= implode('&', $result);
$stringSend = http_build_query($a1);
// print_r($result);
print_r($stringSend);
$dataSend = arrayMap($a1);
$str1 = '<br>abc ';
$str2 = 'xyz';
// echo $str1 . $str2;
echo $str1 , $str2 , ' jkl' , ' mno'; // Nhanh hơn

  // ////////////////////////////////
  // global $urlNow;
  // $modelTransfer = new Transfer();
  // if(!empty($_GET)){ //bắt sự kiện ấn nút submit.
  //   $conditions = [];
  //   $fields = array('orderId', 'timeServer', 'codeProduct', 'quantity');
  //   if (!empty($_GET['dayTo'])) {
  //     $conditions['timeServer']['$gte'] = convertMktime($_GET['dayTo']);
  //   }
  //   if (!empty($_GET['dayForm'])) {
  //     $conditions['timeServer']['$lte'] = convertMktime($_GET['dayForm']);
  //   }
  //   if (!empty($_GET['area'])) {
  //     $conditions['area'] = $_GET['area'];
  //   }
  //   if (!empty($_GET['idCity'])) {
  //     $conditions['idCity'] = $_GET['idCity'];
  //   }
  //   if (!empty($_GET['idDistrict'])) {
  //     $conditions['idDistrict'] = $_GET['idDistrict'];
  //   }
  //   if (!empty($_GET['wards'])) {
  //     $conditions['wards'] = $_GET['wards'];
  //   }
	// 	$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
  //           if($page<1) $page=1;
  //           $limit= 15;
  //           $conditions = array('lock'=>0);
	// 	$fields= array('orderId','timeServer','codeProduct','quantity');
	// 	$listData= $modelTransfer->getPage($page, $limit , $conditions, $fields );
	// 	$totalData= $modelTransfer->find('count',array('conditions' => $conditions));
  //
	// 	$balance= $totalData%$limit;
	// 	$totalPage= ($totalData-$balance)/$limit;
	// 	if($balance>0)$totalPage+=1;
  //
	// 	$back=$page-1;$next=$page+1;
	// 	if($back<=0) $back=1;
	// 	if($next>=$totalPage) $next=$totalPage;
  //
	// 	if(isset($_GET['page'])){
	// 	    $urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
	// 	    $urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
	// 	}else{
	// 	    $urlPage= $urlNow;
	// 	}
  //
	// 	if(strpos($urlPage,'?')!== false){
	// 	    if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
	// 	        $urlPage= $urlPage.'&page=';
	// 	    }else{
	// 	        $urlPage= $urlPage.'page=';
	// 	    }
	// 	}else{
	// 	    $urlPage= $urlPage.'?page=';
	// 	}
  //
	// 	setVariable('listData',$listData);
	// 	setVariable('page',$page);
	// 	setVariable('totalPage',$totalPage);
	// 	setVariable('back',$back);
	// 	setVariable('next',$next);
	// 	setVariable('urlPage',$urlPage);
  //   setVariable('listData',$listData);
  //   }
if(isset($_POST['inport'])){
  // $modelProduct = new Product;
  // $mang=array((int)-1,(int)-2,(int)-3 );
  // if($modelProduct->deleteAll(array('quantity'=>array('$in'=>$mang)), true ) ) {
  //   echo 'Xóa thành công';
  //
  // }else{
  //   echo 'Xóa thất bại';
  // }
}

// foreach ($data as $key => $value) {
//
//   $tien=$tien+$data['moneyCalculate'];
//   //lần lặp 1:
//   //$tien = 0+ 12000.
//   //lan lap 2:
//   //$tien=12000.
//   //$tien =12000+ 5000.
//   //lan lap 3:
//   //$tien =17000
//   //$tien = 17000+....;
// }
// echo $tien;
}
//================================ TEST LINH TINH ============================
require("PHPExcel/PHPExcel.php");

    // //Đường dẫn file
    // $file = __DIR__ . '/app/Book1.xlsx';
    // echo $file;
    // //Tiến hành xác thực file
    // $objFile = PHPExcel_IOFactory::identify($file);
    // $objData = PHPExcel_IOFactory::createReader($objFile);

    // // Load dữ liệu sang dạng đối tượng
    // $objPHPExcel = $objData->load($file);

    // //Chọn trang cần truy xuất
    // $sheet = $objPHPExcel->setActiveSheetIndex(0);

    // //Lấy ra số dòng cuối cùng
    // $Totalrow = $sheet->getHighestRow();
    // //Lấy ra tên cột cuối cùng
    // $LastColumn = $sheet->getHighestColumn();

    // //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
    // $TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

    // //Tạo mảng chứa dữ liệu
    // $data = [];

    // //Tiến hành lặp qua từng ô dữ liệu
    // //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
    // // $modelCodeOrder= new codeOrder;
    // // $code=$modelCodeOrder->find('first');
    // // $code['codeOrder']['value']=$code['codeOrder']['value']+1;
    // // $modelCodeOrder->save($code['codeOrder']);
    // $testExcel= new testExcel();
    // for ($i = 2; $i <= $Totalrow; $i++){
    //     //----Lặp cột
    //     for ($j = 0; $j < $TotalCol; $j++){
    //         $data[$i-2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getFormattedValue();;
    //     }
    // }$testExcel->save($data);
 ?>
