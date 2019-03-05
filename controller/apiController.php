<?php
function getInfoMachineAPI($input){
    $modelMachine= new Machine();
    $modelProduct= new Product();
    $modelLogtransaction= new Logtransaction();
    $dataSend= arrayMap($input['request']->data);

    if(!empty($dataSend['machineId'])){
        $saveLogtransaction['Logtransaction']= array('api'=>'getInfoMachineAPI','data'=>$dataSend,'time'=>time());
        $modelLogtransaction->save($saveLogtransaction);

        $machine  = $modelMachine->getMachineCode($dataSend['machineId'],array('floor','settingFloor','code'));
        //$accessToken = getGUID();
        if(!empty($machine['Machine']['floor'])){
            $listFloor= convertConfigMachine($machine,'getInfoMachineAPI');
            
            $return= array('code'=>0,'machine'=>$listFloor);
        }else{
            $return= array('code'=>1,'machine'=>array());
        }
    }else{
        $return= array('code'=>2,'machine'=>array());
    }

    echo json_encode($return);
}

function updateConfigMachineAPI($input){
    $modelMachine= new Machine();
    $modelProduct= new Product();
    $modelLogtransaction= new Logtransaction();

    $dataSend= $input['request']->data;

    if(!empty($dataSend['machine'])){
        $saveLogtransaction['Logtransaction']= array('api'=>'updateConfigMachineAPI','data'=>$dataSend,'time'=>time());
        $modelLogtransaction->save($saveLogtransaction);

        $dataSend= json_decode($dataSend['machine'],true);

        //$codeMachine= str_replace('Machine_', '', $dataSend['name']);
        $codeMachine= $dataSend['name'];
        $machine  = $modelMachine->getMachineCode($codeMachine,array('floor'));

        $floor= array();
        if(!empty($dataSend['khays'])){
            foreach($dataSend['khays'] as $khay){
                $idKhay= str_replace('Khay_', '', $khay['name']);
                $floor[$idKhay]= array();

                if(!empty($khay['slots'])){
                    foreach($khay['slots'] as $slot){
                        $idTrench= str_replace('Khay_'.$idKhay.'_Slot_', '', $slot['name']);

                        if(empty($listProduct[$slot['GoodCode']])){
                            $listProduct[$slot['GoodCode']]= $modelProduct->getProductCode($slot['GoodCode'],array('name','code','priceOutput'));
                        }
                        $floor[$idKhay][]= array(   'numberProduct'=>$slot['GoodCount'],
                            'idProduct'=>@$listProduct[$slot['GoodCode']]['Product']['id'],
                            'priceProduct'=>$slot['GoodPrice'],
                            'codeProduct'=>$slot['GoodCode'],
                            'idTrench'=> (int)$idTrench,
                            'numberLoxo'=>(int)@$slot['GoodMaxCount'],
                        );
                    }
                }
            }
        }

        $save['$set']['floor']= $floor;
        $dk= array('code'=>$codeMachine);
        
        if($modelMachine->updateAll($save,$dk)){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>2);
        }
        
    }else{
        $return= array('code'=>1);
    }

    echo json_encode($return);
}
// --------------function saveTransferAPI--------------
// * Ngay tao:
// * Ghi chú:
//    - status=1  mua hàng thành công, status=2 mua hàng thắt bại , status=3 chờ thanh toán , status=4 chờ trả hàng
// * Mục đích: lưu dữ liệu giao dịch được gửi lên từ máy kiosk
// * Lịch sử sửa:
//  + Lần sửa: v1
//  + Ngay: 22/08/2018
//  + Người sửa: Hưng
//  + Nội dung sửa:
//    - Bỏ array đẻ fix lỗi không nhận dược dữ liệu sau giao dich
//    - Sửa điều kiện update số lượng coupon và giá trị coupon.
//    - Thêm phần update giá trị coupon sau khi giao dịch.
// --------------------------------------------------
// status=1  mua hàng thành công, status=2 mua hàng thắt bại , status=3 chờ thanh toán , status=4 chờ trả hàng
function saveTransferAPI($input){
    global $urlHomes;
    global $modelOption;

    $modelTransfer= new Transfer();
    $modelMachine= new Machine();
    $modelCoupon=new Coupon();
    $modelProduct= new Product();
    $modelLogtransaction= new Logtransaction();
    $modelPlace= new Place();
    $modelPatner= new Patner();

    // $dataSend = arrayMap($input['request']->data);
    $dataSend = $input['request']->data;

    if(!empty($dataSend)){
        $saveLogtransaction['Logtransaction']= array('api'=>'saveTransferAPI','data'=>$dataSend,'time'=>time());
        $modelLogtransaction->save($saveLogtransaction);

        $checkTransfer= $modelTransfer->find('first',array('conditions'=>array('transactionId'=>$dataSend['transactionId'],'idMachine'=>$dataSend['machineId'],'status'=>(int) $dataSend['status'],'slotId'=>(int) $dataSend['slotId'])));

        if(empty($checkTransfer)){
	        $machine = $modelMachine->getMachineCode($dataSend['machineId'],array('code','floor','idPlace','assetCode','idStaff'));
	        if(!empty($dataSend['coupon'])){
	            $coupon=$modelCoupon->getCouponCode($dataSend['coupon']);      
	        }

	        $slot= array();
	        $product= array();
	        if(!empty($dataSend['slotId'])){
	            if(!empty($machine['Machine']['floor'])){
	                $slotId= $dataSend['slotId']%10;
	                $khayId= ($dataSend['slotId']-$slotId)/10;
	                $dem=0;
	                foreach($machine['Machine']['floor'] as $keyFloor=>$floor){
	                    $dem++;
	                    if($dem==$khayId){
	                        foreach($floor as $keyTrench=>$trench){
	                            if($trench['idTrench']==$slotId){
	                                $slot= $trench;
	                                $product=$modelProduct->getProduct($trench['idProduct']);  

	                                if($dataSend['status']==1){
	                                    $machine['Machine']['floor'][$keyFloor][$keyTrench]['numberProduct'] -= $dataSend['quantity'];
	                                    $dkMachine= array('_id'=>new MongoId($machine['Machine']['id']) );
	                                    $saveMachine['$set']['floor']= $machine['Machine']['floor'];
	                                    $modelMachine->updateAll($saveMachine,$dkMachine);
	                                }
	                                break;
	                            }
	                        }
	                        break;
	                    }
	                    
	                }
	            }
	            
	        }

	        if(!empty($machine)){
	            if(!empty($machine['Machine']['idPlace'])){
	                $dataPlace= $modelPlace->getPlace($machine['Machine']['idPlace'],array('idPatner','area','idCity','idDistrict','wards','numberHouse','idChannel'));

	                // if(!empty($dataPlace['Place']['idPatner'])){
	                //     $dataPatner= $modelPatner->getPatner($dataPlace['Place']['idPatner'],array('idChannel'));
	                // }
	            }

	            //$dataSend['transactionId']= $machine['Machine']['assetCode'].$dataSend['transactionId'];  

	            //$save= $modelTransfer->getTransferByTransaction($dataSend['machineId'],$dataSend['transactionId']);
	            if(!empty($dataSend['transferId'])){
	                $save= $modelTransfer->getTransfer($dataSend['transferId']);
	            }
	            $typePay=(int)@$dataSend['typePay'];

	            if(empty($save)){
	                $numberOrderKiosk= $modelOption->getOption('numberOrderKiosk');
	                if(empty($numberOrderKiosk['Option']['value'])) $numberOrderKiosk['Option']['value']= 0;
	                $numberOrderKiosk['Option']['value']++;
	                $modelOption->saveOption('numberOrderKiosk', $numberOrderKiosk['Option']['value']);

	                $save['Transfer']['orderId']= (int) $numberOrderKiosk['Option']['value'];
	                $save['Transfer']['typedateEndPay']=$typePay; 
	            }

	            $save['Transfer']['timeServer']= time();
	            $save['Transfer']['timeClient']= (int) $dataSend['time'];
	            $save['Transfer']['idProduct']= @$product['Product']['id'];
	            $save['Transfer']['codeProduct']= @$product['Product']['code'];
	            $save['Transfer']['quantity']= (int) $dataSend['quantity'];
	            $save['Transfer']['moneyCalculate']= (int) $dataSend['moneyCalculate'];
	            $save['Transfer']['moneyInput']= (int) $dataSend['moneyInput'];
	            $save['Transfer']['moneyAvailable']= (int) $dataSend['moneyAvailable'];
	            $save['Transfer']['idMachine']= $machine['Machine']['id'];
	            $save['Transfer']['codeMachine']= $machine['Machine']['code'];
	            $save['Transfer']['transactionId']= $dataSend['transactionId'];   
	            $save['Transfer']['slotId']= (int) $dataSend['slotId'];   
	            $save['Transfer']['status']= (int) $dataSend['status'];
	            $save['Transfer']['coupon']= $dataSend['coupon'];   
	            $save['Transfer']['lock']= 0;

	            $save['Transfer']['area']= @$dataPlace['Place']['area'];   
	            $save['Transfer']['idCity']= @$dataPlace['Place']['idCity'];   
	            $save['Transfer']['idDistrict']= @$dataPlace['Place']['idDistrict'];   
	            $save['Transfer']['wards']= @$dataPlace['Place']['wards'];   
	            $save['Transfer']['numberHouse']= @$dataPlace['Place']['numberHouse'];   
	            $save['Transfer']['idChannel']= @$dataPlace['Place']['idChannel'];   
	            $save['Transfer']['idPlace']= @$dataPlace['Place']['id'];   
	            $save['Transfer']['idStaff']= @$machine['Machine']['idStaff'];   
	            
	            // if($typePay==3){
	            //     // $time=time()-86400;
	            //     if(!empty($coupon)&&($coupon['Coupon']['status']=='active')&&($coupon['Coupon']['dateEnd']['time']>time())&&($coupon['Coupon']['idProduct']==$product['Product']['id'])){
	            //         if($coupon['Coupon']['quantity']!=$coupon['Coupon']['quantityActive']){
	            //             $coupon['Coupon']['quantityActive']=$coupon['Coupon']['quantityActive']+1;
	            //             $modelCoupon->save($coupon['Coupon']);
	            //             // $modelCoupon->updateAll($data['Coupon'],$dk);$data['Coupon']['quantityActive']=$coupon['Coupon']['quantityActive']+1;
	            //             // $dk= array('_id'=>new mongoId($coupon['Coupon']['id']));
	            //             // $modelCoupon->updateAll($data['Coupon'],$dk);
	            //         }
	            //     }
	            // }
                if($typePay==3){
                     $time=time();
                    if($dataSend['status']==1) { // sửa điều kiện update số lượng coupon và giá trị coupon.
                            $coupon['Coupon']['quantityActive']=$coupon['Coupon']['quantityActive']+1;
                            $coupon['Coupon']['usedvalue']=$coupon['Coupon']['usedvalue']+$dataSend['moneyCalculate']; //thêm phần update giá trị coupon sau khi giao dịch.
                            $modelCoupon->save($coupon['Coupon']);

                    }
                }
                // if($typePay==3){
                //     // $time=time()-86400;
                //     if(!empty($coupon)&&($coupon['Coupon']['status']=='active')&&($coupon['Coupon']['dateEnd']['time']>$time)&&( ($coupon['Coupon']['idProduct']==$product['Product']['id']) || ($coupon['Coupon']['idPlace']==$data['Place']['id']) || ($coupon['Coupon']['idMachine']==$machine['Machine']['id']) ) ){
                //         if($coupon['Coupon']['quantity']!=$coupon['Coupon']['quantityActive']){
                //             $coupon['Coupon']['quantityActive']=$coupon['Coupon']['quantityActive']+1;
                //             $modelCoupon->save($coupon['Coupon']);
                //             // $modelCoupon->updateAll($data['Coupon'],$dk);$data['Coupon']['quantityActive']=$coupon['Coupon']['quantityActive']+1;
                //             // $dk= array('_id'=>new mongoId($coupon['Coupon']['id']));
                //             // $modelCoupon->updateAll($data['Coupon'],$dk);
                //         }
                //     }
                // }
	            if($modelTransfer->save($save)){
	                $idTransfer= (!empty($save['Transfer']['id']))?$save['Transfer']['id']:$modelTransfer->getLastInsertId();
	                $return = array('code'=>0,'TransferId'=>$idTransfer);

	                if($dataSend['status']==1){
	                    $product['Product']['quantity']=$product['Product']['quantity']-$dataSend['quantity'];
	                    // $dk= array('_id'=>new mongoId($product['Product']['id']));
	                    // $modelProduct->updateAll($product['Product'],$dk);
	                    $modelProduct->save($product['Product']);
	                }
	            }else{
	                $return = array('code'=>1);
	            }
	        }else{
	            $return = array('code'=>-1);
	        }
	    }else{
	    	$return = array('code'=>-3);
	    }
    }else{
        $return = array('code'=>-2);
    }

    echo json_encode($return);
}

