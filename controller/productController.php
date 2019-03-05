<?php
function listProduct($input)
{
    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $urlNow;
    global $modelOption;
    global $metaTitleMantan;
    $metaTitleMantan= 'Danh sách sản phẩm';
    

    $dataSend = $input['request']->data;
    $modelProduct= new Product();
    $modelSupplier= new Supplier();
    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listProduct', $_SESSION['infoStaff']['Staff']['permission']))){
            $listSupplier= $modelSupplier->find('all',array('conditions'=>array('status'=>'active')));
            $listChannelProduct= $modelOption->getOption('listChannelProduct');
            $listCategoryProduct= $modelOption->getOption('listCategoryProduct');

            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions = array('lock'=>0);
            $order = array('created'=>'DESC');
            $fields= array('name','code','quantity','idCategory','priceOutput','idSupplier','image');
            if(!empty($_GET['name'])){
                $key= createSlugMantan($_GET['name']);
                $conditions['slugKeys']= array('$regex' => $key);
            }
            if(!empty($_GET['code'])){
                $code=trim($_GET['code']);
                $conditions['code']= array('$regex' => $code);
            }
            if(!empty($_GET['idCategory'])){
                $cat=trim( $_GET['idCategory']);
                $conditions['idCategory']=(int)$cat;
            }
            if(!empty($_GET['idSupplier'])){

                $conditions['idSupplier']= $_GET['idSupplier'];
            }
            if(!empty($_GET['exp'])){
             $conditions['exp.text']=  array('$regex' => $_GET['exp']);
         }
         if(!empty($_GET['specification'])){
            $specification=createSlugMantan($_GET['specification']);
            $conditions['specificationslug']=array('$regex' => $specification);
        }
        if(!empty($_GET['packing'])){
         $packing=createSlugMantan($_GET['packing']);
         $conditions['packingslug']=array('$regex' =>  $packing);
     }
     if(!empty($_GET['priceOutput'])){
       $priceOutput=trim($_GET['priceOutput']);
       $priceOutput1=str_replace ( array('    ',',','.') ,'',$priceOutput );
       $conditions['priceOutput']= (int)$priceOutput1;
   }
   if(!empty($_GET['priceInput'])){
       $priceInput=trim($_GET['priceInput']);
       $priceInput1=str_replace ( array('    ',',','.') ,'',$priceInput );
       $conditions['priceInput']= (int)$priceInput1;
   }
   if(!empty($_GET['idChannel'])){
    $conditions['idChannel']=(int)$_GET['idChannel'];
}
if(!empty($_GET['revenue'])){
 $revenue=trim($_GET['revenue']);
 $revenue1=str_replace ( array('    ',',','.') ,'',$revenue );
 $conditions['revenue']= array('$regex' => $revenue1);
}
if(!empty($_GET['loso'])){
    $conditions['loso']=$_GET['loso'];
}
$listData= $modelProduct->getPage($page, $limit , $conditions, $order, $fields );
$totalData= $modelProduct->find('count',array('conditions' => $conditions));
// pr($listData);
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

setVariable('listData',$listData);
setVariable('listSupplier',$listSupplier);
setVariable('listChannelProduct',$listChannelProduct);
setVariable('listCategoryProduct',$listCategoryProduct);

setVariable('page',$page);
setVariable('totalPage',$totalPage);
setVariable('back',$back);
setVariable('next',$next);
setVariable('urlPage',$urlPage);
setVariable('mess',$mess);
}else{
    $modelProduct->redirect($urlHomes.'dashboard');
}
}else{
    $modelProduct->redirect($urlHomes.'login?status=-2');
}
}

