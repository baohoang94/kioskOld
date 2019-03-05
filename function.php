<?php
// --------------file function--------------
// * Người tạo:
// * Ngay tao:
// * Ghi chú:
// * Mục đích: Chứa các biến global và các biến dùng cho phần phân quyền.
// * Lịch sử sửa:ngày 11/10/2018.
// * Người sửa: Nguyễn Tiến Hưng.
// * Lưu ý: Sửa tại dòng số 77, id của 2 chức năng tại dòng số 76 và 77 trùng nhau(đều bằng 5)=> đưa id tại dòng 77 thành 6.
$menus = array();
$menus[0]['title'] = 'Quản lý Kiosk';

$menus[0]['sub'][0] = array('name' => 'Danh sách nhân viên', 'url' => $urlPlugins . 'admin/kiosk-admin-staff-listStaff.php','permission'=>'listHotelAdmin');
$menus[0]['sub'][1] = array('name' => 'Danh sách Tỉnh/Thành phố', 'url' => $urlPlugins . 'admin/kiosk-admin-city-listCityAdmin.php','permission'=>'listCityAdmin');
$menus[0]['sub'][3] = array('name' => 'Danh sách nhà cung cấp', 'url' => $urlPlugins . 'admin/kiosk-admin-supplier-listSupplier.php','permission'=>'listSupplier');
$menus[0]['sub'][4] = array('name' => 'Danh sách ngành hàng', 'url' => $urlPlugins . 'admin/kiosk-admin-category-listCategory.php','permission'=>'listCategory');
$menus[0]['sub'][5] = array('name' => 'Danh sách kênh bán hàng', 'url' => $urlPlugins . 'admin/kiosk-admin-channel-listChannel.php','permission'=>'listChannel');
$menus[0]['sub'][6] = array('name' => 'Danh sách NCC điểm đặt', 'url' => $urlPlugins . 'admin/kiosk-admin-patner-listPatnerAdmin.php','permission'=>'listPatnerAdmin');
$menus[0]['sub'][7]= array(  'name'=>'Cài đặt lỗi máy',
    'url'=>$urlPlugins.'admin/kiosk-admin-error-listCategoryError1.php',
    'sub'=>array( array('name'=>'Nhóm lỗi','url'=>$urlPlugins.'admin/kiosk-admin-error-listCategoryError.php','permission'=>'listCategoryError'),
       array('name'=>'Danh sách lỗi','url'=>$urlPlugins.'admin/kiosk-admin-error-listErrorAdmin.php','permission'=>'listErrorAdmin'),
   ) ,
    'permission'=>'SyncDatabaseProduct'
);
$menus[0]['sub'][8] = array('name' => 'Lịch sử hoạt động', 'url' => $urlPlugins . 'admin/kiosk-admin-log-listLog.php','permission'=>'listLog');
$menus[0]['sub'][9] = array('name' => 'Test dữ liệu', 'url' => $urlPlugins . 'admin/kiosk-admin-test-test.php','permission'=>'test');
addMenuAdminMantan($menus);

global $listArea;
global $listManagementAgency;
global $listStatusMachine;
global $listTypePay;
global $listPermission;
global $listStatusErrorMachine;
global $listStatusCoupon;
global $listStatusPay;
// global $listChannel;
//
// $listChannel=array(
//   '2'=>array('id'=>2,'name'=>'Trường học'),
//   '3'=>array('id'=>3,'name'=>'Bệnh viện'),
//   '4'=>array('id'=>4,'name'=>'Công cộng'),
//   '5'=>array('id'=>5,'name'=>'Văn phòng'),
//   '6'=>array('id'=>6,'name'=>'Khu đô thị'),
//   '7'=>array('id'=>7,'name'=>'Khu công nghiệp'),
//   '9'=>array('id'=>9,'name'=>'Tòa nhà'),
//   '10'=>array('id'=>10,'name'=>'Công ty')
// );

$listStatusPay=array(
    '0'=>array('id'=>0,'name'=>'Lỗi máy Kiosk'),
    '1'=>array('id'=>1,'name'=>'Thành công'),
    '2'=>array('id'=>2,'name'=>'Thất bại'),
    '3'=>array('id'=>3,'name'=>'Chờ thanh toán'),
    '4'=>array('id'=>4,'name'=>'Chờ trả hàng'),
    '5'=>array('id'=>5,'name'=>'Hủy giao dịch'),
    '6'=>array('id'=>6,'name'=>'Timeout'),
);