function updateStatusMachineAPI($input)
{
    $modelMachine= new Machine();
    $modelErrormachine = new Errormachine;
    $modelPlace= new Place();
    $modelLogtransaction= new Logtransaction();

    $dataSend = arrayMap($input['request']->data);

    $saveLogtransaction['Logtransaction']= array('api'=>'updateStatusMachineAPI','data'=>$dataSend,'time'=>time());
    $modelLogtransaction->save($saveLogtransaction);

    $machine=$modelMachine->getMachineCode($dataSend['code'],array('idPlace','code'));
    $time=date('D/M/Y');
    $save['$set']['status']= (int) $dataSend['status'];
    $save['$set']['codeError']= $dataSend['codeError'];
    $save['$set']['timeError']= time();
    $save['$set']['parameter']['door']= (int) $dataSend['Door'];
    $save['$set']['parameter']['temp']= (double) $dataSend['Temp'];
    $save['$set']['parameter']['vibra']= (double) $dataSend['Vibra'];

    $dk= array('code'=>$dataSend['code']);
   // $modelMachine->updateAll($save,$dk);
    if($modelMachine->updateAll($save,$dk)){
        if($dataSend['status']==3){
            if(!empty($machine['Machine']['idPlace'])){
                $place=$modelPlace->getPlace($machine['Machine']['idPlace'],array('idCity'));
            }
            $data['Error']['codeMachine']=$machine['Machine']['code'];
            $data['Error']['idMachine']=$machine['Machine']['id'];
            $data['Error']['codeError']=$dataSend['codeError'];
            $data['Error']['name']=isset($dataSend['name'])?$dataSend['name']:'';
            $data['Error']['note']=isset($dataSend['note'])?$dataSend['note']:'';
            $data['Error']['nameTechnicians']=isset($dataSend['nameTechnicians'])?$dataSend['nameTechnicians']:'';
            $data['Error']['dayError']=$time;
            $data['Error']['dayReportError']=$time;
            $data['Error']['dayStart']=isset($dataSend['dayStart'])?$dataSend['dayStart']:'';
            $data['Error']['dayEnd']=$dataSend['dayEnd'];
            $data['Error']['status']=(int)$dataSend['status'];
            $data['Error']['idCity']=isset($place['Place']['idCity'])?$place['Place']['idCity']:'';
            $data['Error']['delete']='false';
            $data['Error']['slug']['codeMachine']=createSlugMantan($machine['Machine']['code']);
            $data['Error']['slug']['codeError']=createSlugMantan(trim($dataSend['codeError']));
            $data['Error']['parameter']['door']= (int) $dataSend['Door'];
            $data['Error']['parameter']['temp']= (double) $dataSend['Temp'];
            $data['Error']['parameter']['vibra']= (double) $dataSend['Vibra'];
            $modelError->save($data);
        }
    }

}

