<?php
  function priceManage()
  {
    global $urlNow;
    $mess='';
    $modelSupplier=new Supplier;
    $modelProduct= new Product;
    $listSupplier=$modelSupplier->find('all',array('conditions'=>array(),'fields'=>'name'));

    $conditions=array();
    //pr($listSupplier);
    $modelCoupon= new Coupon;
    $conditionsCoupon['slug.name']='112233';
    $coupon=$modelCoupon->find('all',array('conditions'=>$conditionsCoupon));
    // pr($coupon);
    $link=array();
    if (!empty($_GET)) {
      if(!empty($_GET['save']) && $_GET['save']='Thêm_Mới' &&empty($_GET['page'])){
      if (!empty($_GET['dateStart'])) {
        $data['Product']['dateStart'] = $_GET['dateStart'];
      }
      if (!empty($_GET['dateEnd'])) {
        $data['Product']['dateEnd'] = $_GET['dateEnd'];
      }
      if (!empty($_GET['name'])) {
        $data['Product']['name'] = $_GET['name'];
      }
      if (!empty($_GET['code'])) {
        $data['Product']['code'] = $_GET['code'];
      }
      // bao bì sửa tên
      if (!empty($_GET['specification'])) {
        $data['Product']['packageProduct'] = $_GET['specification'];
      }
      // dung tích
      if (!empty($_GET['weight'])) {
        $data['Product']['weightProduct'] = $_GET['weight'];
      }
      // số sp/thùng
      if (!empty($_GET['packing'])) {
        $data['Product']['quantity'] = $_GET['packing'];
      }
      // nhà cung cấp
      if (!empty($_GET['idSupplier'])) {
        $data['Product']['idSupplier'] = $_GET['idSupplier'];
      }
      // giá nhập / thùng có thuế
      if (!empty($_GET['priceInputPackingTax'])) {
        $data['Product']['pricePackingTax'] = $_GET['priceInputPackingTax'];
      }

      // thuế suất
      if (!empty($_GET['tax'])) {
        $data['Product']['tax'] = $_GET['tax'];
      }
      // chiết khấu trực tếp
      if (!empty($_GET['directDiscount'])) {
        $data['Product']['Discount'] = $_GET['directDiscount'];
      }
      // tổng chiết khấu trả sau
      if (!empty($_GET['totalPostpayDiscount'])) {
        $data['Product']['lateDiscount'] = $_GET['totalPostpayDiscount'];
      }
      // tổng doanh thu CCDV
      if (!empty($_GET['totalRevenue'])) {
        $data['Product']['totalRevenue'] = $_GET['totalRevenue'];
      }
      // tổng thu nhập khác
      if (!empty($_GET['totalOtherIncome'])) {
        $data['Product']['otherRevenue'] = $_GET['totalOtherIncome'];
      }

      // chi phí ban hang.
      if (!empty($_GET['insuranceCosts'])) {
        $data['Product']['sales'] = $_GET['insuranceCosts'];
      }
      // chi phí quản lý
      if (!empty($_GET['managementCosts'])) {
        $data['Product']['costManagement'] = $_GET['managementCosts'];
      }
      // chi phí lãi vay
      if (!empty($_GET['borrow'])) {
        $data['Product']['laivay'] = $_GET['borrow'];
      }



      if (!empty($_GET['priceInputPackingTax']) && !empty($_GET['packing'])) {
        $priceInputProductTax=$_GET['priceInputPackingTax']/$_GET['packing'];
        $data['Product']['priceProductTax'] =  $priceInputProductTax; // giá nhập / sp có thuế
        if(!empty($_GET['tax'])){
          $priceInputProductNoTax= $priceInputProductTax/(1+ $_GET['tax']/100);
          $data['Product']['priceProductNoTax']= $priceInputProductNoTax; //gia nhap san pham khong thue.
          if(!empty($_GET['directDiscount'])){ //chiet khau truc tiep.
            $sumDirectDiscount= $priceInputProductNoTax * $_GET['directDiscount'];
            $data['Product']['totalDiscount']= $sumDirectDiscount; //tong chieu khau truc tiep.
            $data['Product']['costProduct']= $priceInputProductNoTax-$sumDirectDiscount;//gia von mua.
          }
        }
      }
      // tỉnh thành
      if (!empty($_GET['idCity'])) {
        $idCity=$_GET['idCity'];
        $data['Product']['idCity']=$idCity;
        $modelTransport=new transport;
        $dataTransport=$modelTransport->find('first', array('conditions'=>array('idCity'=>$idCity)));
        if (!empty($_GET['packing'])) {
          // chi phí vận chuyển
          $costTransport=$dataTransport['transport']['priceTransport']/1.1/$_GET['packing'];
          $data['Product']['costTransport'] = $costTransport;
          if (!empty($priceInputProductNoTax) && !empty($sumDirectDiscount)
              && !empty($_GET['totalPostpayDiscount']) && !empty($_GET['totalRevenue'])
              && !empty($_GET['totalOtherIncome']) && !empty($costTransport)) {
                $capitalDiscount=$priceInputProductNoTax-$sumDirectDiscount-$_GET['totalPostpayDiscount']-
                $_GET['totalRevenue']-$_GET['totalOtherIncome']+$costTransport;
                $data['Product']['capitalDiscount']=$capitalDiscount;
                if (!empty($capitalDiscount) && !empty($_GET['insuranceCosts'])
                    && !empty($_GET['managementCosts']) && !empty($_GET['borrow'])) {
                  $data['Product']['priceEven']= $capitalDiscount +
                        $_GET['insuranceCosts'] + $_GET['managementCosts'] + $_GET['borrow'];
                }
          }
        }
      }
        if (!empty($data) && !empty($_GET['name']) && !empty($_GET['code'])
        && !empty($_GET['specification']) && !empty($_GET['weight'])
        && !empty($_GET['packing']) && !empty($_GET['idSupplier'])
        && !empty($_GET['priceInputPackingTax']) && !empty($_GET['idCity'])) {
          if (!empty($_GET['code'])) {
            $check= $modelProduct->find('first',array('conditions'=>array('code'=>$_GET['code'])));
            if(empty($check)){
              if ($modelProduct->save($data)) {
                $mess='Lưu thành công';
                } else {
                $mess='lƯU THẤT BẠI';
              }
            }else{
              $mess='Mã sản phẩm đã tồn tại';
            }
          }

        } else {
          $mess='Bạn cần nhập đủ thông tin tối thiểu';
        }
      }

      if(!empty($_GET['search']) && $_GET['search']='Tìm_kiếm'){
        $conditions = array();
        if (!empty($_GET['name'])) {
          $conditions['name'] = array('$regex' => $_GET['name']);
          // pr($conditions);
        }
        if (!empty($_GET['code'])) {
          $conditions['code'] = $_GET['code'];
        }
        // bao bì
        if (!empty($_GET['specification'])) {
          $conditions['packageProduct'] = $_GET['specification'];
        }
        // dung tích
        if (!empty($_GET['weight'])) {
          $conditions['weightProduct'] = $_GET['weight'];
        }
        // số sp/thùng
        if (!empty($_GET['packing'])) {
          $conditions['quantity'] = $_GET['packing'];
        }
        // nhà cung cấp
        if (!empty($_GET['idSupplier'])) {
          $conditions['idSupplier'] = $_GET['idSupplier'];
        }
        // giá nhập / thùng có thuế
        if (!empty($_GET['priceInputPackingTax'])) {
          $conditions['pricePackingTax'] = $_GET['priceInputPackingTax'];
        }

        // thuế suất
        if (!empty($_GET['tax'])) {
          $conditions['tax'] = $_GET['tax'];
        }
        // chiết khấu trực tếp
        if (!empty($_GET['directDiscount'])) {
          $conditions['Discount'] = $_GET['directDiscount'];
        }
        // tổng chiết khấu trả sau
        if (!empty($_GET['totalPostpayDiscount'])) {
          $conditions['lateDiscount'] = $_GET['totalPostpayDiscount'];
        }
        // tổng doanh thu CCDV
        if (!empty($_GET['totalRevenue'])) {
          $conditions['totalRevenue'] = $_GET['totalRevenue'];
        }
        // tổng thu nhập khác
        if (!empty($_GET['totalOtherIncome'])) {
          $conditions['otherRevenue'] = $_GET['totalOtherIncome'];
        }
        // GV mua
        // purchasePrice

        // chi phí han hang.
        if (!empty($_GET['insuranceCosts'])) {
          $conditions['sales'] = $_GET['insuranceCosts'];
        }
        // chi phí quản lý
        if (!empty($_GET['managementCosts'])) {
          $conditions['costManagement'] = $_GET['managementCosts'];
        }
        // chi phí lãi vay
        if (!empty($_GET['borrow'])) {
          $conditions['laivay'] = $_GET['borrow'];
        }
          // pr($conditions);
          // data của newProduct
          $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                  if($page<1) $page=1;
                  $limit= 15;
            $listNewProduct= $modelProduct->getPage($page, $limit , $conditions, $order= array('created' => 'desc'), $fields=array() );
        		$totalNewProduct= $modelProduct->find('count',array('conditions' => $conditions));
            $balance= $totalNewProduct%$limit;
        		$totalPage= ($totalNewProduct-$balance)/$limit;
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
        		} // hết data của newProduct
            setVariable('listNewProduct',$listNewProduct);
            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
      }// ket thuc if($_GET['search']).

    }//ket thuc $_GET.
    // xuất file
    if(!empty($_POST['inport'])){
      //$modelProduct= new Product;
      //$listDataProduct=array('1'=>'2');
      $listDataProduct= $modelProduct->find('all',array('conditions'=>array(),'limit'=>15));
      //pr($listDataProduct);
      //die();
      $table = array(
        array('label' => __('STT'), 'width' => 5),
        array('label' => __('Tên SP'),'width' => 17, 'filter' => true, 'wrap' => true),
        array('label' => __('Mã SP)'), 'width' => 15, 'filter' => true, 'wrap' => true),
        array('label' => __('Thuế suất'),'width' => 20, 'filter' => true, 'wrap' => true),
        array('label' => __('Giá nhập SP ko thuế'), 'width' => 15, 'filter' => true),
        array('label' => __('Mức chiết khấu trực tiếp'), 'width' => 15, 'filter' => true),
        array('label' => __('Tổng CK trực tiếp'), 'width' => 15, 'filter' => true),
        array('label' => __('Tổng CK trả sau'), 'width' => 15, 'filter' => true),
        array('label' => __('Tổng doanh thu CCDV'), 'width' => 15, 'filter' => true),
        array('label' => __('Tổng thu nhập khác'), 'width' => 15, 'filter' => true),
      );
      $data= array();
      if(!empty($listDataProduct)){
        //$stt=0;
        $count=count($listDataProduct);
        for($i=0;$i<$count;$i++){
          $tax='';
          if(!empty($listDataProduct[$i]['Product']['tax'])){
            $tax= $listDataProduct[$i]['Product']['tax'];
          }
        // foreach ($listData as $key => &$value) {
        //   $data[]= array( ++$stt,
        //     $value['Product']['name'],
        //     $value['Product']['code'],
        //     $value['Product']['tax'],
        //     $value['Product']['priceProductNoTax'],
        //     $value['Product']['Discount']
        //   );
        $data[]= array( $i+1,
            @$listDataProduct[$i]['Product']['name'],
            @$listDataProduct[$i]['Product']['code'],
            @$listDataProduct[$i]['Product']['tax'],
            @$listDataProduct[$i]['Product']['priceProductNoTax'],
            @$listDataProduct[$i]['Product']['Discount'],
            @$listDataProduct[$i]['Product']['totalDiscount'],
            @$listDataProduct[$i]['Product']['lateDiscount'],
            @$listDataProduct[$i]['Product']['totalRevenue'],
            @$listDataProduct[$i]['Product']['otherRevenue'],
          );
        }

      $exportsController = new ExportsController();
      $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'BC-quan-ly-gia-san-pham')));
    }
  } // hết xuất file
    // xuất file 2
    if(!empty($_POST['inport2'])){
      // include('reportPriceController.php');
      include('excelController.php');
    } // hết xuất file 2
    // xuất file theo máy
    if(!empty($_POST['inport3'])){
      include('excelMachineController.php');
    } // hết xuất file theo máy
    // xuất file theo kênh
    if(!empty($_POST['inport4'])){
      include('excelChannelController.php');
    } // hết xuất file theo kênh

    //pr($link);
    setVariable('link',$link); //hien thi bien cho view.
    setVariable('listSupplier',$listSupplier);


    setVariable('mess',$mess);
  }
  function ajaxtProduct() {
    $modelSellProduct= new Product;
    if (!empty($_GET['idSupplier'])) {
    $listDataProduct= $modelSellProduct->find('all',array('conditions'=>array('idSupplier'=>$_GET['idSupplier'])));
    $i=0;
    foreach ($listDataProduct as $key => &$value) {
      $i++;
        echo'
        <tr>
        <td class="text_table">'.$i.'</td>
        <td class="text_table">'.@$value['Product']['name'].'</td>
        <td class="text_table">'.@$value['Product']['code'].'</td>
        <td class="text_table">'.@$value['Product']['tax'].'</td>
        <td class="text_table">'.@$value['Product']['priceProductNoTax'].'</td>
        <td class="text_table">'.@$value['Product']['Discount'].'</td>
        <td class="text_table">'.@$value['Product']['totalDiscount'].'</td>
        <td class="text_table">'.@$value['Product']['lateDiscount'].'</td>
        <td class="text_table">'.@$value['Product']['totalRevenue'].'</td>
        <td class="text_table">'.@$value['Product']['otherRevenue'].'</td>
        <td><a class="btn btn-default btn-primary" href="/viewManage?id='.$value['Product']['id'].'">Xem</a> <a class="btn btn-default btn-warning" href="/editManage?id='.$value['Product']['id'].'">Sửa</a> <a class="btn btn-default btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deleteNewProduct?id='.$value['Product']['id'].'">Xóa</a>
        </td>
        </tr>
        ';
    } 
    }
  }