$listArea= array('1'=>array('id'=>1,'name'=>'Miền Bắc'),
    '2'=>array('id'=>2,'name'=>'Miền Trung'),
    '3'=>array('id'=>3,'name'=>'Miền Nam')
);

$listManagementAgency= array('1'=>array('id'=>1,'name'=>'Hội sở'),
    '2'=>array('id'=>2,'name'=>'Chi nhánh'),
    '3'=>array('id'=>3,'name'=>'Đại lý'),
);

$listStatusMachine= array('1'=>array('id'=>1,'name'=>'Đang sử dụng'),
  '2'=>array('id'=>2,'name'=>'Cất trong kho'),
  '3'=>array('id'=>3,'name'=>'Máy bị lỗi'),
);
// hình thức thanh toán
$listTypePay=array('1'=>array('id'=>1,'name'=>'Tiền mặt'),
    '2'=>array('id'=>2,'name'=>'Ví điện tử VTC'),
    '3'=>array('id'=>3,'name'=>'Mã Coupon'),
    '4'=>array('id'=>4,'name'=>'QR VietinBank'),
);
$listPermission= array(
	'1'=>array(	'id'=>1,
        'name'=>'Quản lý máy Kiosk',
        'sub'=>array(	'1'=>array('id'=>1,'name'=>'Xem danh sách máy Kiosk','permission'=>'listMachine'),
         '2'=>array('id'=>2,'name'=>'Thêm mới - Sửa thông tin máy Kiosk','permission'=>'addMachine'),
         '3'=>array('id'=>3,'name'=>'Xem thông tin máy Kiosk','permission'=>'infoMachine'),
         '4'=>array('id'=>4,'name'=>'Xóa thông tin máy Kiosk','permission'=>'deleteMachine'),
         '5'=>array('id'=>5,'name'=>'Cấu hình máy Kiosk','permission'=>'structureMachine'),
         '6'=>array('id'=>6,'name'=>'Xem bản đồ máy Kiosk','permission'=>'mapDevice'), //sửa tại đây.
         '12'=>array('id'=>12,'name'=>'Gửi cấu hình xuống máy Kiosk','permission'=>'sendConfigToKiosk'),
         '13'=>array('id'=>13,'name'=>'Tra cứu sản phẩm theo máy','permission'=>'listProductByMachine'),
     )
    ),
    '3'=>array( 'id'=>3,
        'name'=>'Quản lý khay hàng',
        'sub'=>array(   '9'=>array('id'=>9,'name'=>'Thêm mới khay hàng','permission'=>'addFloorMachine'),
            '10'=>array('id'=>10,'name'=>'Cài đặt khay hàng','permission'=>'settingFloorMachine'),
            '11'=>array('id'=>11,'name'=>'Xóa khay hàng','permission'=>'deleteFloor'),
        )
    ),
    '2'=>array(	'id'=>2,
        'name'=>'Quản lý Slot',
        'sub'=>array(	'6'=>array('id'=>6,'name'=>'Thêm mới slot','permission'=>'addTrench'),
         '7'=>array('id'=>7,'name'=>'Sửa thông tin slot','permission'=>'infoTrench'),
         '8'=>array('id'=>8,'name'=>'Xóa slot','permission'=>'deleteTrench'),
     )
    ),
    '4'=>array(	'id'=>4,
        'name'=>'Quản lý sản phẩm',
        'sub'=>array(	'15'=>array('id'=>15,'name'=>'Danh sách sản phẩm','permission'=>'listProduct'),
         '16'=>array('id'=>16,'name'=>'Thêm mới - Sửa sản phẩm','permission'=>'addProduct'),
         '17'=>array('id'=>17,'name'=>'Xem thông tin sản phẩm','permission'=>'infoProduct'),
         '18'=>array('id'=>18,'name'=>'Xóa sản phẩm','permission'=>'deleteProduct'),
     )
    ),
    '5'=>array(	'id'=>5,
        'name'=>'Quản lý điểm đặt',
        'sub'=>array('19'=>array(	'id'=>19,'name'=>'Danh sách điểm đặt','permission'=>'listPlace'),
          '20'=>array('id'=>20,'name'=>'Thêm mới - Sửa điểm đặt','permission'=>'addPlace'),
          '21'=>array('id'=>21,'name'=>'Xem thông tin điểm đặt','permission'=>'infoPlace'),
          '22'=>array('id'=>22,'name'=>'Xóa điểm đặt','permission'=>'deletePlace'),
      )
    ),
    '6'=>array(	'id'=>6,
        'name'=>'Quản lý lỗi',
        'sub'=>array(	'13'=>array('id'=>13,'name'=>'Danh sách máy lỗi','permission'=>'listMachineError'),
            '23'=>array('id'=>23,'name'=>'Danh sách lỗi','permission'=>'listErrorMachine'),
            '24'=>array('id'=>24,'name'=>'Thêm - Sửa thông tin lỗi','permission'=>'addErrorMachine'),
            '25'=>array('id'=>25,'name'=>'Xóa thông tin lỗi','permission'=>'deleteErrorMachine'),
            '67'=>array('id'=>67,'name'=>'Xem thông tin lỗi','permission'=>'infoErrorMachine'),
        )
    ),
    '7'=>array(	'id'=>7,
        'name'=>'Tra cứu',
        'sub'=>array(	'26'=>array('id'=>26,'name'=>'Lịch sử giao dịch','permission'=>'listTransfer'),
         '27'=>array('id'=>27,'name'=>'Xem chi tiết lịch sử giao dịch','permission'=>'viewTransfer'),
				 '28'=>array('id'=>28,'name'=>'Tra cứu máy không có giao dịch','permission'=>'machinesTransfer'),
				 '30'=>array('id'=>30,'name'=>'Đối soát dữ liệu','permission'=>'syncTransfer'),
				 '31'=>array('id'=>31,'name'=>'upload dữ liệu đối soát','permission'=>'syncTransferUpload'),
							    // '32'=>array('id'=>32,'name'=>'Danh sách giao dịch QR VietinBank','permission'=>'transactionWhitQRViettin'),
         '29'=>array('id'=>29,'name'=>'Lịch sử thu tiền tại máy','permission'=>'listCollection'),

     )
    ),
    '8'=>array(	'id'=>8,
        'name'=>'Quản lý mã Coupon',
        'sub'=>array(	'33'=>array('id'=>33,'name'=>'Danh sách mã Coupon','permission'=>'listCoupon'),
         '34'=>array('id'=>34,'name'=>'Thêm mới - Sửa mã coupon','permission'=>'addCoupon'),
         '35'=>array('id'=>35,'name'=>'Xóa mã Coupon','permission'=>'deleteCoupon'),
         '68'=>array('id'=>68,'name'=>'Xem thông tin mã Coupon','permission'=>'infoCoupon'),
         '69'=>array('id'=>69,'name'=>'Upload coupon','permission'=>'uploadCoupon'),
     )
    ),
    '9'=>array(	'id'=>9,
        'name'=>'Quản lý công ty',
        'sub'=>array(	'36'=>array('id'=>36,'name'=>'Danh sách công ty','permission'=>'listCompany'),
         '37'=>array('id'=>37,'name'=>'Thêm mới - Sửa công ty','permission'=>'addCompany'),
         '38'=>array('id'=>38,'name'=>'Xóa công ty','permission'=>'deleteCompany'),
         '39'=>array('id'=>39,'name'=>'Xem thông tin công ty','permission'=>'viewCompany'),

         '40'=>array('id'=>40,'name'=>'Danh sách chi nhánh','permission'=>'listBranch'),
         '41'=>array('id'=>41,'name'=>'Thêm mới - Sửa chi nhánh','permission'=>'addBranch'),
         '42'=>array('id'=>42,'name'=>'Xóa chi nhánh','permission'=>'deleteBranch'),

         '43'=>array('id'=>43,'name'=>'Danh sách khối phòng ban','permission'=>'groupPermission'),
         '44'=>array('id'=>44,'name'=>'Thêm mới - Sửa khối phòng ban','permission'=>'addPermission'),
         '45'=>array('id'=>45,'name'=>'Xóa khối phòng ban','permission'=>'deletePermission'),
         '46'=>array('id'=>46,'name'=>'Phân quyền cho nhân viên','permission'=>'permissionStaff'),

         '47'=>array('id'=>47,'name'=>'Danh sách nhân viên theo công ty','permission'=>'listStaffCompany'),
         '48'=>array('id'=>48,'name'=>'Thêm mới - Sửa nhân viên','permission'=>'addStaffCompany'),
         '49'=>array('id'=>49,'name'=>'Khóa nhân viên theo công ty','permission'=>'deleteStaffCompany'),
         '51'=>array('id'=>51,'name'=>'Xem thông tin nhân viên theo công ty','permission'=>'infoStaffCom'),
         // '50'=>array('id'=>50,'name'=>'Danh sách toàn bộ nhân viên','permission'=>'listAllStaff'),
         // '14'=>array('id'=>14,'name'=>'Xem chi tiết nhân viên','permission'=>'viewStaff'),
     )
    ),
    '10'=>array( 'id'=>10,
        'name'=>'Quản lý nhân viên',
        'sub'=>array(
            '50'=>array('id'=>50,'name'=>'Danh sách toàn bộ nhân viên','permission'=>'listAllStaff'),
            '52'=>array('id'=>50,'name'=>'Chỉnh sửa nhân viên','permission'=>'informationStaff'),
            '14'=>array('id'=>14,'name'=>'Xem chi tiết nhân viên','permission'=>'infoStaffCompany'),
        )
    ),
    '11'=>array('id'=>11,
        'name'=>'Quản lý báo cáo',
        'sub'=>array(	'52'=>array('id'=>52,'name'=>'Tổng hợp doanh thu theo điểm bán','permission'=>'lisstReportRevenueByPlaceOnDay'),
         '53'=>array('id'=>53,'name'=>'BC bán hàng theo nhà cung cấp','permission'=>'listReportBySuppliers'),
         '54'=>array('id'=>54,'name'=>'BC bán hàng nhà cung cấp theo sản phẩm','permission'=>'listReportBySuppliersOrderProduct'),
         '55'=>array('id'=>55,'name'=>'BC bán hàng theo điểm đặt máy','permission'=>'listReportTotalSalesByPlace'),
         '56'=>array('id'=>56,'name'=>'BC chi tiết điểm đặt theo máy','permission'=>'listRevenueByPlaceOrderMachine'),
         '57'=>array('id'=>57,'name'=>'BC chi tiết điểm đặt theo sản phẩm','permission'=>'listRevenueByPlaceOrderProduct'),
         '58'=>array('id'=>58,'name'=>'BC chi tiết điểm đặt theo thời gian','permission'=>'listRevenueByPlaceOrderTime'),
							    //'59'=>array('id'=>59,'name'=>'BC kênh phân phối toàn hệ thống','permission'=>'listReportByChannel'),
         '60'=>array('id'=>60,'name'=>'Xem chi tiết lịch sử giao dịch máy','permission'=>'listReportTotalSalesByMachine'),
         '61'=>array('id'=>61,'name'=>'Tổng doanh thu theo tiền mặt','permission'=>'listRevenueByCash'),
         '62'=>array('id'=>62,'name'=>'Tổng hợp doanh thu qua thẻ','permission'=>'listRevenueByCard'),
         '63'=>array('id'=>63,'name'=>'BC phân bổ máy theo tỉnh','permission'=>'listReportMachineByProvince'),
         '64'=>array('id'=>64,'name'=>'BC phân bổ máy theo điểm đặt','permission'=>'listReportMachineByPlace'),
         '65'=>array('id'=>65,'name'=>'BC bán hàng theo chi nhánh','permission'=>'listRevenueByBranch'),
         '66'=>array('id'=>66,'name'=>'BC bán hàng chi tiết chi nhánh theo NCC','permission'=>'listRevenueByBranchOrderSupplier'),
     )
    ),

);
$listStatusErrorMachine= array('1'=>array('id'=>1,'name'=>'Mới tạo'),
    '2'=>array('id'=>2,'name'=>'Đang chờ xử lý'),
    '3'=>array('id'=>3,'name'=>'Đang xử lý'),
    '4'=>array('id'=>4,'name'=>'Hoàn thành'),
    '5'=>array('id'=>5,'name'=>'Đóng'),
);
$listStatusCoupon= array('active'=>array('id'=>1,'name'=>'Kích hoạt'),
    'public'=>array('id'=>2,'name'=>'Đã phát hành'),
    'traded'=>array('id'=>3,'name'=>'Đã giao dịch'),
    'lock'=>array('id'=>4,'name'=>'Hết hạn'),
);
function getGUID()
{
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
        .substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12)
            .chr(125);// "}"
            return $uuid;
        }
    }

    function process_message($message)
    {
        echo "\n--------\n";
        echo $message->body;
        echo "\n--------\n";
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    // Send a message with the string "quit" to cancel the consumer.
        if ($message->body === 'quit') {
            $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
        }
    }

    function shutdown($channel, $connection)
    {
        $channel->close();
        $connection->close();
    }

    function sendToKioskAPI($data= array(),$urlSend='sendToKiosk_server.php')
    {
        //$data= json_decode($data);
        //$data= array();
        $stringSend= array();
        //$url= 'http://'.$_SERVER['SERVER_NAME'].'/app/Plugin/kiosk/controller/amqplib/php/'.$urlSend;
        $url= 'http://vmstest.sab.com.vn/app/Plugin/kiosk/controller/amqplib/php/'.$urlSend;

       //  $modelLogtransaction= new Logtransaction();
       //  $dataSendKiosk= array('codeMachine'=>'00000000def65add','data'=>'["transactionId":1710]','statusPay'=>'00');
       // $saveLogtransaction['Logtransaction']= array('api'=>'callBackKioskAPI','data'=>$dataSendKiosk,'time'=>time(),'url'=>$url);
       // $modelLogtransaction->create();
       // $modelLogtransaction->save($saveLogtransaction);


        foreach($data as $key=>$value){
            $stringSend[]= $key.'='.$value;
        }

        $stringSend= implode('&', $stringSend);
        //var_dump($stringSend);die;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$stringSend);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

       //  $dataSendKiosk= array('codeMachine'=>'00000000def65add','data'=>'["transactionId":1711]','statusPay'=>'00');
       // $saveLogtransaction['Logtransaction']= array('api'=>'callBackKioskAPI','data'=>$dataSendKiosk,'time'=>time(),'url'=>$url,'out'=>$server_output);
       // $modelLogtransaction->create();
       // $modelLogtransaction->save($saveLogtransaction);

        curl_close ($ch);
        //debug($url);
        //debug($server_output);die;
    }

    function convertConfigMachine($machine,$action='')
    {
        $listFloor= array();
        $listProduct= array();
        $modelMachine= new Machine();
        $modelProduct= new Product();
        global $urlHomes;
        if(!empty($machine['Machine']['floor'])){
            foreach($machine['Machine']['floor'] as $key=>$floor){
                //$key++;

                $settingFloor= @$machine['Machine']['settingFloor'][$key];
                if(!empty($settingFloor['idProduct'])){
                    if(empty($listProduct[$settingFloor['idProduct']])){
                        $listProduct[$settingFloor['idProduct']]= $modelProduct->getProduct($settingFloor['idProduct'],array('name','code','priceOutput'));
                    }

                    //debug($listProduct[$settingFloor['idProduct']]);

                    $nameProduct= $listProduct[$settingFloor['idProduct']]['Product']['name'];
                    $codeProduct= $listProduct[$settingFloor['idProduct']]['Product']['code'];
                    // $priceProduct= $settingFloor['priceProduct']; //dòng này và dòng bên dưới đã đổi vị trí comment cho nhau 24/01/2019 để sửa lỗi undefine priceProduct
                    $priceProduct= $listProduct[$settingFloor['idProduct']]['Product']['priceOutput'];
                    $idProduct= $listProduct[$settingFloor['idProduct']]['Product']['id'];
                    $numberLoxo= $settingFloor['numberLoxo'];
                }else{
                    $nameProduct= '';
                    $codeProduct= '';
                    $priceProduct= 0;
                    $idProduct= '';
                    $numberLoxo= 0;
                }
                $info= array( 'name'=>'Khay_'.$key,
                    'GeneralId'=>$idProduct,
                    'GeneralPrice'=>$priceProduct,
                    'GeneralName'=>$nameProduct,
                    'GeneralCode'=>$codeProduct,
                    'SlotCount'=>count($floor),
                    'GoodMaxCound'=>$numberLoxo,
                );
                $listTrench= array();
                if(!empty($floor)){
                    foreach($floor as $trench){
                        if(!empty($trench['idProduct'])){
                            if(empty($listProduct[$trench['idProduct']])){
                                $listProduct[$trench['idProduct']]= $modelProduct->getProduct($trench['idProduct'],array('name','code','priceOutput'));
                            }

                            //debug($listProduct[$trench['idProduct']]);

                            if(!empty($listProduct[$trench['idProduct']])){
                                //if(empty($listProduct[$trench['idProduct']]['Product']['priceOutput'])) debug($listProduct[$trench['idProduct']]);
                                $nameProduct= $listProduct[$trench['idProduct']]['Product']['name'];
                                $codeProduct= $listProduct[$trench['idProduct']]['Product']['code'];
                                $priceProduct= $trench['priceProduct'];
                                //$priceProduct= $listProduct[$trench['idProduct']]['Product']['priceOutput'];
                                $idProduct= $listProduct[$trench['idProduct']]['Product']['id'];
                                $numberLoxo= $trench['numberLoxo'];
                            }else{
                            	if($action=='sendConfigToKiosk'){
                                   $modelMachine->redirect($urlHomes.'structureMachine?id='.$_GET['id'].'&mess=4');
                                   die;
                               }

                               $nameProduct= '';
                               $codeProduct= '';
                               $priceProduct= 0;
                               $idProduct= '';
                               $numberLoxo= 0;
                           }
                       }else{
                           if($action=='sendConfigToKiosk'){
                            $modelMachine->redirect($urlHomes.'structureMachine?id='.$_GET['id'].'&mess=3');
                            die;
                        }

                        $nameProduct= '';
                        $codeProduct= '';
                        $priceProduct= 0;
                        $idProduct= '';
                        $numberLoxo= 0;
                    }
                    $idTrench= $trench['idTrench'];
                    $listTrench[]= array(   'GoodId'=>$trench['idProduct'],
                        'GoodCode'=>$codeProduct,
                        'GoodName'=>$nameProduct,
                        'GoodPrice'=>$priceProduct,
                        'GoodCount'=>$trench['numberProduct'],
                        'name'=>'Khay_'.$key.'_Slot_'.$idTrench,
                        'GoodMaxCound'=>$numberLoxo,
                    );
                }
            }
            $listFloor[]= array_merge($info, array('slots'=>$listTrench));
        }
        $infoMachine= array( 'name'=>'Machine_'.$machine['Machine']['code'],
            'GeneralId'=>'',
            'GeneralPrice'=>'',
            'GeneralName'=>'',
            'GeneralCode'=>'',
            'SlotCount'=>'',
            'TrayCount'=>count($machine['Machine']['floor']),
            'GoodCount'=>'',
            'GoodMaxCound'=>'',
            'MoneyBack'=>(int)@$machine['Machine']['moneyBack']
        );
        return array_merge($infoMachine,array('khays'=>$listFloor));
    }else{
        if($action=='sendConfigToKiosk'){
            $modelMachine->redirect($urlHomes.'structureMachine?id='.$_GET['id'].'&mess=3');
            die;
        }
    }
}