// thêm sản phẩm mới
function addProduct($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin sản phẩm';

    $modelProduct= new Product();
    $modelSupplier = new Supplier();
    $modelLog= new Log();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addProduct', $_SESSION['infoStaff']['Staff']['permission']))){

            $mess= '';
            $data= array();
            if(!empty($_GET['id'])){
                $data= $modelProduct->getProduct($_GET['id']);
            }

            $listSupplier= $modelSupplier->find('all',array('conditions'=>array('status'=>'active'),'fields'=>array('name')));
            $listChannelProduct= $modelOption->getOption('listChannelProduct');
            $listCategoryProduct= $modelOption->getOption('listCategoryProduct');

            if ($isRequestPost) {
                $dataSend= arrayMap($input['request']->data);
                
                if(!empty(trim($dataSend['name']))){
                    $checkProductCode= $modelProduct->getProductCode($dataSend['code'],array('code'));

                    if(empty($checkProductCode) || (!empty($_GET['id']) && $_GET['id']==$checkProductCode['Product']['id'] ) ){

                        $slugKeys= createSlugMantan($dataSend['name']);
                        $code=trim($dataSend['code']);
                        $code1=str_replace ( array('    ',',','.') ,'',$code );
                        $data['Product']['name']= trim($dataSend['name']);
                        $data['Product']['code']= $code1;
                        $data['Product']['priceInput']= (int)str_replace(array('.',',',' '),'',$dataSend['priceInput']);
                        $data['Product']['priceOutput']= (int)str_replace(array('.',',',' '),'',$dataSend['priceOutput']);
                        $data['Product']['idCategory']=$dataSend['idCategory'];
                        $data['Product']['specificationslug']=createSlugMantan($dataSend['specification']);
                        $data['Product']['specification']= $dataSend['specification'];
                        $data['Product']['packingslug']= createSlugMantan($dataSend['packing']);
                        $data['Product']['packing']= $dataSend['packing'];
                        $data['Product']['idChannel']= (int)$dataSend['idChannel'];
                        $data['Product']['loso']= $dataSend['loso'];
                        $data['Product']['idSupplier']= $dataSend['idSupplier'];
                        $data['Product']['revenue']=str_replace(array('.',',',' '),'',$dataSend['revenue']); 
                        $data['Product']['priceReference']= $dataSend['priceReference'];
                        $data['Product']['evaluate']= $dataSend['evaluate'];
                        $data['Product']['note']= $dataSend['note'];
                        $data['Product']['slugKeys']= $slugKeys;
                        $data['Product']['lock']= 0;
                        $data['Product']['image']= $dataSend['image'];
                        // lý do sửa
                        $data['Product']['reason']= $dataSend['reason'];
                        

                        if(empty($_GET['id'])){
                        	$data['Product']['quantity']= (int) isset($dataSend['quantity'])?$dataSend['quantity']:'';
                        }

                        $data['Product']['exp']['text']= $dataSend['exp'];
                        if(!empty($dataSend['exp'])){
                            $timeDate= explode('/', $dataSend['exp']);

                            $data['Product']['exp']['time']= mktime(23,59,59,$timeDate[1],$timeDate[0],$timeDate[2]);
                        }else{
                            $data['Product']['exp']['time']= 0;
                        }

                        if($modelProduct->save($data)){
                            $mess= 'Lưu thành công';
                            if (empty($dataSend['reason'])) {
                            // lưu lịch sử tạo sản phẩm
                            $saveLog['Log']['time']= time();
                            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm sản phẩm mới có mã: '.$data['Product']['code'];
                        }
                        else
                        {
                            $saveLog['Log']['time']= time();
                            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa sản phẩm có mã: '.$data['Product']['code'];
                        }
                            $modelLog->save($saveLog);

                            if(empty($_GET['id'])){
                                $data= array();
                            }
                        }else{
                            $mess= 'Lưu thất bại';
                        }

                    }else{
                        $mess= 'Mã sản phẩm đã tồn tại';
                    }
                }else{
                    $mess= 'Bạn không được để trống tên sản phẩm';
                }
            }   
            setVariable('mess',$mess);
            setVariable('data',$data);
            setVariable('listSupplier',$listSupplier);
            setVariable('listChannelProduct',$listChannelProduct);
            setVariable('listCategoryProduct',$listCategoryProduct);

        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}

// cập nhập số lượng sản phẩm
function updateProduct($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin sản phẩm';

    $modelProduct= new Product();
    $modelLog= new Log();

    if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('updateProduct', $_SESSION['infoStaff']['Staff']['permission']))){
        	$dataSend= arrayMap($input['request']->data);
         if(!empty($dataSend['id'])){
             if ($isRequestPost) {
                 if(!empty($dataSend['number'])){
                     $data['$inc']['quantity']= (int)$dataSend['number'];
                     $dk= array('_id'=>new MongoId($dataSend['id']) );

                     if($modelProduct->updateAll($data,$dk)){
	                        // lưu lịch sử thay đổi số lượng hàng
                      $saveLog['Log']['time']= time();
                      $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' cập nhập sản phẩm cũ có mã là '.$data['Product']['code'].', số lượng cập nhập '.$dataSend['number'];
                      $modelLog->save($saveLog);
                  }
              }
          }   

      }
  }
}
}