function priceTransport(){
  global $modelOption;
  $modelTransport = new transport;
  $transportData = array();
  $listData = $modelTransport->find('all',array('fields'=>array('idCity','priceTransport','nameCity')));
  //pr($listData);
  $dataOptions=$modelOption->getOption('cityKiosk');
  //pr($dataOptions);
  $mess='';
  if (!empty($_GET)) {
    if (!empty($_GET['idCity']) && $_GET['idCity']!='all') {
      $transportData['transport']['idCity']=$_GET['idCity'];
      $transportData['transport']['nameCity']=$dataOptions['Option']['value']['allData'][$_GET['idCity']]['name'];//lưu ý cách gán này.

    }
    if (!empty($_GET['priceTransport'])) {
      $transportData['transport']['priceTransport']=$_GET['priceTransport'];
      if ( $_GET['idCity']=='all') {
        $dataTransport=$modelTransport->find('all',array('fields'=>'id'));
        //pr($dataTransport);
        foreach ($dataTransport as $key => $value) {
          $transport=$modelTransport->find('first',array('conditions'=>array('id'=>$value['transport']['id'])));
          // pr($transport);
          $modelTransport2 = new transport;
          $transport['transport']['priceTransport']=$_GET['priceTransport'];
          if ($modelTransport2->save($transport)) {
            $mess= 'Lưu thành công';
          } else {
            $mess= 'Lưu thất bại';
          }
        }
        //die();
      }
    }

    if(!empty($transportData) && $_GET['idCity']!='all'){
      //pr($transportData);
      $check= $modelTransport->find('all',array('conditions'=>array('idCity'=>$_GET['idCity'])));
      if(empty($check)){
        if($modelTransport->save($transportData)){
          $mess= 'Lưu thành công';
        }else{
          $mess= 'Lưu thất bại';
        }
      }else{
        $mess='Đơn giá vận chuyển của tỉnh/thành phố này đã tồn tại';
      }
    }
  }
  setVariable('mess',$mess);
  setVariable('listData',$listData);
}
  function deleteTransport(){
    global $urlHomes;
    $modelTransport= new transport;

    if(!empty($_GET['id'])){
      $modelTransport->deleteAll(array('id'=>$_GET['id']),true);
    }
    $modelTransport->redirect($urlHomes.'priceTransport');
  }
  function deleteNewProduct(){
    global $urlHomes;
    $modelProduct= new Product;

    if(!empty($_GET['id'])){
      $modelProduct->deleteAll(array('id'=>$_GET['id']),true);
    }
    $modelProduct->redirect($urlHomes.'priceManage');
  }
  function editTransport(){
    global $urlHomes;
    $datas=array();
    $modelTransport= new transport;
    if(!empty($_GET['idCity'])){
      if (!empty($_GET['priceTransportEdit'])) {
        $datas=$modelTransport->find('first', array('conditions'=>array('idCity'=>$_GET['idCity'])));
        $datas['transport']['priceTransport']=$_GET['priceTransportEdit'];
        if($modelTransport->save($datas)){
          $modelTransport->redirect($urlHomes.'priceTransport');
        }
      }
    }

  }
  // Hàm quản sửa sản phẩm
  function editManage() {
    global $urlHomes;
    $listData = array();
    $modelProduct= new Product;
    $modelSupplier=new Supplier;
    $mess='';
    $listSupplier=$modelSupplier->find('all',array('conditions'=>array(),'fields'=>'name'));

    if (!empty($_GET['id'])) {
      $listData=$modelProduct->find('first', array('conditions'=>array('id'=>$_GET['id'])));

    }

    // lưu
    if(!empty($_POST)){
      // pr($data);die();
      if (!empty($_POST['dateStart'])) {
        $listData['Product']['dateStart'] = $_POST['dateStart'];
      }
      if (!empty($_POST['dateEnd'])) {
        $listData['Product']['dateEnd'] = $_POST['dateEnd'];
      }
      // if (!empty($_POST['name'])) {
      //   $listData['Product']['name'] = $_POST['name'];
      // }
      // if (!empty($_POST['code'])) {
      //   $listData['Product']['code'] = $_POST['code'];
      // }
      // bao bì
      if (!empty($_POST['specification'])) {
        $listData['Product']['packageProduct'] = $_POST['specification'];
      }
      // dung tích
      if (!empty($_POST['weight'])) {
        $listData['Product']['weightProduct'] = $_POST['weight'];
      }
      // số sp/thùng
      if (!empty($_POST['packing'])) {
        $listData['Product']['quantity'] = $_POST['packing'];
      }
      // nhà cung cấp
      // if (!empty($_POST['idSupplier'])) {
      //   $listData['Product']['idSupplier'] = $_POST['idSupplier'];
      // }
      // giá nhập / thùng có thuế
      if (!empty($_POST['priceInputPackingTax'])) {
        $listData['Product']['pricePackingTax'] = $_POST['priceInputPackingTax'];
      }

      // thuế suất
      if (!empty($_POST['tax'])) {
        $listData['Product']['tax'] = $_POST['tax'];
      }
      // chiết khấu trực tếp
      if (!empty($_POST['directDiscount'])) {
        $listData['Product']['Discount'] = $_POST['directDiscount'];
      }
      // tổng chiết khấu trả sau
      if (!empty($_POST['totalPostpayDiscount'])) {
        $listData['Product']['lateDiscount'] = $_POST['totalPostpayDiscount'];
      }
      // tổng doanh thu CCDV
      if (!empty($_POST['totalRevenue'])) {
        $listData['Product']['totalRevenue'] = $_POST['totalRevenue'];
      }
      // tổng thu nhập khác
      if (!empty($_POST['totalOtherIncome'])) {
        $listData['Product']['otherRevenue'] = $_POST['totalOtherIncome'];
      }
      // GV mua
      // purchasePrice

      // chi phí han hang.
      if (!empty($_POST['insuranceCosts'])) {
        $listData['Product']['sales'] = $_POST['insuranceCosts'];
      }
      // chi phí quản lý
      if (!empty($_POST['managementCosts'])) {
        $listData['Product']['costManagement'] = $_POST['managementCosts'];
      }
      // chi phí lãi vay
      if (!empty($_POST['borrow'])) {
        $listData['Product']['laivay'] = $_POST['borrow'];
      }



      if (!empty($_POST['priceInputPackingTax']) && !empty($_POST['packing'])) {
        $priceInputProductTax=$_POST['priceInputPackingTax']/$_POST['packing'];
        $listData['Product']['priceProductTax'] =  $priceInputProductTax; // giá nhập / sp có thuế
        if(!empty($_POST['tax'])){
          $priceInputProductNoTax= $priceInputProductTax/(1+ $_POST['tax']/100);
          $listData['Product']['priceProductNoTax']= $priceInputProductNoTax; //gia nhap san pham khong thue.
          if(!empty($_POST['directDiscount'])){ //chiet khau truc tiep.
            $sumDirectDiscount= $priceInputProductNoTax * $_POST['directDiscount'];
            $listData['Product']['totalDiscount']= $sumDirectDiscount; //tong chieu khau truc tiep.
            $listData['Product']['costProduct']= $priceInputProductNoTax-$sumDirectDiscount;//gia von mua.
          }
        }
      }
      // tỉnh thành
      if (!empty($_POST['idCity'])) {
        $idCity=$_POST['idCity'];
        $listData['Product']['idCity']=$idCity;
        $modelTransport=new transport;
        $dataTransport=$modelTransport->find('first', array('conditions'=>array('idCity'=>$idCity)));
        if (!empty($_POST['packing'])) {
          // chi phí vận chuyển
          $costTransport=$dataTransport['transport']['priceTransport']/1.1/$_POST['packing'];
          $listData['costTransport'] = $costTransport;
          if (!empty($priceInputProductNoTax) && !empty($sumDirectDiscount)
              && !empty($_POST['totalPostpayDiscount']) && !empty($_POST['totalRevenue'])
              && !empty($_POST['totalOtherIncome']) && !empty($costTransport)) {
                $capitalDiscount=$priceInputProductNoTax-$sumDirectDiscount-$_POST['totalPostpayDiscount']-
                $_POST['totalRevenue']-$_POST['totalOtherIncome']+$costTransport;
                $listData['capitalDiscount']=$capitalDiscount;
                if (!empty($capitalDiscount) && !empty($_POST['insuranceCosts'])
                    && !empty($_POST['managementCosts']) && !empty($_POST['borrow'])) {
                  $listData['priceEven']= $capitalDiscount +
                        $_POST['insuranceCosts'] + $_POST['managementCosts'] + $_POST['borrow'];
                }
          }
        }
      }

      if (!empty($listData)
      && !empty($_POST['specification']) && !empty($_POST['weight'])
      && !empty($_POST['packing'])
      && !empty($_POST['priceInputPackingTax']) && !empty($_POST['idCity'])) {

            if ($modelProduct->save($listData)) {
              $mess='Lưu thành công';
              } else {
              $mess='LƯU THẤT BẠI';
            }


      } else {
        $mess='Bạn cần nhập đủ thông tin tối thiểu';
      }
    }
    setVariable('mess',$mess);
    setVariable('listSupplier',$listSupplier);
    setVariable('listData',$listData);
    // end lưu
  }
  function viewManage(){
    global $urlHomes;
    $listData = array();
    $modelProduct= new Product;
    $modelSupplier=new Supplier;
    $modelTransport=new transport;
    $mess='';
    $listSupplier=$modelSupplier->find('all',array('conditions'=>array(),'fields'=>'name'));

    if (!empty($_GET['id'])) {
      $listData=$modelProduct->find('first', array('conditions'=>array('id'=>$_GET['id'])));

    }
    if (!empty($listData['Product']['idCity'])) {
      $listTransport=$modelTransport->find('first', array('conditions'=>array('idCity'=>$listData['Product']['idCity']),'fields'=>'priceTransport'));
      setVariable('listTransport',$listTransport);
    }
    setVariable('mess',$mess);
    setVariable('listSupplier',$listSupplier);
    setVariable('listData',$listData);
  }
  function priceProduct(){
    // $modelWard= new Wards;
    // $WArd=$modelWard->find('all');
    // pr($WArd);
    global $urlHomes;
    $mess='';
    $modelMachine= new Machine;
    $modelPlace = new Place;
    $modelProduct = new Product;
    $modelSellProduct = new SellProduct;
    $listPlace=$modelPlace->find('all',array('conditions'=>array('lock'=>(int)0)));
    $listMachine=$modelMachine->find('all',array('conditions'=>array('lock'=>(int)0)));
    $conditionsPlace=array();
    $place=array();
    $conditionsMachine=array();
    if(!empty($_GET['id'])){
      $idProduct = $_GET['id'];
      $product=$modelProduct->getProduct($idProduct);
      if(!empty($product)){
        if(isset($_POST['submit'])) {
          // pr($_POST);die();
          //$data=[];
          //$data['SellProduct']['code'] = $product['Product']['code'];
          //$data['SellProduct']['name'] = $product['Product']['name'];
          $conditionsCheck=array(
              'priceSale'=>'',
              'idChannel'=>'',
              'area'=>'',
              'idCity'=>'',
              'idDistrict'=>'',
              'wards'=>'',
              'idPlace'=>'',
              'codeMachine'=>'',
              'dateStart'=>'',
              'dateEnd'=>'',
              'typedateEndPay'=>'',
              'lock'=>(int)0
          );
          $data['SellProduct']['code']=$product['Product']['code'];
          if(!empty($_POST['price'])){
            $priceSale= (int)str_replace(array('.',',',' '),'',$_POST['price']);
            $conditionsCheck['priceSale'] = $priceSale;
            $data['SellProduct']['priceSale']= $priceSale;
          }
          //$data['SellProduct']['idChannel'] = '';

          if (!empty($_POST['idChannel'])) {
            $conditionsCheck['idChannel']=$_POST['idChannel'];
            $conditionsPlace['idChannel']['$in']=$_POST['idChannel'];
          }
          if (!empty($_POST['area'])) {
            $conditionsCheck['area']=$_POST['area'];
            $conditionsPlace['area']['$in']=$_POST['area'];
          }
          if (!empty($_POST['idCity'])) {
            $conditionsCheck['idCity']=$_POST['idCity'];
            $conditionsPlace['idCity']['$in']=$_POST['idCity'];
          }
          if (!empty($_POST['idDistrict'])) {
            $conditionsCheck['idDistrict']=$_POST['idDistrict'];
            $conditionsPlace['idDistrict']['$in']=$_POST['idDistrict'];
          }
          // $data['SellProduct']['wards'] = '';
          if (!empty($_POST['wards'])) {
            $conditionsCheck['wards']=$_POST['wards'];
            $conditionsPlace['wards']['$in']=$_POST['wards'];
          }
          //$data['SellProduct']['idPlace'] = '';
            //tìm kiếm điểm đặt theo điều kiện.
          if (!empty($_POST['idPlace'])) {
            $conditionsCheck['idPlace']=$_POST['idPlace'];
            $conditionsMachine['idPlace']['$in']=$_POST['idPlace'];
          }else{
            if(!empty($conditionsPlace)){
              $place=$modelPlace->find('all',array('conditions'=>$conditionsPlace,'fields'=>'id'));
              foreach ($place as  &$value) {
                $idPlace[]=$value['Place']['id'];
              }
              $conditionsMachine['idPlace']['$in']=$idPlace;
            }
          }

          //tìm kiếm mã máy theo điều kiện.

          if (!empty($_POST['codeMachine'])) {
            $conditionsCheck['codeMachine']=$_POST['codeMachine'];
            $data['SellProduct']['codeMachine']=$_POST['codeMachine'];
          }else{
            if(!empty($conditionsMachine)){
              $machine=$modelMachine->find('all',array('conditions'=>$conditionsMachine,'fields'=>'code'));
              foreach ($machine as  &$valueMachine) {
                $codeMachine[]=$valueMachine['Machine']['code'];
              }
              $data['SellProduct']['codeMachine']=$codeMachine;
            }
          }
          //$data['SellProduct']['typedateEndPay'] = '';
          if (!empty($_POST['typedateEndPay'])) {
            $data['SellProduct']['typedateEndPay'] = $_POST['typedateEndPay'];
            $conditionsCheck['typedateEndPay']=$_POST['typedateEndPay'];
          }
          //$data['SellProduct']['dateStart'] = '';
          if (!empty($_POST['dateStart'])) {
            $data['SellProduct']['dateStart'] = convertMktime($_POST['dateStart']);
            $conditionsCheck['dateStart']=convertMktime($_POST['dateStart']);
          }
          //$data['SellProduct']['dateEnd'] = '';
          if (!empty($_POST['dateEnd'])) {
            $data['SellProduct']['dateEnd'] = convertMktime($_POST['dateEnd']);
            $conditionsCheck['dateEnd']=convertMktime($_POST['dateEnd']);
          }
          
          if ($_POST['submit']=='Lưu') {
            $data['SellProduct']['lock'] = (int)1;
          } else {
            $data['SellProduct']['lock'] = (int)0;
          }
          $checkSell = $modelSellProduct->find('all',array('conditions'=>$conditionsCheck));
            if (empty($checkSell)) {
              if ($modelSellProduct->save($data)) {
                // nếu người dùng ấn nút phê duyệt và phương thức thanh toán có tiền mặt
                if ($_POST['submit']=='Phê duyệt' && in_array('1', $_POST['typedateEndPay'])) {
                  // lấy giá riêng cuối cùng ra
                  // $lastPrice=$modelSellProduct->find('first',array('order'=>array('created'=>'desc')));
                  // tiến hành đồng bộ
                  // $modelSellProduct->redirect($urlHomes.'synchMachine?id='.$lastPrice['SellProduct']['id'].'&idProduct='.@$_GET['id']);
                }
                $mess='Thêm giá bán thành công';
              } else {
                $mess='LƯU THẤT BẠI';
              }
            } else {
              $mess='Lưu không thành công do điều kiện không hợp lệ';
            }
        } // end if(isset($_POST['submit']))
        // $conditions['idChannel']['$in'] = $_POST['idChannel'];
        $sellProduct = $modelSellProduct->find('all', array('conditions'=>array('code'=>$product['Product']['code'])));

        // $Product =$modelSellProduct->find('all', array('conditions'=>$conditions));
        // echo json_encode($sellProduct[1]['SellProduct']['codeMachine']);
        // pr(json_decode((json_encode($sellProduct[1]['SellProduct']['codeMachine']))));
        setVariable('product',$product);
        setVariable('sellProduct',$sellProduct);
      } else {
        echo '<script>window.history.go(-1);</script>';
      }// end if(!empty($_GET['id']))
    } else {
      echo '<script>window.history.go(-1);</script>';
    }
    setVariable('mess',$mess);
    setVariable('listPlace',$listPlace);
    setVariable('listMachine',$listMachine);
    
    //echo $_GET['id'];
  }
  function updateStatusPrice() {
    $modelSellProduct= new SellProduct;
    if (!empty($_GET['idPrice'])) {
      $sellProduct = $modelSellProduct->find('first', array('conditions'=>array('id'=>$_GET['idPrice'])));
      $sellProduct['SellProduct']['lock'] = (int)0;
      $status = "Giá bán riêng này đã được phê duyệt\nVui lòng chờ đồng bộ";
      if ($modelSellProduct->save($sellProduct)) {
        echo $status;
      }
    } else {
      echo 'Lỗi';
    }
    
  }
  function deletePrice() {
    global $urlHomes;
    $modelSellProduct= new SellProduct;

    if(!empty($_GET['id'])){
      $modelSellProduct->deleteAll(array('id'=>$_GET['id']),true);
    }
    $modelSellProduct->redirect($urlHomes.'priceProduct?id='.$_GET['idProduct']);
  }
  function reportByMachine() {
    $modelProduct= new Product;
    if (isset($_POST['inport'])) {
      require("PHPExcel/PHPExcel.php");
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->setActiveSheetIndex(0);
      // gộp ô
      $merge = ['J3:R3', 'S3:AA3', 'AB3:AJ3'];
      $cellVal = [
        'A1' => 'BÁO CÁO DOANH THU - LỢI NHUẬN THEO TỪNG MÁY BÁN HÀNG',
        'A2' => 'Tháng '.@$_GET['dateStart'],
        'G2' => 'Đơn vị tính: VNĐ',
        'J3' => 'Tháng 7',
        'S3' => 'Tháng 6',
        'AB3' => 'Chênh lệch',
        'A4' => 'STT',
        'B4' => 'Ngày bắt đầu',
        'C4' => 'Ngày Kết thúc',
        'D4' => 'Mã máy',
        'E4' => 'Mã kho',
        'F4' => 'Khu vực',
        'G4' => 'Kênh',
        'H4' => 'Vị trí lắp máy',
        'I4' => 'Tên kho điểm',
        'J4' => 'Số điểm hoạt động',
        'K4' => 'Số lượng bán',
        'L4' => 'Doanh số',
        'M4' => 'Doanh thu',
        'N4' => 'DT TB máy',
        'O4' => 'Giá vốn',
        'P4' => 'LN gộp',
        'Q4' => 'Tỉ trọng DT',
        'R4' => 'Tỉ lệ LN /DT',
        'S4' => 'Số điểm hoạt động',
        'T4' => 'Số lượng bán',
        'U4' => 'Doanh số',
        'V4' => 'Doanh thu',
        'W4' => 'DT TB máy',
        'X4' => 'Giá vốn',
        'Y4' => 'LN gộp',
        'Z4' => 'Tỉ trọng DT',
        'AA4' => 'Tỉ lệ LN /DT',
        'AB4' => 'Số điểm hoạt động',
        'AC4' => 'Số lượng bán',
        'AD4' => 'Doanh số',
        'AE4' => 'Doanh thu',
        'AF4' => 'DT TB máy',
        'AG4' => 'Giá vốn',
        'AH4' => 'LN gộp',
        'AI4' => 'Tỉ trọng DT',
        'AJ4' => 'Tỉ lệ LN /DT',
      ];
      $wrap = ['B4', 'C4', 'H4', 'I4', 'J4', 'K4', 'N4', 'Q4', 'R4', 'S4', 'T4', 'U4', 'V4', 'W4', 'Z4', 'AA4', 'AB4', 'AC4', 'AE4', 'AF4', 'AI4', 'AJ4'];
        // merge cells
        foreach ($merge as $key => $value) {
          $objPHPExcel->getActiveSheet()->mergeCells($value);
        }
        // set cell value title
        foreach ($cellVal as $key => $value) {
          $objPHPExcel->getActiveSheet()->setCellValue($key, $value);
        }
        // set Wrap Text
        foreach ($wrap as $key => $value) {
          $objPHPExcel->getActiveSheet()->getStyle($value)->getAlignment()->setWrapText(true);
        }
      $border = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                  'color' => array('argb' => '000000'), //định dạng mã màu theo argb.
              )
          )
      );
      $bold = [
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000') //định dạng mã màu theo rgb.
        )
      ];
      $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->applyFromArray($border);
      $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->applyFromArray($bold);
      $objPHPExcel->getActiveSheet()->getStyle('J3:AJ3')->applyFromArray($border);
      $dataExport=$modelProduct->find('all',array('conditions'=>$conditions,'order'=>array('created'=>'DESC')));
      // căn giữa 2 bên
      $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('J3:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('S3:AA3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('AB3:AJ3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      // căn giữa trên dưới
      $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      if(!empty($dataExport)){


          // xuất file
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="BC-doanh-thu-theo-may.xls"');
          header('Cache-Control: max-age=0');
          // If you're serving to IE 9, then the following may be needed
          header('Cache-Control: max-age=1');
          // If you're serving to IE over SSL, then the following may be needed
          header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
          header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
          header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
          header('Pragma: public'); // HTTP/1.0
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          $objWriter->save('php://output');
          exit;
      } // hết if(!empty($dataExport))
    }
  }
  function reportRevenue2Year() {
    set_time_limit(9999);
    ini_set('memory_limit', '512M');
    $curYear = date('Y');
    $preYear = date('Y')-1;
    $modelProduct = new Product;
    $modelTransfer = new Transfer();
    $j=1;
    // $s = microtime(true);

    // /////////////////////////////////////////////////ĐẦU MẢNG////////////////////////////

    /**///////////// Dữ liệu của năm nay ////////////////////
    /**/
    /**/      // mảng chứa số liệu bán ra năm nay
    /**/      $data["quantity$curYear"]=['Số lượng bán ra'];
    /**/      // mảng chứa doanh số năm nay
    /**/      $data["money$curYear"]=['Doanh số'];
    /**/      // mảng chứa doanh thu năm nay
    /**/      $data["revenue$curYear"]=['Doanh thu'];
    /**/      // mảng chứa giá vốn năm nay
    /**/      $data["capital$curYear"]=['Giá vốn'];
    /**/      // mảng chứa lợi nhuận năm nay
    /**/      $data["profit$curYear"]=['Lợi nhuận'];
    /**/      // mảng chứa tỉ lệ lợi nhuận năm nay
    /**/      $data["profitRate$curYear"]=['Tỉ lệ lợi nhuận'];
    /**/
    /**////////////////////////////////////////////////////////

    /**///////////// Dữ liệu của năm trước ////////////////////
    /**/
    /**/      // mảng chứa số liệu bán ra năm nay
    /**/      $data["quantity$preYear"]=['Số lượng bán ra'];
    /**/      // mảng chứa doanh số năm nay
    /**/      $data["money$preYear"]=['Doanh số'];
    /**/      // mảng chứa doanh thu năm nay
    /**/      $data["revenue$preYear"]=['Doanh thu'];
    /**/      // mảng chứa giá vốn năm nay
    /**/      $data["capital$preYear"]=['Giá vốn'];
    /**/      // mảng chứa lợi nhuận năm nay
    /**/      $data["profit$preYear"]=['Lợi nhuận'];
    /**/      // mảng chứa tỉ lệ lợi nhuận năm nay
    /**/      $data["profitRate$preYear"]=['Tỉ lệ lợi nhuận'];
    /**/
    /**////////////////////////////////////////////////////////

    /**///////////// Dữ liệu chênh lệch 2 năm ////////////////////
    /**/
    /**/      // mảng chứa số liệu bán ra năm nay
    /**/      $data["quantityDifference"]=['Số lượng bán ra'];
    /**/      // mảng chứa doanh số năm nay
    /**/      $data["moneyDifference"]=['Doanh số'];
    /**/      // mảng chứa doanh thu năm nay
    /**/      $data["revenueDifference"]=['Doanh thu'];
    /**/      // mảng chứa giá vốn năm nay
    /**/      $data["capitalDifference"]=['Giá vốn'];
    /**/      // mảng chứa lợi nhuận năm nay
    /**/      $data["profitDifference"]=['Lợi nhuận'];
    /**/      // mảng chứa tỉ lệ lợi nhuận năm nay
    /**/      $data["profitRateDifference"]=['Tỉ lệ lợi nhuận'];
    /**/
    /**////////////////////////////////////////////////////////

    // //////////////////////////////////////////////////MẢNG DỮ LIỆU CÁC THÁNG TRONG NĂM////////////

    // cho $i chạy từ tháng 1 đến tháng 12 để lấy ra số liêu từng tháng
    for ($i=1; $i <= 12; $i++) {
      $j++;
      // số liệu năm nay
      $conditionsTranfer['timeServer']['$gte'] = mktime(0,0,0,$i,1,$curYear);
      $conditionsTranfer['timeServer']['$lt'] = mktime(0,0,0,$j,1,$curYear);
      if($j==13) {
        $conditionsTranfer['timeServer']['$lte'] = mktime(23,59,59,12,31,$curYear);
      }
      $fieldsTranfer = ['idProduct', 'quantity', 'moneyCalculate']; // các trtwowng cần lấy ra
      $listTransfer = $modelTransfer->find('all', array('conditions'=>$conditionsTranfer, 'fields'=>$fieldsTranfer));
      // cho số liệu của mỗi tháng = 0
      $data['quantity'][$i]=0;
      // cộng thêm số liệu nếu có
      if(!empty($listTransfer)) {
        foreach ($listTransfer as $value) {
        $data['quantity'][$i] += (int)$value['Transfer']['quantity'];
        }
      }
      // thêm dữ liệu vào mảng chứa số liệu bán ra năm nay
      array_push($data["quantity$curYear"],$data['quantity'][$i]);

      $data['money'][$i]=0;
      if(!empty($listTransfer)) {
        foreach ($listTransfer as $value) {
        $data['money'][$i] += (int)$value['Transfer']['moneyCalculate']*$data['quantity'][$i];
        }
      }
      // thêm dữ liệu vào mảng chứa doanh số năm nay
      array_push($data["money$curYear"],$data['money'][$i]);
      $revenue[$i] = 0;
      $revenue[$i] = $data['money'][$i]+$data['money'][$i]*10/100; //doanh thu theo từng tháng
      // thêm dữ liệu vào mảng chứa doanh thu năm nay
      array_push($data["revenue$curYear"],$revenue[$i]);
      // Tính giá vốn
      $capital[$i] = 0;
      $capital[$i] = $revenue[$i]/2;
      // if(!empty($listTransfer)) {
      //   foreach ($listTransfer as $value) {
      //     $product = $modelProduct->find('first', array('conditions'=>array('id'=>$value['Transfer']['idProduct'])));
      //     if (is_array(@$product['Product']['priceInput'])) {
      //       foreach ($product['Product']['priceInput'] as $val) {
      //         $pricePackingTax = $val['pricePackingTax'];
      //       }
      //       $capital[$i] = (int)$pricePackingTax*$data['quantity'][$i];
      //     } else {
      //       $capital[$i] = @$product['Product']['priceInput']*$data['quantity'][$i];
      //     }
      //   }
      // }
      $profit[$i] = 0; // lợi nhuận theo từng tháng
      $profit[$i] = $revenue[$i]-(int)$capital[$i];
      // thêm dữ liệu vào mảng chứa giá vốn năm nay
      array_push($data["capital$curYear"],$capital[$i]);
      
      // thêm dữ liệu vào mảng chứa lợi nhuận năm nay
      array_push($data["profit$curYear"],$profit[$i]);
      // tỉ lệ lợi nhuận từng tháng
      $profitRate[$i] = 0;
      if ($revenue[$i] != 0) {
        $profitRate[$i] = $profit[$i]/$revenue[$i]*100;
      }
      // thêm dữ liệu vào mảng chứa tỉ lệ lợi nhuận năm nay
      array_push($data["profitRate$curYear"],number_format($profitRate[$i],2));
      // end current Year

      //  ======================================///////số liệu năm trước////////========================================
      $conditionsTranferPre['timeServer']['$gte'] = mktime(0,0,0,$i,1,$preYear);
      $conditionsTranferPre['timeServer']['$lt'] = mktime(0,0,0,$j,1,$preYear);
      if($j==13) {
        $conditionsTranferPre['timeServer']['$lte'] = mktime(23,59,59,12,31,$preYear);
      }
      $fieldsTranferPre = ['quantity', 'moneyCalculate']; // các trtwowng cần lấy ra
      $listTransferPre = $modelTransfer->find('all', array('conditions'=>$conditionsTranferPre, 'fields'=>$fieldsTranferPre));
      // if($i==2) {pr($listTransferPre);die();}
      // cho số liệu của mỗi tháng = 0
      $data['quantity'][$i]=0;
      // cộng thêm số liệu nếu có
      if(!empty($listTransferPre)) {
        foreach ($listTransferPre as $value) {
        $data['quantity'][$i] += (int)$value['Transfer']['quantity'];
        }
      }
      // thêm dữ liệu vào mảng chứa số liệu bán ra năm nay
      array_push($data["quantity$preYear"],$data['quantity'][$i]);

      $data['money'][$i]=0;
      if(!empty($listTransferPre)) {
        foreach ($listTransferPre as $value) {
        $data['money'][$i] += (int)$value['Transfer']['moneyCalculate']*$data['quantity'][$i];
        }
      }
      // thêm dữ liệu vào mảng chứa doanh số năm nay
      array_push($data["money$preYear"],$data['money'][$i]);
      $revenue[$i] = 0;
      $revenue[$i] = $data['money'][$i]+$data['money'][$i]*10/100; //doanh thu theo từng tháng
      // thêm dữ liệu vào mảng chứa doanh thu năm nay
      array_push($data["revenue$preYear"],$revenue[$i]);
      // giá vốn theo từng tháng
      $capital[$i] = 0;
      $capital[$i] = $revenue[$i]/2;
      // if(!empty($listTransferPre)) {
      //   foreach ($listTransferPre as $value) {
      //     $product = $modelProduct->find('first', array('conditions'=>array('id'=>$value['Transfer']['idProduct'])));
      //     if (is_array($product['Product']['priceInput'])) {
      //       foreach (@$product['Product']['priceInput'] as $val) {
      //         $pricePackingTax = $val['pricePackingTax'];
      //       }
      //       $capital[$i] = (int)$pricePackingTax*$data['quantity'][$i];
      //     } else {
      //       $capital[$i] = @$product['Product']['priceInput']*$data['quantity'][$i];
      //     }
      //   }
      // }
      $profit[$i] = 0; // lợi nhuận theo từng tháng
      $profit[$i] = $revenue[$i]-$capital[$i];
      // thêm dữ liệu vào mảng chứa giá vốn năm nay
      array_push($data["capital$preYear"],$capital[$i]);
      // thêm dữ liệu vào mảng chứa lợi nhuận năm nay
      array_push($data["profit$preYear"],$profit[$i]);
      // tỉ lệ lợi nhuận từng tháng
      $profitRate[$i] = 0;
      if ($revenue[$i] != 0) {
        $profitRate[$i] = $profit[$i]/$revenue[$i]*100;
      }
      // thêm dữ liệu vào mảng chứa tỉ lệ lợi nhuận năm nay
      array_push($data["profitRate$preYear"],number_format($profitRate[$i],2));

      // thêm dữ liệu vào mảng chứa số liệu chênh lệch 2 năm //////////////////////////////////////////
      array_push($data['quantityDifference'],$data["quantity$curYear"][$i]-$data["quantity$preYear"][$i]);
      // thêm dữ liệu vào mảng chứa doanh số năm nay
      array_push($data['moneyDifference'],$data["money$curYear"][$i]-$data["money$preYear"][$i]);
      // thêm dữ liệu vào mảng chứa doanh thu năm nay
      array_push($data["revenueDifference"],$data["revenue$curYear"][$i]-$data["revenue$preYear"][$i]);
      // thêm dữ liệu vào mảng chứa giá vốn năm nay
      array_push($data["capitalDifference"],$data["capital$curYear"][$i]-$data["capital$preYear"][$i]);
      // thêm dữ liệu vào mảng chứa lợi nhuận năm nay
      array_push($data["profitDifference"],$data["profit$curYear"][$i]-$data["profit$preYear"][$i]);
      // thêm dữ liệu vào mảng chứa tỉ lệ lợi nhuận năm nay
      array_push($data["profitRateDifference"],$data["profitRate$curYear"][$i]-$data["profitRate$preYear"][$i]);
      // end pre year
    } // end for loop

    // /////////////////////////////////DỮ LIỆU CỦA PHẦN Tổng cộng//////////////////////////////////////

    // thêm tổng số liệu vào mảng chứa số lượng bán ra năm nay
    array_push($data["quantity$curYear"],array_sum($data["quantity$curYear"]));
    // thêm tổng số liệu vào mảng chứa doanh số năm nay
    array_push($data["money$curYear"],array_sum($data["money$curYear"]));
    // thêm tổng số liệu vào mảng chứa doanh thu năm nay
    array_push($data["revenue$curYear"],array_sum($data["revenue$curYear"]));
    // thêm tổng số liệu vào mảng chứa giá vốn năm nay
    array_push($data["capital$curYear"],array_sum($data["capital$curYear"]));
    // thêm tổng số liệu vào mảng chứa lợi nhuận năm nay
    array_push($data["profit$curYear"],array_sum($data["profit$curYear"]));
    // thêm tổng số liệu vào mảng chứa tỉ lệ lợi nhuận năm nay
    if (array_sum($data["revenue$curYear"])==0) {
      array_push($data["profitRate$curYear"],0);
    } else {
      array_push($data["profitRate$curYear"],number_format((array_sum($data["profit$curYear"])/array_sum($data["revenue$curYear"])*100),2));
    }


    // thêm tổng số liệu vào mảng chứa số lượng bán ra năm trước
    array_push($data["quantity$preYear"],array_sum($data["quantity$preYear"]));
    // thêm tổng số liệu vào mảng chứa doanh số năm nay
    array_push($data["money$preYear"],array_sum($data["money$preYear"]));
    // thêm tổng số liệu vào mảng chứa doanh thu năm nay
    array_push($data["revenue$preYear"],array_sum($data["revenue$preYear"]));
    // thêm tổng số liệu vào mảng chứa giá vốn năm nay
    array_push($data["capital$preYear"],array_sum($data["capital$preYear"]));
    // thêm tổng số liệu vào mảng chứa lợi nhuận năm nay
    array_push($data["profit$preYear"],array_sum($data["profit$preYear"]));
    // thêm tổng số liệu vào mảng chứa tỉ lệ lợi nhuận năm nay
    if (array_sum($data["revenue$preYear"])==0) {
      array_push($data["profitRate$preYear"],0);
    } else {
      array_push($data["profitRate$preYear"],number_format((array_sum($data["profit$preYear"])/array_sum($data["revenue$preYear"])*100),2));
    }


    // thêm tổng số liệu vào mảng chứa số lượng bán ra chênh lệch
    array_push($data['quantityDifference'],array_sum($data['quantityDifference']));
    // thêm tổng số liệu vào mảng chứa doanh số năm nay
    array_push($data["moneyDifference"],array_sum($data["moneyDifference"]));
    // thêm tổng số liệu vào mảng chứa doanh thu năm nay
    array_push($data["revenueDifference"],array_sum($data["revenueDifference"]));
    // thêm tổng số liệu vào mảng chứa giá vốn năm nay
    array_push($data["capitalDifference"],array_sum($data["capitalDifference"]));
    // thêm tổng số liệu vào mảng chứa lợi nhuận năm nay
    array_push($data["profitDifference"],array_sum($data["profitDifference"]));
    // thêm tổng số liệu vào mảng chứa tỉ lệ lợi nhuận năm nay
    if (array_sum($data["revenueDifference"])==0) {
      array_push($data["profitRateDifference"],0);
    } else {
      array_push($data["profitRateDifference"],number_format((array_sum($data["profitDifference"])/array_sum($data["revenueDifference"])*100),2));
    }
    
// pr($data);

    // $e=microtime(true);
    // $time=round($e-$s,4);
    // echo 'Truy vấn mất '.$time.' giây';
    
    if (isset($_POST['inport'])) {
      require("PHPExcel/PHPExcel.php");
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->setActiveSheetIndex(0);
      $merge = ['A1:C1', 'A12:C12', 'A23:C23'];
      $cellVal = [
        'A1' => 'TỔNG HỢP DOANH THU NĂM '.$curYear,
        'D1' => 'A',
        'A12' => 'TỔNG HỢP DOANH THU NĂM '.$preYear,
        'D12' => 'B',
        'A23' => 'Chênh lệch',
        'D23' => 'A-B',
      ];
      $column = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];
      $columnFirst = ['B','C','D','E','F','G','H','I','J','K','L','M','N'];
      $valueFirstColumn = ['Số lượng bán ra', 'Doanh số', 'Doanh thu', 'Giá vốn', 'Lợi nhuận', 'Tỉ lệ lợi nhuận'];
      // pr($column);die();
      $wrap = ['44', 'A5', 'A6', 'A7', 'A8', 'A9', 'N4', 'Q4', 'R4', 'S4', 'T4', 'U4', 'V4', 'W4', 'Z4', 'AA4', 'AB4', 'AC4', 'AE4', 'AF4', 'AI4', 'AJ4'];
        // set cell value title
        foreach ($cellVal as $key => $value) {
          $objPHPExcel->getActiveSheet()->setCellValue($key, $value);
        }
        // merge cells
        foreach ($merge as $keyMe => $valueMe) {
          $objPHPExcel->getActiveSheet()->mergeCells($valueMe);
        }
        
        // set Wrap Text
        // foreach ($wrap as $key => $value) {
        //   $objPHPExcel->getActiveSheet()->getStyle($value)->getAlignment()->setWrapText(true);
        // }
        // Làm bảng A
        // in ra tiêu đề từ các tháng 1->12 và tổng cộng
        foreach ($column as $key => $value) {
          if ($key==0) {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'3'), '');
          } elseif ($key==13) {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'3'), 'Tổng cộng');
          } else {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'3'), 'Tháng '.$key);
          }
        }
        // in ra số liệu báo cáo của các tháng trong năm nay
        for ($col=0; $col < 14 ; $col++) { 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,4,$data["quantity$curYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,5,$data["money$curYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,6,$data["revenue$curYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,7,$data["capital$curYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,8,$data["profit$curYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,9,$data["profitRate$curYear"][$col].' %');

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,15,$data["quantity$preYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,16,$data["money$preYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,17,$data["revenue$preYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,18,$data["capital$preYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,19,$data["profit$preYear"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,20,$data["profitRate$preYear"][$col].' %');

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,26,$data["quantityDifference"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,27,$data["moneyDifference"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,28,$data["revenueDifference"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,29,$data["capitalDifference"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,30,$data["profitDifference"][$col]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,31,$data["profitRateDifference"][$col].' %');
        }
        // Làm bảng B
        // in ra tiêu đề từ các tháng 1->12 và tổng cộng
        foreach ($column as $key => $value) {
          if ($key==0) {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'14'), '');
          } elseif ($key==13) {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'14'), 'Tổng cộng');
          } else {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'14'), 'Tháng '.$key);
          }
        }
         // in ra số liệu báo cáo của các tháng trong năm TRƯỚC

        // Làm bảng chênh lệch
        // in ra tiêu đề từ các tháng 1->12 và tổng cộng
        foreach ($column as $key => $value) {
          if ($key==0) {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'25'), '');
          } elseif ($key==13) {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'25'), 'Tổng cộng');
          } else {
            $objPHPExcel->getActiveSheet()->setCellValue(($value.'25'), 'Tháng '.$key);
          }
        }
         // in ra số liệu báo cáo của chênh lệch trong 2 năm

        
      $border = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                  'color' => array('argb' => '000000'), //định dạng mã màu theo argb.
              )
          )
      );
      $bold = [
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000') //định dạng mã màu theo rgb.
        )
      ];
      $objPHPExcel->getActiveSheet()->getStyle('A3:N9')->applyFromArray($border);
      $objPHPExcel->getActiveSheet()->getStyle('A14:N20')->applyFromArray($border);
      $objPHPExcel->getActiveSheet()->getStyle('A25:N31')->applyFromArray($border);

      $objPHPExcel->getActiveSheet()->getStyle('A1:N3')->applyFromArray($bold);
      $objPHPExcel->getActiveSheet()->getStyle('A12:N14')->applyFromArray($bold);
      $objPHPExcel->getActiveSheet()->getStyle('A23:N25')->applyFromArray($bold);
      $dataExport=$modelProduct->find('all',array('conditions'=>$conditions,'order'=>array('created'=>'DESC')));
      // căn giữa 2 bên
      // $objPHPExcel->getActiveSheet()->getStyle('J3:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      // căn giữa trên dưới
      // $objPHPExcel->getActiveSheet()->getStyle('A4:AJ4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      // setAutoSize
        foreach(range('A','N') as $column) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
      if(!empty($dataExport)){


          // xuất file
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="BC-doanh-thu-2-nam.xls"');
          header('Cache-Control: max-age=0');
          // If you're serving to IE 9, then the following may be needed
          header('Cache-Control: max-age=1');
          // If you're serving to IE over SSL, then the following may be needed
          header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
          header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
          header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
          header('Pragma: public'); // HTTP/1.0
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          $objWriter->save('php://output');
          exit;
      } // hết if(!empty($dataExport))
    }
    setVariable('curYear', $curYear);
    setVariable('preYear', $preYear);
    setVariable('data', $data);
  }



  function abcxyz123(){
/*
    $channel = $_GET['idChannel'];

    $data['sellProduct']['code']= ;
    $data['sellProduct']['name']= ;
    $data['sellProduct']['priceSale']= ;
    $data['sellProduct']['idChannel'][$channel]['idChannel'] = $channel;
    $data['sellProduct']['idChannel'][$channel]['data'][$i]['price'] = ;

    $data['sellProduct']['codeMachine']
        $data['sellProduct']['idPlace']
          $data['sellProduct']['wards']
            $data['sellProduct']['idDistrict']
              $data['sellProduct']['idCity']
                $data['sellProduct']['area'] || $data['sellProduct']['idChannel']
                */
  }

  // function sellProduct()
  // {
  //   $modelSellProduct = new SellProduct;
  //   if(!empty($_GET)) {

  //   }
  // }

  /* 
$data=array(....);
foreach( $data as $value){
  $data2[]=$value['abcxyz'];
}
pr($data2);

  */
 ?>
