<?php
function listMachine($input)
{
  global $urlHomes;
  global $isRequestPost;
  global $contactSite;
  global $urlNow;
  global $modelOption;
  global $metaTitleMantan;
  global $listManagementAgency;
  global $listArea;
  global $listStatusMachine;
  $metaTitleMantan= 'Danh sách máy Kiosk';

  $dataSend = $input['request']->data;
  $modelMachine= new Machine();
  $modelPlace= new Place();
  $mess= '';
  $data= array();

  if(!empty($_SESSION['infoStaff'])){
  	if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listMachine', $_SESSION['infoStaff']['Staff']['permission']))){
      $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
      if($page<1) $page=1;
      $limit= 15;
      if (!empty($_SESSION['infoStaff']['Staff']['type'])&&$_SESSION['infoStaff']['Staff']['type']=='admin') {
        $conditions = array('lock'=>0);
      }
      else
      {
         $conditions = array('lock'=>0,'idStaff'=>$_SESSION['infoStaff']['Staff']['id']);

      }
      $order = array('created'=>'DESC');
      $fields= array('name','code','imei','status','idPlace','codeStaff','idStaff','codeasset','parameter');

      if(!empty($_GET['name'])){
        $key= createSlugMantan(trim($_GET['name']));
        $conditions['slug.name']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.name'=>array('$regex' => $key));
      }

      if(!empty($_GET['code'])){
        $key= createSlugMantan(trim($_GET['code']));
        $conditions['slug.code']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.code'=>array('$regex' => $key));
      }

      if(!empty($_GET['codeasset'])){
        $key= createSlugMantan(trim($_GET['codeasset']));
        $conditions['slug.codeasset']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.code'=>array('$regex' => $key));
      }

      if(!empty($_GET['warrantyCycle'])){
        $key= createSlugMantan(trim($_GET['warrantyCycle']));
        $conditions['slug.warrantyCycle']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.warrantyCycle'=>array('$regex' => $key));
      }

      if(!empty($_GET['warrantyManufacturer'])){
        $key= createSlugMantan(trim($_GET['warrantyManufacturer']));
        $conditions['slug.warrantyManufacturer']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.warrantyManufacturer'=>array('$regex' => $key));
      }

      if(!empty($_GET['typeMachine'])){
        $key= createSlugMantan(trim($_GET['typeMachine']));
        $conditions['slug.typeMachine']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.typeMachine'=>array('$regex' => $key));
      }

      if(!empty($_GET['manufacturer'])){
        $key= createSlugMantan(trim($_GET['manufacturer']));
        $conditions['slug.manufacturer']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.manufacturer'=>array('$regex' => $key));
      }

      if(!empty($_GET['dateStorage'])){
        $conditions['dateStorage']= $_GET['dateStorage'];
      }

      if(!empty($_GET['dateManufacture'])){
        $conditions['dateManufacture']= $_GET['dateManufacture'];
      }

      if(!empty($_GET['dateInstallation'])){
        $conditions['dateInstallation']= $_GET['dateInstallation'];
      }

      if(!empty($_GET['nameInstallation'])){
        $codeStaff=trim($_GET['nameInstallation']);

        $conditions['slug.nameInstallation']= array('$regex' => createSlugMantan($codeStaff));
      }

      if(!empty($_GET['dateStartRun'])){
        $conditions['dateStartRun']= $_GET['dateStartRun'];
      }

      if(!empty($_GET['status'])){
        $conditions['status']= $_GET['status'];
      }
      if(!empty($_GET['gps'])){
        $location=trim($_GET['gps']);
        $conditions['location']= array('$regex' => $location);
      }
      if(!empty($_GET['codeStaff'])){
        $codeStaff=trim($_GET['codeStaff']);
        $conditions['slug.codeStaff']= array('$regex' => createSlugMantan($codeStaff));
      }
      if(!empty($_GET['namePlace'])){
        $namePlace=trim($_GET['namePlace']);
        $conditions['idPlace']=  $namePlace;
      }
      
      if(!empty($_GET['priceMachine'])){
        $priceMachine=trim($_GET['priceMachine']);
        $conditions['priceMachine']= array('$regex' => $priceMachine);
      }
      $listData= $modelMachine->getPage($page, $limit , $conditions, $order, $fields );
      $totalData= $modelMachine->find('count',array('conditions' => $conditions));
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
      $listPlace=$modelPlace->find('all', array(
        'order' => array('created'=>'DESC'),
        'conditions' => array('lock'=>0 ),
        'fields'=>array('name')
      ));

      if(!empty($_POST['inport'])){
        $table = array(
          array('label' => __('STT'), 'width' => 5),
          array('label' => __('Tên máy'), 'width' => 20),
          array('label' => __('Mã máy'), 'width' => 20),
          array('label' => __('Mã tài sản'), 'width' => 20),
          array('label' => __('Số imei'), 'width' => 20),
          array('label' => __('Mã điểm đặt'), 'width' => 20),
          array('label' => __('Điểm đặt'), 'width' => 20),
          array('label' => __('Trạng thái'), 'width' => 20),

        );
        $listDataExcel= $modelMachine->getPage(null, null , $conditions, $order, $fields );

        $data= array();
        $stt=0;
        if(!empty($listDataExcel)){
          foreach ($listDataExcel as $key => $value) {
            $stt++;
            $id= $value['Machine']['idPlace'];
            $place= $modelPlace->getPlace($id);
            $trangthai= $listStatusMachine[$value['Machine']['status']]['name'];
            $data[]= array( $stt,
              @$value['Machine']['name'],
              @$value['Machine']['code'],
              @$value['Machine']['codeasset'],
              @$value['Machine']['imei'],
              @$place['Place']['code'],
              @$place['Place']['name'],
              @$trangthai
            );
          }
        }
        $exportsController = new ExportsController();
        //$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
        $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-may')));
      }
      setVariable('listPlace',$listPlace);
      setVariable('listData',$listData);
      setVariable('listStatusMachine',$listStatusMachine);

      setVariable('page',$page);
      setVariable('totalPage',$totalPage);
      setVariable('back',$back);
      setVariable('next',$next);
      setVariable('urlPage',$urlPage);
      setVariable('mess',$mess);
    }else{
      $modelMachine->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelMachine->redirect($urlHomes.'login?status=-2');
  }
}