function getPublicKeyVietinbank()
{
    $certificateCAcer = __DIR__.'/controller/files/Vietinbank_luna.cer';
    $certificateCAcerContent = file_get_contents($certificateCAcer);

    $certificateCApemContent =  '-----BEGIN CERTIFICATE-----'.PHP_EOL
    .chunk_split(base64_encode($certificateCAcerContent), 64, PHP_EOL)
    .'-----END CERTIFICATE-----'.PHP_EOL;
    $certificateCApem = $certificateCAcer.'.pem';
        //file_put_contents($certificateCApem, $certificateCApemContent);
        //var_dump($certificateCAcerContent);

    $pub_key = openssl_pkey_get_public($certificateCApemContent);
    $keyData = openssl_pkey_get_details($pub_key);
    return $keyData['key'];
}

function getSignature($key, $package)
{
    include_once('controller/files/phpseclib1.0.9/Math/BigInteger.php');
    include_once('controller/files/phpseclib1.0.9/Crypt/RSA.php');

    $rsa = new Crypt_RSA();
    $rsa->setHash("sha256");
    $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
    $rsa->loadKey($key);
    $signature = base64_encode($rsa->sign(base64_decode($package)));
    return $signature;
}

function checkSignatureVietinbank($key, $signature, $package) {
    include_once('controller/files/phpseclib1.0.9/Math/BigInteger.php');
    include_once('controller/files/phpseclib1.0.9/Crypt/RSA.php');

    $rsa = new Crypt_RSA();
    $rsa->setHash("sha256");
    $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
    $rsa->loadKey($key);
    $verify = $rsa->verify(base64_decode($package), $signature);
    return $verify;
}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function parseKiosk()
{
    $certificateCAcer = __DIR__.'/controller/files/kiosk.cer';
    $certificateCAcerContent = file_get_contents($certificateCAcer);
    return $certificateCAcerContent;
}

function convertMktime($datetime) {
    $dt = explode(' ',$datetime);
    $date = explode('/',$dt[0]);
    $hour = explode(':',$dt[1]);
    if (!empty($hour)) {
        return mktime($hour[0],$hour[1],$hour[2],$date[1],$date[0],$date[2]);
    } else {
        return mktime(0,0,0,$date[1],$date[0],$date[2]);
    }
}
?>