// thu tiền tại máy
function saveCollectionAPI($input){
    global $urlHomes;
    $modelCollection= new Collection();
    $modelMachine= new Machine();
    $modelStaff= new Staff;
    $modelLogtransaction= new Logtransaction();

    $dataSend = $input['request']->data;

    $saveLogtransaction['Logtransaction']= array('api'=>'saveCollectionAPI','data'=>$dataSend,'time'=>time());
    $modelLogtransaction->save($saveLogtransaction);

    $machine = $modelMachine->getMachineCode($dataSend['machineId'],array('code','idPlace','idStaff','codeStaff'));
    $staff=$modelStaff->getStaffByCode($dataSend['staffCode'],array('code','fullName','id'));
    
    //if(!empty($machine)&&!empty($staff)){
    if(!empty($machine)){
        $save['Collection']['timeServer']= time();
        $save['Collection']['timeClient']= (int) $dataSend['actionTime']; // thời gian thu tiền
        $save['Collection']['startTime']= (int) $dataSend['startTime']; // thời gian bắt đầu phiên
        $save['Collection']['moneyCalculate']= (int) str_replace('.', '', $dataSend['moneyCalculate']);
        $save['Collection']['money']= (int) str_replace('.', '', $dataSend['money']);
        $save['Collection']['idMachine']= $machine['Machine']['id'];
        $save['Collection']['codeMachine']= $machine['Machine']['code'];    
        $save['Collection']['idPlace']= $machine['Machine']['idPlace'];    
        $save['Collection']['codeStaff']= (isset($staff['Staff']['code']))?$staff['Staff']['code']:@$machine['Machine']['codeStaff'];
        $save['Collection']['idStaff']= (isset($staff['Staff']['id']))?$staff['Staff']['id']:@$machine['Machine']['idStaff'];
        $save['Collection']['saleSessionId']= (int) $dataSend['id'];
        $save['Collection']['slug']= array('codeMachine'=>createSlugMantan($machine['Machine']['code'])); 
        
        if($modelCollection->save($save)){
            $idCollection= $modelCollection->getLastInsertId();
            $return = array('code'=>0,'idCollection'=>$idCollection);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }

    echo json_encode($return);
}
//check thu tiền hàng ngày tại máy
/*
function checkCollectionHistoryAPI($input)
{
    global $urlHomes;
    $modelTransfer= new Transfer();
    $modelMachine= new Machine();
    $modelCoupon=new Coupon;
    $modelProduct= new Product;
    $modelStaff= new Staff;
    $modelCollection= new Collection();
    $dataSend = arrayMap($input['request']->data);
    $machine=$modelMachine->getMachineCode($dataSend['code'],array('code','priceMachine','codeStaff','idStaff'));
    $staff=$modelStaff->getStaffByCode($dataSend['codeStaff'],array('code','fullName','id'));
    if(!empty($machine)&&!empty($staff)){
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions['codeMachine']=$dataSend['code'];
        $order = array('created' => 'desc');
        $return= $modelCollection->getPage($page, $limit , $conditions, $order,array());        
    }else{
        $return = array('code'=>-1);
    }
    echo json_encode($return);
}
*/

// get QR Vietinbank
function getQRVietinbankAPI($input)
{
    global $urlHomes;
    global $modelOption;
    include_once('files/phpseclib1.0.9/Math/BigInteger.php');
    include_once('files/phpseclib1.0.9/Crypt/RSA.php');

    $modelTransfer= new Transfer();
    $modelMachine= new Machine();
    $modelCoupon=new Coupon();
    $modelProduct= new Product();
    $modelLogtransaction= new Logtransaction();
    $modelPlace= new Place();
    $modelPatner= new Patner();
    $modelLogbank= new Logbank();

    $dataSend = arrayMap($input['request']->data);

    $saveLogtransaction['Logtransaction']= array('api'=>'getQRVietinbankAPI','data'=>$dataSend,'time'=>time());
    $modelLogtransaction->save($saveLogtransaction);

    $machine = $modelMachine->getMachineCode($dataSend['machineId'],array('code','floor','assetCode','idStaff','idPlace'));

    $slot= array();
    $product= array();
    if(!empty($dataSend['slotId'])){
        if(!empty($machine['Machine']['floor'])){
            $slotId= $dataSend['slotId']%10;
            $khayId= ($dataSend['slotId']-$slotId)/10;
            $dem=0;
            foreach($machine['Machine']['floor'] as $keyFloor=>$floor){
                $dem++;
                if($dem==$khayId){
                    foreach($floor as $keyTrench=>$trench){
                        if($trench['idTrench']==$slotId){
                            $slot= $trench;
                            $product=$modelProduct->getProduct($trench['idProduct']);  

                            break;
                        }
                    }
                    break;
                }
                
            }
        }
        
    }

    if(!empty($machine)){
        if(!empty($machine['Machine']['idPlace'])){
            $dataPlace= $modelPlace->getPlace($machine['Machine']['idPlace'],array('idPatner','area','idCity','idDistrict','wards','numberHouse'));

            if(!empty($dataPlace['Place']['idPatner'])){
                $dataPatner= $modelPatner->getPatner($dataPlace['Place']['idPatner'],array('idChannel'));
            }
        }

        //$dataSend['transactionId']= $machine['Machine']['assetCode'].$dataSend['transactionId'];  

        $numberOrderKiosk= $modelOption->getOption('numberOrderKiosk');
        if(empty($numberOrderKiosk['Option']['value'])) $numberOrderKiosk['Option']['value']= 0;
        $numberOrderKiosk['Option']['value']++;
        $modelOption->saveOption('numberOrderKiosk', $numberOrderKiosk['Option']['value']);

        $typePay= 4;//(int)@$dataSend['typePay'];
        $save['Transfer']['timeServer']= time();
        $save['Transfer']['timeClient']= (int) $dataSend['time'];
        $save['Transfer']['idProduct']= @$product['Product']['id'];
        $save['Transfer']['codeProduct']= @$product['Product']['code'];
        $save['Transfer']['quantity']= (int) $dataSend['quantity'];
        $save['Transfer']['moneyCalculate']= (int) $dataSend['moneyCalculate'];
        $save['Transfer']['moneyInput']= (int) $dataSend['moneyInput'];
        $save['Transfer']['moneyAvailable']= (int) $dataSend['moneyAvailable'];
        $save['Transfer']['idMachine']= $machine['Machine']['id'];
        $save['Transfer']['codeMachine']= $machine['Machine']['code'];
        $save['Transfer']['typedateEndPay']=$typePay;    
        $save['Transfer']['transactionId']= $dataSend['transactionId'];   
        $save['Transfer']['slotId']= (int) $dataSend['slotId'];   
        $save['Transfer']['status']= 3;//(int) $dataSend['status'];
        $save['Transfer']['orderId']= (int) $numberOrderKiosk['Option']['value'];
        $save['Transfer']['lock']= 0;

        $save['Transfer']['area']= @$dataPlace['Place']['area'];   
        $save['Transfer']['idCity']= @$dataPlace['Place']['idCity'];   
        $save['Transfer']['idDistrict']= @$dataPlace['Place']['idDistrict'];   
        $save['Transfer']['wards']= @$dataPlace['Place']['wards'];   
        $save['Transfer']['numberHouse']= @$dataPlace['Place']['numberHouse'];   
        $save['Transfer']['idChannel']= @$dataPatner['Patner']['idChannel'];  
        $save['Transfer']['idPlace']= @$dataPlace['Place']['id'];  
        $save['Transfer']['idStaff']= @$machine['Machine']['idStaff'];    

        if($modelTransfer->save($save)){
            $idTransfer= $modelTransfer->getLastInsertId();
            $today= getdate();

            if($today['mon']<10) $today['mon']= '0'.$today['mon'];
            if($today['mday']<10) $today['mday']= '0'.$today['mday'];
            if($today['hours']<10) $today['hours']= '0'.$today['hours'];
            if($today['minutes']<10) $today['minutes']= '0'.$today['minutes'];
            if($today['seconds']<10) $today['seconds']= '0'.$today['seconds'];

            // gọi sang vietinbank để lấy mã QR
            $data['requestId']= (string) $numberOrderKiosk['Option']['value'];
            $data['payMethod']= 'QRPAY';
            $data['merchantId']= 'sabmerchant';
            $data['merchantName']= 'sab';
            $data['terminalId']= '0001';
            $data['productId']= (string) @$product['Product']['code'];
            $data['orderId']= (string) $numberOrderKiosk['Option']['value'];//$idTransfer;
            $data['amount']= (string) $dataSend['moneyCalculate'];//$dataSend['money'];
            $data['goodsType']= 'TOPUP';
            $data['transactionDate']= $today['year'].$today['mon'].$today['mday'].$today['hours'].$today['minutes'].$today['seconds'];
            $data['currencyCode']= 'VND';
            $data['channel']= 'MOBILE';
            $data['remark']= 'mua hang tai may ban hang tu dong '.$machine['Machine']['code'];
            $data['language']= 'vi';

            //$saveLogtransaction['Logtransaction']= array('api'=>'sendDataToVietinbank','data'=>$data,'time'=>time());
            //$modelLogtransaction->create();
            //$modelLogtransaction->save($saveLogtransaction);

            //$url= 'http://192.168.6.167:19080/mobile/qr/generateQrPaymentToken';
            $url= 'http://192.168.6.124:19080/mobile/qr/generateQrPaymentToken';

            $data_string = json_encode($data);   
            $privateKeyKiosk= file_get_contents(__DIR__.'/files/vms_sab_com_vn.key');
            $rsa = new Crypt_RSA();
			$rsa->loadKey($privateKeyKiosk); // private key
			$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
			$signature= $rsa->sign($data_string);
			$signature= base64url_encode($signature);                                                                                                                  
            $ch = curl_init($url);                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',       
                'signature: '.$signature,                                                                         
                'Content-Length: ' . strlen($data_string))                                                                  
            );                                                                                                                   
            //debug(curl_exec($ch));die;
            $dataQR = json_decode(curl_exec($ch),true);

            $saveLogbank['Logbank']= array('time'=>time(),'dataSend'=>$data_string,'dataGet'=>$dataQR,'bank'=>'vietinbank');
            $modelLogbank->save($saveLogbank); 
          	//debug($data_string);
          	//debug($signature);
          	//debug($dataQR);

            $return = array('code'=>0,'TransferId'=>$idTransfer,'qrcode'=>$dataQR['qrData']);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }

    echo json_encode($return);
}