function addMachine($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  global $listStatusMachine;
  global $contactSite;
  global $smtpSite;
  $metaTitleMantan= 'Thông tin máy Kiosk';

  $modelMachine= new Machine();
  $modelLog= new Log();
  $modelStaff= new Staff();
  $modelPlace= new Place();
  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addMachine', $_SESSION['infoStaff']['Staff']['permission']))){
      $mess= '';
      $data= array();
      if(!empty($_GET['id'])){
        $data= $modelMachine->getMachine($_GET['id']);
      }
      $listPlace=$modelPlace->find('all',  array(
        'order' =>array(),
        'conditions' =>array('lock'=>(int)0),
        'fields'=>array('name'),
      ));;
      if(!empty($dataSend['idPlace'])){
        $place=$modelPlace->getPlace($dataSend['idPlace'],$fields=array('name'));
      }
      if ($isRequestPost) {

        $dataSend= arrayMap($input['request']->data);
        // $date= explode('/', $dataSend['dateInstallation']);
        // $time= mktime(0,0,0,$date[1],$date[0],$date[2]);
        $date1= explode('/', $dataSend['dateStartRun']);
        $time1= mktime(0,0,0,$date1[1],$date1[0],$date1[2]);
        $datacode= (isset($dataSend['code']))?$dataSend['code']:"";
        $datacodeasset= (isset($dataSend['codeasset']))?$dataSend['codeasset']:"";
        $checkCode= $modelMachine->getMachineCode($datacode,array('code'));
        $checkCodeAsset= $modelMachine->getMachineCodeAsset($datacodeasset,array('codeasset'));
        if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Machine']['id'] ) ){
          if(empty($checkCodeAsset) || (!empty($_GET['id']) && $_GET['id']==$checkCodeAsset['Machine']['id'] )){
           if(!empty(trim($dataSend['name']))){
            if(!empty($dataSend['codeStaff'])){
             $infoStaff= $modelStaff->getStaffByCode(trim($dataSend['codeStaff']),array('code'));
           }

           if(empty($dataSend['codeStaff']) || !empty($infoStaff)){
            $data['Machine']['slug']['name']= createSlugMantan(trim($dataSend['name']));
            $data['Machine']['slug']['code']= createSlugMantan(trim($dataSend['code']));
            $data['Machine']['slug']['codeStaff']= createSlugMantan(trim($dataSend['codeStaff']));
            $data['Machine']['slug']['imei']= createSlugMantan(trim($dataSend['imei']));
            $data['Machine']['slug']['nameInstallation']= createSlugMantan(trim($dataSend['nameInstallation']));
            $data['Machine']['slug']['warrantyCycle']= createSlugMantan(trim($dataSend['warrantyCycle']));
            $data['Machine']['slug']['warrantyManufacturer']= createSlugMantan(trim($dataSend['warrantyManufacturer']));
            $data['Machine']['slug']['typeMachine']= createSlugMantan(trim($dataSend['typeMachine']));
            $data['Machine']['slug']['manufacturer']= createSlugMantan(trim($dataSend['manufacturer']));

            $data['Machine']['codeasset']= $dataSend['codeasset'];
            $data['Machine']['slug']['codeasset']= createSlugMantan(trim($dataSend['codeasset']));

            $data['Machine']['name']= trim($dataSend['name']);
            $data['Machine']['code']= $dataSend['code'];
            $data['Machine']['imei']= $dataSend['imei'];
            $data['Machine']['dateManufacture']= $dataSend['dateManufacture'];
            $data['Machine']['dateStorage']= $dataSend['dateStorage'];
            $data['Machine']['priceMachine']= str_replace(array('.',',',' '),'',$dataSend['priceMachine']);
            $data['Machine']['status']= $dataSend['status'];
            $data['Machine']['dateInstallation']= $dataSend['dateInstallation'];
          // $data['Machine']['dateInstallationInt']= $time;
            $data['Machine']['nameInstallation']= $dataSend['nameInstallation'];
            $data['Machine']['dateStartRun']= $dataSend['dateStartRun'];
            $data['Machine']['dateStartRunInt']= $time1;
            $data['Machine']['warrantyCycle']= $dataSend['warrantyCycle'];
            $data['Machine']['warrantyManufacturer']= $dataSend['warrantyManufacturer'];
            $data['Machine']['typeMachine']= $dataSend['typeMachine'];
            $data['Machine']['manufacturer']= $dataSend['manufacturer'];
            $data['Machine']['heightMachine']= $dataSend['heightMachine'];
            $data['Machine']['widthMachine']= $dataSend['widthMachine'];
            $data['Machine']['depthMachine']= $dataSend['depthMachine'];
            $data['Machine']['weightMachine']= $dataSend['weightMachine'];
            $data['Machine']['note']=isset($dataSend['note'])?$dataSend['note']:'';
            $data['Machine']['codeStaff']= trim($dataSend['codeStaff']);
            $data['Machine']['lock']= 0;
            $data['Machine']['idStaff']= (!empty($infoStaff['Staff']['id']))?$infoStaff['Staff']['id']:'';
            $data['Machine']['idPlace']=isset($dataSend['idPlace'])?$dataSend['idPlace']:'';
            $data['Machine']['namePlace']=isset($place['Place']['slug']['name'])?$place['Place']['slug']['name']:'';
            $data['Machine']['location']=isset($dataSend['location'])?$dataSend['location']:'';
            $data['Machine']['image']=isset($dataSend['image'])?$dataSend['image']:'';
            $data['Machine']['coordinates']= $dataSend['coordinates'];
            $data['Machine']['moneyBack']= (int) $dataSend['moneyBack'];
            if($dataSend['status']==3){
              $data['Machine']['timeError']= time();
              $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
              $to = array(trim($contactSite['Option']['value']['email']));
              $cc = array();
              $bcc = array();
              $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo máy lỗi ';


              $content = 'Xin chào <br/>';
              $content.= '
              <br>'.$_SESSION['infoStaff']['Staff']['fullName'].' đã thay đổi trạng thái máy</br>
              <br>Tên máy: '.$data['Machine']['name'].'</br>
              <br>Mã máy: '.$data['Machine']['code'].'</br>
              <br>Trạng thái: Máy bị lỗi</br>
              <br>Thời gian lỗi: '.date('d/m/Y H:i:s',$data['Machine']['timeError']).'</br>
              Lý do sửa: '.$dataSend['reason'].'<br>
              Thông tin đăng nhập:<br/>
              Tên đăng nhập: '.$_SESSION['infoStaff']['Staff']['code'].'<br/>
              Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

              $modelStaff->sendMail($from, $to, $cc, $bcc, $subject, $content);
            }

            if($modelMachine->save($data)){
              $mess= 'Lưu thành công';
              $id= '';
              if(empty($_GET['id'])){
               $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm máy mới có mã: '.$dataSend['code'];
             }else{
              if(!empty($dataSend['reason'])){

               $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa mã máy: '.$dataSend['code'].'. Lý do sửa:'.$dataSend['reason'];
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
        $mess= 'Tài khoản nhân viên phụ trách máy không tồn tại';
      }
    }else{
     $mess= 'Bạn không được để trống tên máy';
   }
 }
// else{
//   $mess= 'Mã tài sản đã tồn tại';
// }
 else
 {
  $mess= 'Mã tài sản đã tồn tại';
}
}

else{
  $mess= 'Mã máy đã tồn tại';
}
}   

setVariable('listPlace',$listPlace);
setVariable('mess',$mess);
setVariable('data',$data);
setVariable('listStatusMachine',$listStatusMachine);

}else{
  $modelOption->redirect($urlHomes.'dashboard');
}
}else{
  $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function changeError($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  global $listStatusMachine;
  $metaTitleMantan= 'Thông tin máy Kiosk';

  $modelMachine= new Machine();
  $modelLog= new Log();
  $modelStaff= new Staff();
  $modelPlace= new Place();
  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('changeError', $_SESSION['infoStaff']['Staff']['permission']))){

      $mess= '';
      $data= array();
      if(!empty($_GET['id'])){
        $data= $modelMachine->getMachine($_GET['id']);
      }
      $listPlace=$modelPlace->find('all',  array(
        'order' =>array(),
        'conditions' =>array('lock'=>(int)0),
        'fields'=>array('name'),
      ));;
      if(!empty($dataSend['idPlace'])){
        $place=$modelPlace->getPlace($dataSend['idPlace'],$fields=array('name'));
      }
      if ($isRequestPost) {
        $dataSend= arrayMap($input['request']->data);
        $datacode= (isset($dataSend['code']))?$dataSend['code']:"";
        $checkCode= $modelMachine->getMachineCode($datacode,array('code'));

        if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Machine']['id'] ) ){
         if(!empty(trim($dataSend['name']))){
          if(!empty($dataSend['codeStaff'])){
           $infoStaff= $modelStaff->getStaffByCode(trim($dataSend['codeStaff']),array('code'));
         }

         if(empty($dataSend['codeStaff']) || !empty($infoStaff)){
          $data['Machine']['slug']['name']= createSlugMantan(trim($dataSend['name']));
          $data['Machine']['slug']['code']= createSlugMantan(trim($dataSend['code']));
          $data['Machine']['slug']['codeStaff']= createSlugMantan(trim($dataSend['codeStaff']));
          $data['Machine']['slug']['imei']= createSlugMantan(trim($dataSend['imei']));
          $data['Machine']['slug']['nameInstallation']= createSlugMantan(trim($dataSend['nameInstallation']));
          $data['Machine']['slug']['warrantyCycle']= createSlugMantan(trim($dataSend['warrantyCycle']));
          $data['Machine']['slug']['warrantyManufacturer']= createSlugMantan(trim($dataSend['warrantyManufacturer']));
          $data['Machine']['slug']['typeMachine']= createSlugMantan(trim($dataSend['typeMachine']));
          $data['Machine']['slug']['manufacturer']= createSlugMantan(trim($dataSend['manufacturer']));

          $data['Machine']['name']= trim($dataSend['name']);
          $data['Machine']['code']= $dataSend['code'];
          $data['Machine']['imei']= $dataSend['imei'];
          $data['Machine']['dateManufacture']= $dataSend['dateManufacture'];
          $data['Machine']['dateStorage']= $dataSend['dateStorage'];
          $data['Machine']['priceMachine']= str_replace(array('.',',',' '),'',$dataSend['priceMachine']);
          $data['Machine']['status']= $dataSend['status'];
          $data['Machine']['dateInstallation']= $dataSend['dateInstallation'];
          $data['Machine']['nameInstallation']= $dataSend['nameInstallation'];
          $data['Machine']['dateStartRun']= $dataSend['dateStartRun'];
          $data['Machine']['warrantyCycle']= $dataSend['warrantyCycle'];
          $data['Machine']['warrantyManufacturer']= $dataSend['warrantyManufacturer'];
          $data['Machine']['typeMachine']= $dataSend['typeMachine'];
          $data['Machine']['manufacturer']= $dataSend['manufacturer'];
          $data['Machine']['heightMachine']= $dataSend['heightMachine'];
          $data['Machine']['widthMachine']= $dataSend['widthMachine'];
          $data['Machine']['depthMachine']= $dataSend['depthMachine'];
          $data['Machine']['weightMachine']= $dataSend['weightMachine'];
          $data['Machine']['note']=isset($dataSend['note'])?$dataSend['note']:'';
          $data['Machine']['codeStaff']= trim($dataSend['codeStaff']);
          $data['Machine']['lock']= 0;
          $data['Machine']['idStaff']= (!empty($infoStaff['Staff']['id']))?$infoStaff['Staff']['id']:'';
          $data['Machine']['idPlace']=isset($dataSend['idPlace'])?$dataSend['idPlace']:'';
          $data['Machine']['namePlace']=isset($place['Place']['slug']['name'])?$place['Place']['slug']['name']:'';
          $data['Machine']['location']=isset($dataSend['location'])?$dataSend['location']:'';
          $data['Machine']['image']=isset($dataSend['image'])?$dataSend['image']:'';
          
          if($dataSend['status']==3){
            $data['Machine']['timeError']= time();
          }

          if($modelMachine->save($data)){
            $mess= 'Lưu thành công';
            $id= '';
            if(empty($_GET['id'])){
             $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' tạo máy mới có mã là '.$dataSend['code'];
           }else{
            if(!empty($dataSend['reason'])){

             $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' sửa máy cũ có mã là '.$dataSend['code'].'. Lý do sửa:'.$dataSend['reason'];
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
      $mess= 'Tài khoản nhân viên phụ trách máy không tồn tại';
    }
  }else{
   $mess= 'Bạn không được để trống tên máy';
 }
}else{
  $mess= 'Mã máy đã tồn tại';
}
}   

setVariable('listPlace',$listPlace);
setVariable('mess',$mess);
setVariable('data',$data);
setVariable('listStatusMachine',$listStatusMachine);

}else{
  $modelOption->redirect($urlHomes.'dashboard');
}
}else{
  $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function deleteMachine($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  global $urlNow;
  $metaTitleMantan= 'Khóa máy Kiosk';

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteMachine', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= $input['request']->data;
      $mess= '';
      $modelMachine= new Machine();
      $modelLog= new Log();

      if(!empty($_GET['id'])){
        $data['$set']['lock']= 1;
        $modelMachine= new Machine;
        $dk= array('_id'=>new MongoId($_GET['id']));
        $machine=$modelMachine->getMachine($_GET['id']);

        if($modelMachine->updateAll($data,$dk)){
                  // lưu lịch sử tạo sản phẩm
          $saveLog['Log']['time']= time();
          $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa máy Kiosk có mã: '.$machine['Machine']['code'];
          $modelLog->save($saveLog);

          $modelOption->redirect($urlHomes.'listMachine');
        }else{
          $modelOption->redirect($urlHomes.'listMachine');
        }

      }else{
        $modelOption->redirect($urlHomes.'listMachine');
      }
    }else{
      $modelOption->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}

function sendConfigToKiosk($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  global $urlNow;
  $metaTitleMantan= 'Gửi cấu hình xuống máy Kiosk';

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('sendConfigToKiosk', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= $input['request']->data;
      $mess= '';
      $modelMachine= new Machine();

      if(!empty($_GET['id'])){
        $data= $modelMachine->getMachine($_GET['id'],array('name','code','floor','settingFloor','moneyBack'));
        if($data){
          $listFloor= convertConfigMachine($data,'sendConfigToKiosk');
          $dataSendKiosk= array('code'=>0,'machine'=>json_encode($listFloor),'codeMachine'=>$data['Machine']['code']);
          sendToKioskAPI($dataSendKiosk);
          $modelOption->redirect($urlHomes.'structureMachine?sendConfigToKiosk=1&id='.$_GET['id']);
        }else{
          $modelOption->redirect($urlHomes.'listMachine?sendConfigToKiosk=-2');
        }
      }else{
        $modelOption->redirect($urlHomes.'listMachine?sendConfigToKiosk=-1');
      }
    }else{
      $modelOption->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}

function structureMachine($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  global $urlNow;
  $metaTitleMantan= 'Khóa máy Kiosk';

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('structureMachine', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= $input['request']->data;
      $mess= '';
      $modelMachine= new Machine();
      $modelLog= new Log();
      $modelProduct= new Product();
      $modelPlace = new Place();

      if(!empty($_GET['id'])){
        $data= $modelMachine->getMachine($_GET['id'],array('idPlace','name','code','floor'));
        if($data){
          $listProduct= $modelProduct->find('all',array('conditions'=>array('lock'=>0),'fields'=>array('name','priceOutput','code')));
          if($listProduct){
            foreach($listProduct as $product){
              $listProductNew[$product['Product']['id']]['name']= @$product['Product']['name'];
              $listProductNew[$product['Product']['id']]['price']= @$product['Product']['priceOutput'];
            }
          }
          setVariable('data',$data);
          setVariable('listProduct',$listProductNew);
          setVariable('listPro',$listProduct);

          if(isset($_POST['export'])){
            $place = $modelPlace->getPlace($data['Machine']['idPlace'],array('name','code'));

            $dataExcel = array();
            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Tên máy'), 'width' => 30),
                array('label' => __('Mã máy'), 'width' => 20),
                array('label' => __('Tên điểm'), 'width' => 30),
                array('label' => __('Mã điểm'), 'width' => 15),
                array('label' => __('Khay'), 'width' => 10),
                array('label' => __('Slot'), 'width' => 10),
                array('label' => __('Mã sản phẩm'), 'width' => 15),
                array('label' => __('Tên sản phẩm'), 'width' => 30),
                array('label' => __('Giá sản phẩm'), 'width' => 15),
                array('label' => __('Số hàng tối đa'), 'width' => 20),
                array('label' => __('Số hàng còn'), 'width' => 15),
                array('label' => __('Số hàng cần load'), 'width' => 20),

                );
            $stt = 0;
            $khay = 0;
            foreach ($data['Machine']['floor'] as $floor) {
              # code...
              $khay++;
              for($i=0; $i<count($floor); $i++){
                echo $place['Place']['name'];
                $product = $modelProduct->getProduct($floor[$i]['idProduct'],array('name','code'));
                $stt++;
                $dataExcel[] = array(
                  $stt,
                  $data['Machine']['name'],
                  $data['Machine']['code'],
                  $place['Place']['name'],
                  $place['Place']['code'],
                  $khay,
                  $i+1,
                  $product['Product']['code'],
                  $product['Product']['name'],
                  $floor[$i]['priceProduct'],
                  $floor[$i]['numberLoxo'],
                  $floor[$i]['numberProduct'],
                  $floor[$i]['numberLoxo'] - $floor[$i]['numberProduct']
                );
              }
            }
             date_default_timezone_set("Asia/Ho_Chi_Minh");
                $dataExcel[] = array("Thời gian tra cứu: ".date("Y/m/d")." - " . date("h:i:sa"));
                 $exportsController = new ExportsController();
                //$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
                $exportsController->requestAction('/exports/excel', array('pass' => array($table,$dataExcel,"Quy-cach-may-".$data['Machine']['name'])));
          }
                    //sendToKioskAPI($data);
        }else{
          $modelOption->redirect($urlHomes.'listMachine');
        }
      }else{
        $modelOption->redirect($urlHomes.'listMachine');
      }
    }else{
      $modelOption->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}

function addFloorMachine($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  $metaTitleMantan= 'Thêm tầng vào máy';

  $modelMachine= new Machine();
  $modelLog= new Log();
  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoMachine', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= arrayMap($input['request']->data);

      if(!empty($dataSend['id'])&&!empty($dataSend['codeFloor'])){
       if ($isRequestPost) {
         if(!empty($dataSend['trench'])){
          $data= $modelMachine->getMachine($dataSend['id'],array('name','code','floor','settingFloorMachine'));
          if($data){
           $trench= (int) $dataSend['trench'];
           if(!empty($dataSend['codeFloor'])){
            if(!empty($data['Machine']['floor'][$dataSend['codeFloor']])){
             $check=$data['Machine']['floor'][$dataSend['codeFloor']];
           }else{
            $check='';
          }
        }
        if($check==''){

          // $modelMachine->redirect($urlHomes."structureMachine?id=".$dataSend['id']."&mess=-1");
          if($trench>0){
            $array= array();
            for($i=0;$i<$trench;$i++){
              $a=$i+1;
             // $array[$i]= array('numberProduct'=>$dataSend['numberProduct'],'idProduct'=>$dataSend['idProduct'],'idTrench'=>$i,'numberLoxo'=>$dataSend['numberLoxo']);

              $array[$i]= array('numberProduct'=>(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']),'priceProduct'=>(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']),'idProduct'=>$dataSend['idProduct'],'idTrench'=>$i,'numberLoxo'=>(int)str_replace(array('.',',',' '),'',$dataSend['numberLoxo']));
            }
            $data['Machine']['floor'][$dataSend['codeFloor']]= $array;

            $save['$set']['floor']= $data['Machine']['floor'];
            $dk= array('_id'=>new MongoId($dataSend['id']));
            $dataaaa=ksort($save['$set']['floor']);
            if($modelMachine->updateAll($save,$dk)){
             $saveLog['Log']['time']= time();
             $modelProduct = new Product;
             $product=$modelProduct->getProduct($dataSend['idProduct']);
             $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Mã máy: '.$data['Machine']['code'].' cài đặt mã khay: '.$dataSend['codeFloor'].', số lượng slot là '.$dataSend['trench'] .', số sản phẩm tối đa:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']).', số sản phẩm còn lại:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']).', tên sản phẩm: '.$product['Product']['name'].', giá sản phẩm : '.(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']).' vnđ';
             $modelLog->save($saveLog);
             $modelMachine->redirect($urlHomes."structureMachine?id=".$dataSend['id']."&mess=1");

           }
         }
       }
       else
       {
        $modelMachine->redirect($urlHomes."structureMachine?id=".$dataSend['id']."&mess=-1");
      }
    }
  }
}   

}
}
}
}