function deleteProduct($input)
{
    // $check=$modelSellproduct->find('all',array('conditions'=>$conditions));
    // if(empty($check)){
    //     save
    // }else{
    //     echo ' du lieu nhap vao khong hop le';
    // }
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $urlNow;
    $metaTitleMantan= 'Khóa sản phẩm';

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteProduct', $_SESSION['infoStaff']['Staff']['permission']))){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelProduct= new Product();
            $modelLog= new Log();

            if(!empty($_GET['id'])){
                $data['$set']['lock']= 1;
                $dk= array('_id'=>new MongoId($_GET['id']));

                if($modelProduct->updateAll($data,$dk)){
                	// lưu lịch sử tạo sản phẩm
                    $saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' khóa sản phẩm có ID là '.$_GET['id'];
                    $modelLog->save($saveLog);

                    $modelOption->redirect($urlHomes.'listProduct?status=deleteProductDone');
                }else{
                    $modelOption->redirect($urlHomes.'listProduct?status=deleteProductFail');
                }

            }else{
                $modelOption->redirect($urlHomes.'listProduct');
            }
        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}
function infoProduct(){
   global $modelOption;
   global $urlHomes;
   global $isRequestPost;
   global $metaTitleMantan;
   $metaTitleMantan= 'Xem sản phẩm';

   $modelProduct= new Product();
   $modelSupplier = new Supplier();
   $modelLog= new Log();

   if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoProduct', $_SESSION['infoStaff']['Staff']['permission']))){

        $mess= '';
        $data= array();
        if(!empty($_GET['id'])){
            $data= $modelProduct->getProduct($_GET['id']);
            setVariable('data',$data);
            if(!empty($data['Product']['idSupplier'])){
                $supplier= $modelSupplier->getSupplier($data['Product']['idSupplier'],$fields=array('name') );
                setVariable('supplier',$supplier);

            }
        }

        
        $listChannelProduct= $modelOption->getOption('listChannelProduct');
        $listCategoryProduct= $modelOption->getOption('listCategoryProduct');
        setVariable('listChannelProduct',$listChannelProduct);
        setVariable('listCategoryProduct',$listCategoryProduct);

    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}else{
    $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function listProductByMachine($input){
    global $urlHomes;
    global $isRequestPost;
    $modelProduct= new Product();
    $modelOption = new Option();
    $modelPlace = new Place();
    $modelSupplier = new Supplier();
    $modelMachine = new Machine();
    $listMachine = null;
    $dkPlace = array();
    $dkNcc = array();
    $dkMachine = array();
    $resultMachines = array(); 
    $resultProducts = array();
    $listResult = array();

    if(!empty($_SESSION['infoStaff'])){

     // Loc danh sach diem dat    
        if(!empty($_GET['idCity'])){
            $dkPlace['idCity'] = $_GET['idCity'];
            if(!empty($_GET['idDistrict'])){
                $dkPlace['idDistrict'] = $_GET['idDistrict'];
            } 
        }
        if(!empty($_GET['place_name'])){
            $key= createSlugMantan(trim($_GET['place_name']));
            $dkPlace['slug.name']= array('$regex' => $key);
        }
        if(!empty($_GET['place_code'])){
            $key= createSlugMantan(trim($_GET['place_code']));
            $dkPlace['slug.code']= array('$regex' => $key);
        }
                  
    // Dieu kien nha cung cap    
        if(!empty($_GET['ncc_name'])){
            $key = (trim($_GET['ncc_name']));
            $dkNcc['name']= array('$regex' => $key);
        }
        if(!empty($_GET['ncc_code'])){
            $key= (trim($_GET['ncc_code']));
            $dkNcc['code']= array('$regex' => $key);
        }
        if(!empty($dkNcc)){
            $listNcc = $modelSupplier->find('all',array('conditions'=>$dkNcc));
        }

    // Dieu kien may
        if(!empty($_GET['machine_name'])){
            $key= createSlugMantan(trim($_GET['machine_name']));
            $dkMachine['slug.name']= array('$regex' => $key);
        }   
        if(!empty($_GET['machine_code'])){
            $key= createSlugMantan(trim($_GET['machine_code']));
            $dkMachine['slug.code']= array('$regex' => $key);
        }  
        if(!empty($_GET['code_staff'])){
            $key= createSlugMantan(trim($_GET['code_staff']));
            $dkMachine['slug.codeStaff']= array('$regex' => $key);
        } 
    // Lay resultMachines vaf resultProducts tu du lieu tim kiem duoc 
        if(!empty($dkNcc) || !empty($dkPlace) || !empty($dkMachine))  {
            $listMachine = $modelMachine->find('all',array('conditions'=>$dkMachine));
            if(!empty($dkPlace)){
                $listPlace = $modelPlace->find('all',array('conditions'=>$dkPlace));
                foreach ($listPlace as $place) {
                    # code...
                    foreach ($listMachine as $machine) {
                        # code...
                        if($machine['Machine']['idPlace'] == $place['Place']['id'])
                            $resultMachines[] = $machine;
                    }
                }
            } else $resultMachines = $listMachine;
            
            $listNcc = $modelSupplier->find('all',array('conditions'=>$dkNcc));
                foreach ($listNcc as $ncc) {
                    # code...
                    $listProduct = $modelProduct->find('all',array('conditions'=>array('idSupplier'=>$ncc['Supplier']['id'])));
                    $resultProducts = array_merge($resultProducts,$listProduct);
                }
    // Lay list Result, duyệt từ listProduct và listMachine
        $i = 0;
        if(!empty($resultProducts) && !empty($resultMachines)){
            foreach ($resultMachines as $machine) {
                        # code...
                $place = $modelPlace->getPlace($machine['Machine']['idPlace'],null);
                if(isset($machine['Machine']['floor'])){
                    $machine_code = $machine['Machine']['code'];
                    $machine_name = $machine['Machine']['name'];
                    foreach ($resultProducts as $product) {
                        # code...
                        $ncc = $modelSupplier->getSupplier($product['Product']['idSupplier'],null);
                        $check = false;
                        $listResult[$i]['product_number'] = 0;
                        $listResult[$i]['max_product_number'] = 0;
                        
                        foreach ($machine['Machine']['floor'] as $fl) {
                            # code...
                            foreach ($fl as $loxo) {
                                # code...
                                if($loxo['idProduct'] == $product['Product']['id']){                             
                                    $listResult[$i]['product_number'] += $loxo['numberProduct'];
                                    $listResult[$i]['max_product_number'] += $loxo['numberLoxo'];
                                    $check = true;
                                }
                            }
                        }
                        if($check){
                            $listResult[$i]['load_product_number'] = $listResult[$i]['max_product_number'] - $listResult[$i]['product_number'];
                            $listResult[$i]['machine_id'] = $machine['Machine']['id'];
                            $listResult[$i]['machine_code'] = $machine_code;
                            $listResult[$i]['machine_name'] = $machine_name;
                            $listResult[$i]['place_code'] = $place['Place']['code'];
                            $listResult[$i]['place_name'] = $place['Place']['name'];
                            $listResult[$i]['product_name'] = $product['Product']['name'];
                            $listResult[$i]['product_code'] = $product['Product']['code'];
                            $listResult[$i]['supplier_code'] = $ncc['Supplier']['code'];
                            $listResult[$i]['supplier_name'] = $ncc['Supplier']['name'];
                            
                            $i++;
                        }
                    }
                    }        
                }
            } 
        } 
        unset($listResult[count($listResult)-1]);
        setVariable('listResult',$listResult);

        if(isset($_POST['export'])){
            if(!empty($listResult)){
                $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Tên máy'), 'width' => 20),
                array('label' => __('Mã máy'), 'width' => 20),
                array('label' => __('Tên điểm'), 'width' => 20),
                array('label' => __('Mã điểm'), 'width' => 20),
                array('label' => __('Tên sản phẩm'), 'width' => 20),
                array('label' => __('Mã sản phẩm'), 'width' => 20),
                array('label' => __('NCC sản phẩm'), 'width' => 20),
                array('label' => __('Mã NCC sản phẩm'), 'width' => 20),
                array('label' => __('Số hàng tối đa'), 'width' => 20),
                array('label' => __('Số hàng còn'), 'width' => 20),
                array('label' => __('Số hàng cần load'), 'width' => 20),

                );
                $stt = 0;
                $data = array();
                foreach ($listResult as $list) {
                    # code...
                    $stt++;
                    $data[] = array(
                        $stt,
                        $list['machine_name'],
                        $list['machine_code'],
                        $list['place_name'],
                        $list['place_code'],
                        $list['product_name'],
                        $list['product_code'],
                        $list['supplier_name'],
                        $list['supplier_code'],
                        $list['max_product_number'],
                        $list['product_number'],
                        $list['load_product_number']
                    );
                }
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $data[] = array("Thời gian tra cứu: ".date("Y/m/d")." - " . date("h:i:sa"));
                 $exportsController = new ExportsController();
                //$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
                $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-san-pham')));
            } else echo "Chua co du lieu";
        }
    } else {
             $modelProduct->redirect($urlHomes.'login?status=-2');
        }
    
    $city = $modelOption->find('first',array('conditions'=>array('key'=>'cityKiosk')));  
    $listCity = $city['Option']['value']['allData'];

    setVariable('listCity',$listCity);
}
?>