// --------------function checkCouponAPI--------------
// * Ngay tao:
// * Mục đích: check mã coupon máy kiosk gửi lên.
// * Ghi chú:
// * Lịch sử sửa:
//  + Lần sửa: v1
//  + Ngay: 22/08/2018
//  + Người sửa: Hưng
//  + Nội dung sửa:
//    - Thêm điều kiện check mã coupon.
// --------------------------------------------------
function checkCouponAPI($input)
{
    global $urlHomes;
    global $modelOption;

    $modelMachine= new Machine();
    $modelCoupon=new Coupon();
    $modelLogtransaction= new Logtransaction();
    $modelPlace= new Place();
    $modelProduct= new Product();

    $dataSend = arrayMap($input['request']->data);

    $saveLogtransaction['Logtransaction']= array('api'=>'checkCouponAPI','data'=>$dataSend,'time'=>time());
    $modelLogtransaction->save($saveLogtransaction);

    $machine = $modelMachine->getMachineCode($dataSend['machineId'],array('idPlace','floor'));
    $coupon= $modelCoupon->getCouponCode($dataSend['coupon']);
    $return = array('code'=>1);
    $timeNow= time();

    if(!empty($machine['Machine']['idPlace'])){
        $place= $modelPlace->getPlace($machine['Machine']['idPlace']);

        if($place){
            $slot= array();
            $product= '';
            if(!empty($dataSend['slotId'])){
                if(!empty($machine['Machine']['floor'])){
                    $slotId= $dataSend['slotId']%10;
                    $khayId= ($dataSend['slotId']-$slotId)/10;
                    $dem=0;
                    foreach($machine['Machine']['floor'] as $keyFloor=>$floor){
                        $dem++;
                        if($dem==$khayId){
                            foreach($floor as $keyTrench=>$trench){
                                if($trench['idTrench']==$slotId){
                                    $slot= $trench;
                                    $product= $trench['idProduct'];
                                    break;
                                }
                            }
                            break;
                        }

                    }
                }

            }

            if($coupon && !empty($product) && $coupon['Coupon']['dateStart']['time']<=$timeNow && $coupon['Coupon']['dateEnd']['time']>=$timeNow && $coupon['Coupon']['status']=='active'&& $coupon['Coupon']['quantityActive']<$coupon['Coupon']['quantity'] && $coupon['Coupon']['value']>=($coupon['Coupon']['usedvalue'] +$dataSend['moneyCalculate'])){ // Thêm điều kiện check mã coupon.

                $check= true;
                if(!empty($coupon['Coupon']['idChannel']) && $coupon['Coupon']['idChannel']!=$place['Place']['idChannel']){
                    $check= false;
                }

                if(!empty($coupon['Coupon']['idPlace']) && $coupon['Coupon']['idPlace']!=$machine['Machine']['idPlace']){
                    $check= false;
                }

                if(!empty($coupon['Coupon']['idMachine']) && $coupon['Coupon']['idMachine']!=$machine['Machine']['id']){
                    $check= false;
                }

                if(!empty($coupon['Coupon']['idProduct']) && $coupon['Coupon']['idProduct']!=$product){
                    $check= false;
                }

                if($check){
                    $return = array('code'=>0);
                }else{
                    $return = array('code'=>1);
                }

            }
        }

    }

    echo json_encode($return);
}