function infoTrench($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  $metaTitleMantan= 'Cấu hình slot';

  $modelMachine= new Machine();
  $modelLog= new Log();
  $modelProduct= new Product();

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoTrench', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= arrayMap($input['request']->data);
      $mess= '';

      if(isset($_GET['idTrench']) && isset($_GET['idMachine']) && isset($_GET['idFloor'])){
        $data= $modelMachine->getMachine($_GET['idMachine'],array('floor','code'));
        $listProduct= $modelProduct->find('all',array('conditions'=>array('lock'=>0),'fields'=>array('name','priceOutput','code')));

        if(!empty($data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']])){
          if ($isRequestPost) {
            $numberLoxo=(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']);
            $numberProduct=(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']);
            $priceProduct=(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']);
            if($numberLoxo>=$numberProduct){
              $data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']]['numberLoxo']=  $numberLoxo;
              $data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']]['numberProduct']=$numberProduct;
              $data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']]['priceProduct']=$priceProduct;
              $data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']]['idProduct']= $dataSend['idProduct'];
              $data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']]['codeProduct']=$dataSend['codeProduct'];

              $save['$set']['floor']= $data['Machine']['floor'];
              $dk= array('_id'=>new MongoId($_GET['idMachine']));
              if($modelMachine->updateAll($save,$dk)){
                $mess= 'Lưu dữ liệu thành công';

                $saveLog['Log']['time']= time();
                $modelProduct = new Product;
                $product=$modelProduct->getProduct($dataSend['idProduct']);
                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Mã máy: '.$data['Machine']['code'].' cài đặt mã khay: '.$_GET['idFloor'].', sửa slot số: '.$_GET['idTrench'].', số sản phẩm tối đa:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']).', số sản phẩm còn lại:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']).', tên sản phẩm: '.$product['Product']['name'].', giá sản phẩm : '.(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']).' vnđ';
                $modelLog->save($saveLog);
              }
            }else{
              $mess= 'Số sản phẩm còn lại không được lớn hơn số sản phẩm tối đa';
            }
          }
          setVariable('trench',$data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']]);
        }   

        setVariable('mess',$mess);
        setVariable('data',$data);
        setVariable('listProduct',$listProduct);
      }else{
        $modelOption->redirect($urlHomes.'dashboard');
      }
    }else{
      $modelOption->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}

function deleteTrench($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  $metaTitleMantan= 'Xóa khay';

  $modelMachine= new Machine();
  $modelLog= new Log();
  $modelProduct= new Product();

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteTrench', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= arrayMap($input['request']->data);
      $mess= '';

      if(isset($_GET['idTrench']) && isset($_GET['idMachine']) && isset($_GET['idFloor'])){
        $data= $modelMachine->getMachine($_GET['idMachine'],array('floor','code'));

        if(!empty($data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']])){
          unset($data['Machine']['floor'][$_GET['idFloor']][$_GET['idTrench']]);
          $save['$set']['floor']= $data['Machine']['floor'];
          $dk= array('_id'=>new MongoId($_GET['idMachine']));
          if($modelMachine->updateAll($save,$dk)){
            $saveLog['Log']['time']= time();
            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' xóa khay cho máy Kiosk có mã là '.$data['Machine']['code'].', hàng thứ '.$_GET['idFloor'].', khay số '.$_GET['idTrench'];
            $modelLog->save($saveLog);
          }

          $modelOption->redirect($urlHomes.'structureMachine?id='.$_GET['idMachine']);
        }   
      }else{
        $modelOption->redirect($urlHomes.'dashboard');
      }
    }else{
      $modelOption->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}

function addTrench($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  $metaTitleMantan= 'Thêm khay';

  $modelMachine= new Machine();
  $modelLog= new Log();
  $modelProduct= new Product();

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addTrench', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= arrayMap($input['request']->data);
      $mess= '';

      if(isset($_GET['idMachine']) && isset($_GET['idFloor'])){
        $data= $modelMachine->getMachine($_GET['idMachine'],array('floor','code'));
        $listProduct= $modelProduct->find('all',array('conditions'=>array('lock'=>0),'fields'=>array('name','priceOutput')));

        if ($isRequestPost) {
         $numberLoxo=(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']);
         $numberProduct=(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']);
         if($numberLoxo>= $numberProduct){
          $data['Machine']['floor'][$_GET['idFloor']]= array_values($data['Machine']['floor'][$_GET['idFloor']]);
          $numberTrench= count($data['Machine']['floor'][$_GET['idFloor']])-1;
          $floorEnd= @$data['Machine']['floor'][$_GET['idFloor']][$numberTrench];

          $idTrench= (isset($floorEnd['idTrench']))?$floorEnd['idTrench']+1:0;
          $data['Machine']['floor'][$_GET['idFloor']][]= array(
            'numberProduct'=>(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']),
            'priceProduct'=>(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']),
            'idProduct'=>$dataSend['idProduct'],
            'numberLoxo'=>(int)str_replace(array('.',',',' '),'',$dataSend['numberLoxo']),
            'idTrench'=>$idTrench
          );

          $save['$set']['floor']= $data['Machine']['floor'];
          $dk= array('_id'=>new MongoId($_GET['idMachine']));
          if($modelMachine->updateAll($save,$dk)){
            $mess= 'Lưu dữ liệu thành công';

            $saveLog['Log']['time']= time();
            $product=$modelProduct->getProduct($dataSend['idProduct']);
            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Mã máy: '.$data['Machine']['code'].' cài đặt mã khay: '.$_GET['idFloor'].', thêm slot số: '.$idTrench.', số sản phẩm tối đa:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']).', số sản phẩm còn lại:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']).', tên sản phẩm: '.$product['Product']['name'].', giá sản phẩm : '.(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']).' vnđ';            $modelLog->save($saveLog);
          }
        }else{
          $mess= 'Số sản phẩm còn lại không được lớn hơn số sản phẩm tối đa';
        }
      }

      setVariable('mess',$mess);
      setVariable('data',$data);
      setVariable('listProduct',$listProduct);
    }else{
      $modelOption->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelOption->redirect($urlHomes.'dashboard');
  }
}else{
  $modelOption->redirect($urlHomes.'login?status=-2');
}
}

function deleteFloor($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  $metaTitleMantan= 'Xóa hàng';

  $modelMachine= new Machine();
  $modelLog= new Log();
  $modelProduct= new Product();

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteFloor', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= arrayMap($input['request']->data);
      $mess= '';

      if(isset($_GET['idMachine']) && isset($_GET['idFloor'])){
        $data= $modelMachine->getMachine($_GET['idMachine'],array('floor','code'));

        if(!empty($data['Machine']['floor'][$_GET['idFloor']])){
          unset($data['Machine']['floor'][$_GET['idFloor']]);
          $save['$set']['floor']= $data['Machine']['floor'];
          $dk= array('_id'=>new MongoId($_GET['idMachine']));
          if($modelMachine->updateAll($save,$dk)){
            $saveLog['Log']['time']= time();
            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' xóa hàng cho máy Kiosk có mã là '.$data['Machine']['code'].', hàng thứ '.$_GET['idFloor'];
            $modelLog->save($saveLog);
          }

          $modelOption->redirect($urlHomes.'structureMachine?id='.$_GET['idMachine']);
        }   
      }else{
        $modelOption->redirect($urlHomes.'dashboard');
      }
    }else{
      $modelOption->redirect($urlHomes.'dashboard');
    }
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}

function listMachineError($input)
{
  global $urlHomes;
  global $isRequestPost;
  global $contactSite;
  global $urlNow;
  global $modelOption;
  global $metaTitleMantan;
  global $listManagementAgency;
  global $listArea;
  global $listStatusMachine;
  $metaTitleMantan= 'Danh sách máy Kiosk lỗi';

  $dataSend = $input['request']->data;
  $modelMachine= new Machine();
  $modelPlace = new Place;

  $mess= '';
  $data= array();

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listMachineError', $_SESSION['infoStaff']['Staff']['permission']))){
      $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
      if($page<1) $page=1;
      $limit= 15;
      if (!empty($_SESSION['infoStaff']['Staff']['type'])&&$_SESSION['infoStaff']['Staff']['type']=='admin') {
       $conditions = array('lock'=>0,'status'=>'3');
     }
     else
     {
      $conditions = array('lock'=>0,'status'=>'3','idStaff'=>$_SESSION['infoStaff']['Staff']['id']);

    }
    $order = array('created'=>'DESC');
    $fields= array('name','code','imei','idPlace','codeStaff','timeError','idStaff');

    if(!empty($_GET['name'])){
      $key= createSlugMantan(trim($_GET['name']));
      $conditions['slug.name']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.name'=>array('$regex' => $key));
    }

    if(!empty($_GET['code'])){
      $key= createSlugMantan(trim($_GET['code']));
      $conditions['slug.code']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.code'=>array('$regex' => $key));
    }

    if(!empty($_GET['codeasset'])){
      $key= createSlugMantan(trim($_GET['codeasset']));
      $conditions['slug.codeasset']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.code'=>array('$regex' => $key));
    }

    if(!empty($_GET['warrantyCycle'])){
      $key= createSlugMantan(trim($_GET['warrantyCycle']));
      $conditions['slug.warrantyCycle']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.warrantyCycle'=>array('$regex' => $key));
    }

    if(!empty($_GET['warrantyManufacturer'])){
      $key= createSlugMantan(trim($_GET['warrantyManufacturer']));
      $conditions['slug.warrantyManufacturer']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.warrantyManufacturer'=>array('$regex' => $key));
    }

    if(!empty($_GET['typeMachine'])){
      $key= createSlugMantan(trim($_GET['typeMachine']));
      $conditions['slug.typeMachine']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.typeMachine'=>array('$regex' => $key));
    }

    if(!empty($_GET['manufacturer'])){
      $key= createSlugMantan(trim($_GET['manufacturer']));
      $conditions['slug.manufacturer']= array('$regex' => $key);
                //$conditions['$or'][]= array('slug.manufacturer'=>array('$regex' => $key));
    }

    if(!empty($_GET['dateStorage'])){
      $conditions['dateStorage']= $_GET['dateStorage'];
    }

    if(!empty($_GET['dateManufacture'])){
      $conditions['dateManufacture']= $_GET['dateManufacture'];
    }

    if(!empty($_GET['dateInstallation'])){
      $conditions['dateInstallation']= $_GET['dateInstallation'];
    }

    if(!empty($_GET['nameInstallation'])){
      $conditions['nameInstallation']= $_GET['nameInstallation'];
    }

    if(!empty($_GET['dateStartRun'])){
      $conditions['dateStartRun']= $_GET['dateStartRun'];
    }

    if(!empty($_GET['status'])){
      $conditions['status']= $_GET['status'];
    }

    $listData= $modelMachine->getPage($page, $limit , $conditions, $order, $fields );

    $totalData= $modelMachine->find('count',array('conditions' => $conditions));
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
    if(!empty($_POST['inport'])){
      $table = array(
        array('label' => __('STT'), 'width' => 5),
        array('label' => __('Tên máy'), 'width' => 40),
        array('label' => __('Mã máy'), 'width' => 40),
        array('label' => __('Mã tài sản'), 'width' => 40),
        array('label' => __('Số imei'), 'width' => 40),
        array('label' => __('Điểm đặt'), 'width' => 40),
        array('label' => __('NV phụ trách'), 'width' => 40),
        array('label' => __('Thời gian lỗi'), 'width' => 40),
      );
      $data= array();
      $stt=0;
      if(!empty($listData)){
        foreach ($listData as $key => $value) {
          $stt++;
          $id= $value['Machine']['id'];
          $place= $modelPlace->getPlace($value['Machine']['idPlace']);
          $trangthai= $listStatusMachine[$value['Machine']['status']]['name'];
          $time=date('H:i:s d/m/Y',@$value['Machine']['timeError']);
          $data[]= array( $stt,
            @$value['Machine']['name'],
            @$value['Machine']['code'],
            @$value['Machine']['codeasset'],
            @$value['Machine']['imei'],
            @$place['Place']['name'],
            @$value['Machine']['codeStaff'],
            @$time,
          );
        }
      }
      $exportsController = new ExportsController();
        //$exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
      $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-may-loi')));
    }
    setVariable('listData',$listData);
    setVariable('listStatusMachine',$listStatusMachine);

    setVariable('page',$page);
    setVariable('totalPage',$totalPage);
    setVariable('back',$back);
    setVariable('next',$next);
    setVariable('urlPage',$urlPage);
    setVariable('mess',$mess);
  }else{
    $modelMachine->redirect($urlHomes.'dashboard');
  }
}else{
  $modelMachine->redirect($urlHomes.'login?status=-2');
}
}

function settingFloorMachine($input)
{
  global $modelOption;
  global $urlHomes;
  global $isRequestPost;
  global $metaTitleMantan;
  $metaTitleMantan= 'Cấu hình khay';

  $modelMachine= new Machine();
  $modelLog= new Log();
  $modelProduct= new Product();

  if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('settingFloorMachine', $_SESSION['infoStaff']['Staff']['permission']))){
      $dataSend= arrayMap($input['request']->data);
      $mess= '';

      if(isset($_GET['idMachine']) && isset($_GET['idFloor'])){
        $data= $modelMachine->getMachine($_GET['idMachine'],array('floor','code','settingFloor'));
        $listProduct= $modelProduct->find('all',array('conditions'=>array('lock'=>0),'fields'=>array('name','priceOutput','code')));
        $floor=$data['Machine']['floor'][$_GET['idFloor']][0];
        $soslot=count($data['Machine']['floor'][$_GET['idFloor']]);
        if ($isRequestPost) {
          $numberLoxo=(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']);
          $numberProduct=(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']);
          $priceProduct=(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']);
          if( $numberLoxo>=$numberProduct){
            if(!empty($dataSend['codeFloor'])){
              if(!empty($data['Machine']['floor'][$dataSend['codeFloor']])){
               $check=$data['Machine']['floor'][$dataSend['codeFloor']];
             }else{
              $check='';
            }
          }
          if(!empty($check)&&$dataSend['codeFloor']==$_GET['idFloor']){
           foreach($data['Machine']['floor'][$_GET['idFloor']] as $key=>$trench){
            $data['Machine']['floor'][$_GET['idFloor']][$key]['numberLoxo']= (int) $numberLoxo;
            $data['Machine']['floor'][$_GET['idFloor']][$key]['numberProduct']= (int) $numberProduct;
            $data['Machine']['floor'][$_GET['idFloor']][$key]['priceProduct']= (int) $priceProduct;
            $data['Machine']['floor'][$_GET['idFloor']][$key]['idProduct']= $dataSend['idProduct'];
          }

          $data['Machine']['settingFloor'][$_GET['idFloor']]['numberLoxo']= (int) $numberLoxo;
          $data['Machine']['settingFloor'][$_GET['idFloor']]['numberProduct']= (int)$numberProduct;
          $data['Machine']['settingFloor'][$_GET['idFloor']]['priceProduct']= (int)$priceProduct;
          $data['Machine']['settingFloor'][$_GET['idFloor']]['idProduct']= $dataSend['idProduct'];
          $save['$set']['floor']= $data['Machine']['floor'];
          $save['$set']['settingFloor']= $data['Machine']['settingFloor'];
          $dk= array('_id'=>new MongoId($_GET['idMachine']));
          if($modelMachine->updateAll($save,$dk)){
            $mess= 'Lưu dữ liệu thành công';

            $saveLog['Log']['time']= time();
            $product=$modelProduct->getProduct($dataSend['idProduct']);

            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Mã máy: '.$data['Machine']['code'].' cài đặt mã khay: '.$dataSend['codeFloor'].', số sản phẩm tối đa:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']).', số sản phẩm còn lại:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']).', tên sản phẩm: '.$product['Product']['name'].', giá sản phẩm : '.(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']).' vnđ';            $modelLog->save($saveLog);
            $modelOption->redirect($urlHomes.'structureMachine?id='.$_GET['idMachine'].'&mess=2');
          }
        }
        if(!empty($check)&&$dataSend['codeFloor']!=$_GET['idFloor']){
          $mess= 'Mã khay đã tồn tại';
        }
        if(empty($check)){
          $array= array();
          for($i=0;$i<$soslot;$i++){
            $a=$i+1;
            $array[$i]= array('numberProduct'=>$numberProduct,'idProduct'=>$dataSend['idProduct'],'idTrench'=>$i,'numberLoxo'=>$numberLoxo);
          }
          $data['Machine']['floor'][$dataSend['codeFloor']]= $array;
          $data['Machine']['settingFloor'][$_GET['idFloor']]['numberLoxo']= (int) $numberLoxo;
          $data['Machine']['settingFloor'][$_GET['idFloor']]['numberProduct']= (int) $numberProduct;
          $data['Machine']['settingFloor'][$_GET['idFloor']]['idProduct']= $dataSend['idProduct'];
          $save['$set']['floor']= $data['Machine']['floor'];
          $save['$set']['settingFloor']= $data['Machine']['settingFloor'];
          $dk= array('_id'=>new MongoId($_GET['idMachine']));
          if($modelMachine->updateAll($save,$dk)){
            unset($data['Machine']['floor'][$_GET['idFloor']]);
            $delete['$set']['floor']= $data['Machine']['floor'];
            $dk= array('_id'=>new MongoId($_GET['idMachine']));
            if($modelMachine->updateAll($delete,$dk)){
              $saveLog['Log']['time']= time();
              $modelProduct = new Product;
              $product=$modelProduct->getProduct($dataSend['idProduct']);

              $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Mã máy: '.$data['Machine']['code'].' thêm mã khay: '.$dataSend['codeFloor'].', số sản phẩm tối đa:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberLoxo']).', số sản phẩm còn lại:'.(int) str_replace(array('.',',',' '),'',$dataSend['numberProduct']).', tên sản phẩm: '.$product['Product']['name'].', giá sản phẩm : '.(int) str_replace(array('.',',',' '),'',$dataSend['priceProduct']).' vnđ';
              $modelLog->save($saveLog);
              $modelOption->redirect($urlHomes.'structureMachine?id='.$_GET['idMachine']);
            }

          }
        }

      }else{
        $mess= 'Số lượng sản phẩm còn lại không được lớn hơn số sản phẩm tối đa';
      }
    }
    setVariable('floor',@$data['Machine']['settingFloor'][$_GET['idFloor']]);

    setVariable('mess',$mess);
    setVariable('data',$data);
    setVariable('listProduct',$listProduct);
    setVariable('floor',$floor);
        // $modelOption->redirect($urlHomes.'structureMachine?id='.$_GET['idMachine']);

  }else{
    $modelOption->redirect($urlHomes.'dashboard');
  }
}else{
  $modelOption->redirect($urlHomes.'dashboard');
}
}else{
  $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function infoMachine(){
 global $modelOption;
 global $urlHomes;
 global $isRequestPost;
 global $metaTitleMantan;
 global $listStatusMachine;
 $metaTitleMantan= 'Thông tin máy Kiosk';

 $modelMachine= new Machine();
 $modelLog= new Log();
 $modelStaff= new Staff();
 $modelPlace= new Place();
 if(!empty($_SESSION['infoStaff'])){
  if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoMachine', $_SESSION['infoStaff']['Staff']['permission']))){
    $mess= '';
    if(!empty($_GET['id'])){
      $data= $modelMachine->getMachine($_GET['id']);
      if(!empty($data['Machine']['idPlace'])){
        $place=$modelPlace->getPlace($data['Machine']['idPlace'],$fields=array('name'));
        setVariable('place',$place);
      }
      setVariable('data',$data);
    }
    setVariable('listStatusMachine',$listStatusMachine);
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}else{
  $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function infoMachineError(){
 global $modelOption;
 global $urlHomes;
 global $isRequestPost;
 global $metaTitleMantan;
 global $listStatusMachine;
 $metaTitleMantan= 'Thông tin máy Kiosk';

 $modelMachine= new Machine();
 $modelLog= new Log();
 $modelStaff= new Staff();
 $modelPlace= new Place();
 if(!empty($_SESSION['infoStaff'])){
  if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoMachineError', $_SESSION['infoStaff']['Staff']['permission']))){
    $mess= '';
    if(!empty($_GET['id'])){
      $data= $modelMachine->getMachine($_GET['id']);
      if(!empty($data['Machine']['idPlace'])){
        $place=$modelPlace->getPlace($data['Machine']['idPlace'],$fields=array('name'));
        setVariable('place',$place);
      }
      setVariable('data',$data);
    }
    setVariable('listStatusMachine',$listStatusMachine);
  }else{
    $modelOption->redirect($urlHomes.'login?status=-2');
  }
}else{
  $modelOption->redirect($urlHomes.'login?status=-2');
}
}

/* Hàm đồng bộ giá riêng write by BH
Chức năng: Sau khi người dùng phê duyệt giá bán riêng hệ thống sẽ đồng bộ sang bảng machine và xuống máy kiosk
Điều kiện áp dụng: Phương thức thanh toán có tiền mặt
Cần sửa thêm:
  Chưa đồng bộ xuống kiosk mà chỉ đồng bộ sang machine đã
  Làm thêm chức năng sửa khi chưa phê duyệt
  Click vào 1 dòng sẽ xem chi tiết
  Làm giảm giá theo %
  Ghi lại log
*/
function synchMachine(){
  $modelMachine= new Machine();
  $modelProduct= new Product();
  $modelSellProduct= new SellProduct();
  global $urlHomes;
  $mess[]='';
  if (!empty($_GET['id'])) { // nếu có id bản ghi của giá bán riêng thì tìm các máy đc áp dụng giá bán riêng đó
    $dataSellProduct = $modelSellProduct->find('first', array('conditions'=>array('id'=>$_GET['id'])));
    // nếu phương thức thanh toán có tiền mặt
    if (in_array('1', $dataSellProduct['SellProduct']['typedateEndPay'])) {
      // biến này chứa 1 mảng các mã máy lấy ra ở bảng SellProduct
      $machine = $dataSellProduct['SellProduct']['codeMachine'];
      // nếu các mã máy ko rỗng
      if (!empty($machine)) {
        // lặp qua từng mã máy
        foreach ($machine as $codeMachine) {
          // lấy dữ liệu của các sản phẩm trong máy
          $data = $modelMachine->getMachineCode($codeMachine,array('floor','code','name','settingFloor','moneyBack'));
          // nếu có dữ liệu
          if (!empty($data['Machine']['floor'])) {
            // duyệt qua từng floor của máy (của trường floor của bảng machine)
            foreach ($data['Machine']['floor'] as $kfloor => $floor) {
              // nếu floor có sản phẩm
              if (!empty($floor)) {
                // duyệt qua từng sản phẩm
                foreach ($floor as $ktrench => $trench) {
                  // nếu sản phẩm có mã
                  if (!empty($trench['codeProduct'])) {
                    //nếu mã sản phẩm ở bảng Machine bằng mã sản phẩm ở bảng SellProduct
                    if ($trench['codeProduct'] == $dataSellProduct['SellProduct']['code']) {
                      // cập nhật giá bán từ bảng SellProduct vào bảng Machine
                      $data['Machine']['floor'][$kfloor][$ktrench]['priceProduct'] = $dataSellProduct['SellProduct']['priceSale'];
                    } // end if
                  } //end if
                } // end foreach
              } // end if
            } // end foreach floor
          } // end if floor
          if ($modelMachine->save($data)&&!empty($data['Machine']['floor'])) {
            //tiến hành đồng bộ dữ liệu xuống máy kiosk.
            // $listFloor= convertConfigMachine($data);
            // $dataSendKiosk= array('code'=>0,'machine'=>json_encode($listFloor),'codeMachine'=>$data['Machine']['code']);
            // sendToKioskAPI($dataSendKiosk);
            // lưu thông báo các máy đc đồng bộ
            $mess[] = 'Đồng bộ thành công bảng Machine máy <a target="_blank" href="'.$urlHomes.'structureMachine?id='.$data['Machine']['id'].'" class="text-primary text-uppercase">'.$data['Machine']['name'].'</a> (Mã máy: '.$data['Machine']['code'].')<br>';
          } else {
            // lưu thông báo các máy ko đc đồng bộ
            $mess[] = 'Máy <a target="_blank" href="'.$urlHomes.'structureMachine?id='.$data['Machine']['id'].'" class="text-danger text-uppercase">'.$data['Machine']['name'].'</a> (Mã máy: '.$data['Machine']['code'].') <span style="color:red"> ở bảng Machine không có gì để đồng bộ</span><br>';
          }
        } // end foreach machine
      } else {
        // nếu ko có máy nào đc đồng bộ
        $mess[] = 'Không có gì để đồng bộ';
      }
      // gửi biến cho view
      setVariable('mess',$mess);
    } //end Type pay
  } //end id
} // end func

?>