function callBackVietinbankAPI($input)
{
    $modelTransfer= new Transfer();
    $modelMachine= new Machine();
    $modelProduct= new Product();
    $modelLogtransaction= new Logtransaction();
    $dataSend = file_get_contents("php://input");
    $dataSend = preg_replace('~[\r\n]+~', '', $dataSend);
    //$dataSendTest= $dataSend;
    include_once('files/phpseclib1.0.9/Math/BigInteger.php');
    include_once('files/phpseclib1.0.9/Crypt/RSA.php');
    $allHeader= getallheaders();
    $signatureVietinbank= $allHeader['signature']; ////
    
    $rsa = new Crypt_RSA();
    //debug($signatureVietinbank);
    //debug($dataSend);
    $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
    $signatureVietinbank= base64url_decode($signatureVietinbank);
    $publicKeyVietinbank= getPublicKeyVietinbank(); //\\
    //$publicKeyVietinbank= file_get_contents(__DIR__.'/files/vms_sab_com_vn.pub');
	$rsa->loadKey($publicKeyVietinbank); // public key
	$checkSignature= $rsa->verify($dataSend, $signatureVietinbank);
    //debug($publicKeyVietinbank);
    //var_dump($signatureVietinbank);
    //var_dump($checkSignature);
    if($checkSignature){

       $dataSend = json_decode($dataSend,true);

       $saveLogtransaction['Logtransaction']= array('api'=>'callBackVietinbankAPI','data'=>$dataSend,'time'=>time());
       $modelLogtransaction->save($saveLogtransaction);

       $data= $modelTransfer->getTransferByOrder($dataSend['orderId']);

       if($dataSend['statusCode']=='00'){
           if($data){
               $data['Transfer']['status']= 4;

               $modelTransfer->save($data);
           }
       }

       $dataSendKiosk= array('codeMachine'=>@$data['Transfer']['codeMachine'],'data'=>json_encode(array('transactionId'=>@$data['Transfer']['transactionId'],'statusPay'=>$dataSend['statusCode'])));
       //$dataSendKiosk= array('codeMachine'=>'00000000def65add','data'=>'["transactionId":1708]','statusPay'=>'00');
       
       $saveLogtransaction['Logtransaction']= array('api'=>'callBackKioskAPI','data'=>$dataSendKiosk,'time'=>time());
       $modelLogtransaction->create();
       $modelLogtransaction->save($saveLogtransaction);

       sendToKioskAPI($dataSendKiosk,'sendTransferToKiosk_server.php');

        // Kiosk ký
       $dataShow= json_encode(array('requestId'=>$dataSend['requestId'],'paymentStatus'=>'00'));
       $privateKeyKiosk= file_get_contents(__DIR__.'/files/vms_sab_com_vn.key');
       $rsa = new Crypt_RSA();
        $rsa->loadKey($privateKeyKiosk); // private key
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
        $signature= $rsa->sign($dataShow);
        //$signature= $rsa->sign($dataSendTest);
        $signature= base64url_encode($signature);  
        header('signature: '.$signature); //\\
        echo $dataShow;
        //echo $signature;
    }
}

function testSignatureAPI($input)
{
    include_once('files/phpseclib1.0.9/Math/BigInteger.php');
    include_once('files/phpseclib1.0.9/Crypt/RSA.php');

    $dataShow= 'hello';
    $privateKeyKiosk= file_get_contents(__DIR__.'/files/vms_sab_com_vn.key');
    $rsa = new Crypt_RSA();
    $rsa->loadKey($privateKeyKiosk); // private key
    $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
    $signature= $rsa->sign($dataShow);
    $signature= base64url_encode($signature);  
    echo $signature.'<br/><br/>';

    $rsa = new Crypt_RSA();
    $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
    $signatureVietinbank= base64url_decode($signature);
    $publicKeyVietinbank= file_get_contents(__DIR__.'/files/vms_sab_com_vn.pub');
    $rsa->loadKey($publicKeyVietinbank); // public key
    $checkSignature= $rsa->verify($dataShow, $signatureVietinbank);
    var_dump($checkSignature);
}

function testAPI($input)
{
	$dataSendKiosk= array('codeMachine'=>'00000000def65add','data'=>'["transactionId":493]','statusPay'=>'00');
	sendToKioskAPI($dataSendKiosk,'sendTransferToKiosk_server.php');
}
// --------------function priceSaleAPI--------------
// * Ngày tạo: tháng 1 năm 2019
// * Mục đích: truy vấn giá bán riêng tại bảng sellProduct để gửi tổng giá phải trả của 1 đơn hàng cho máy kiosk (khi máy kiosk có giao dịch và gửi thông tin đơn hàng lên).
// * Ghi chú:
// * Lịch sử sửa:
//  + Lần sửa: v1
//  + Ngay: 25/02/2019
//  + Người sửa: Báo
//  + Nội dung sửa:
//    - Thêm điều kiện check các chương trình giảm giá đang được kích hoạt tại bảng sale.
// --------------------------------------------------
function priceSaleAPI($input){
    $modelSellProduct = new SellProduct;
    $modelSale = new Sale;
    $modelProduct = new Product;
    $modelLog = new Log;
    //pr($dataSend);
    $dataSend=arrayMap($input['request']->data);
    // $dataSend= $input['request']->data;
    $saveLog['Log']['api']='priceSaleAPI';
    $saveLog['Log']['data']= $dataSend;
    $modelLog->save($saveLog);

    if(!empty($dataSend)){
        $priceSale='';
        // truy vấn lấy giá bán ở bảng product
        $product=$modelProduct->getProductCode($dataSend['goodId']);
        // lấy giá nhân với số lượng để tính tổng tiền
        $price=$product['Product']['priceOutput']*$dataSend['quantity'];
        $priceSale=$price;
        $conditionsSale['dateStart']['$lte'] = (int)$dataSend['time'];
        $conditionsSale['dateEnd']['$gte'] = (int)$dataSend['time'];
        $conditionsSale['lock'] = (int)0;

        $listSale = $modelSale->find('first', array('conditions'=>$conditionsSale));
        if (!empty($listSale)) {
           $reducedValue = $price/100*$listSale['Sale']['value'];
           if (!empty($listSale['Sale']['maxValue']) && $listSale['Sale']['maxValue'] < $reducedValue) {
               $reducedValue = $listSale['Sale']['maxValue'];
           }
           $priceSale -= $reducedValue;
        }
        /*
        truy vấn bảng sale với điều kiện
        ngày bắt đầu nhỏ hơn hoặc bằng thời gian giao dịch
        ngày kết thúc lớn hơn hoặc bằng thời gian giao dịch
        hình thức thanh toán có trong bảng sale
        các mã máy dược áp dụng (nếu có)
        sau khi có được các bản ghi thỏa mãn điều kiện
        lấy giá * số lượng để ra tổng giá trị
        sau đó lấy tổng giá trị trừ đi % được giảm
        cuối cùng trả kết quả cho máy kiosk
        */
        $conditions['code']=$dataSend['goodId'];
        $conditions['lock']=0;
        // truy vấn giá riêng trong bảng sellProduct theo điều kiện
        $sellProduct= $modelSellProduct->find('all',array('conditions'=>$conditions));
        // nếu tìm thấy sản phẩm
        if(!empty($sellProduct)){
            // lặp qua từng bản ghi
            foreach ($sellProduct as  &$value) {
                // nếu mã máy gửi lên nằm trong các mã máy được áp dụng
                if (in_array($dataSend['machineId'], $value['SellProduct']['codeMachine'])) {
                    // lấy giá riêng nhân với số lượng (đc gửi lên từ máy kiosk) để tính giá phải trả cuối cùng
                    $priceSale=$value['SellProduct']['priceSale']*(int)$dataSend['quantity'];
                    // nếu giá riêng ko áp dụng cho hình thức thanh toán này thì bỏ giá riêng này đi
                    if(!empty($value['SellProduct']['typePay']) && in_array($dataSend['typePay'],$value['SellProduct']['typePay'])==false){
                        $priceSale=$price;
                    }
                    // nếu thời điểm áp dụng giá bán riêng chưa đến thì loại bỏ giá bán riêng này đi
                    if(!empty($value['SellProduct']['dateStart']) && (int)$dataSend['time']<$value['SellProduct']['dateStart']){
                        $priceSale=$price;
                    }
                    // nếu đã quá thời hạn áp dụng thì bỏ giá bán riêng này đi
                    if(!empty($value['SellProduct']['dateEnd']) && (int)$dataSend['time']>$value['SellProduct']['dateEnd']){
                        $priceSale=$price;
                    }
                } // end if (in_array($dataSend['machineId'], $value['SellProduct']['codeMachine']))
            } // end foreach
        } // end if(!empty($sellProduct))
        $return=array(
            'codeMachine' => $dataSend['machineId'],
            'codeProduct' => $dataSend['goodId'],
            'quantity' => $dataSend['quantity'],
            'priceSale'=>$priceSale
        );
    } // end if(!empty($dataSend))
    else{
        $return=array('priceSale'=>-1);
    }
    echo json_encode($return);
}
?>