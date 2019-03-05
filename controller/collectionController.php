<?php
function listCollection($input)
{
    global $urlHomes;
    global $urlNow;
    global $metaTitleMantan;
    $metaTitleMantan= 'Lịch sử thu tiền tại máy';

    $dataSend = $input['request']->data;
    $modelMachine= new Machine();
    $modelCollection= new Collection();
    $modelProduct= new Product();

    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listCollection', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET)){
             $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
             if($page<1) $page=1;
             $limit= 500;
             $conditions = array();
             $order = array('timeServer'=>'DESC');
             $fields= array();


             if (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listCollection', $_SESSION['infoStaff']['Staff']['permission'])) {
                $conditions= array('idMachine'=>array('$in'=>$_SESSION['listIdMachine']));
            }
            if(!empty($_GET['dateEnd'])){
                $date1= explode('/', $_GET['dateEnd']);
                $time1= mktime(23,59,59,$date1[1],$date1[0],$date1[2]);
                $conditions['timeServer'] = array('$lte' => (int)$time1);
            }
            if(!empty($_GET['dateStart'])){

                $date= explode('/', $_GET['dateStart']);
                $time= mktime(0,0,0,$date[1],$date[0],$date[2]);
                $conditions['timeServer'] = array('$gte' => (int)$time);
            }
            if(!empty($_GET['codeMachine'])){
                $conditions['slug.codeMachine']= array('$regex' =>createSlugMantan(trim($_GET['codeMachine'])));
            }
            if(!empty($_GET['idPlace'])){
                $conditions['idPlace']=$_GET['idPlace'];
            }
            if(isset($_GET['moneyCalculate'])&&$_GET['moneyCalculate']!=null){
                $conditions['moneyCalculate']=(int)str_replace(array('.',',',' '),'',$_GET['moneyCalculate']);
            }
            if(isset($_GET['money'])&&$_GET['money']!=null){
                $conditions['money']= (int)str_replace(array('.',',',' '),'',$_GET['money']);
            }
            if(!empty($_GET['codeStaff'])){
                // $listMachine= $modelMachine->find('all',array('fields'=>array('code','codeStaff'),'conditions'=>array('slug.codeStaff'=>array('$regex' =>createSlugMantan(trim($_GET['codeStaff']))))));
                // $listIdMachine= array();
                // if($listMachine){
                //  foreach($listMachine as $machine){
                //      $listIdMachine[]= $machine['Machine']['id'];
                //  }
                // }
                // $conditions['idMachine']= array('$in'=>$listIdMachine);
                $conditions['codeStaff']=array('$regex' =>trim($_GET['codeStaff']));
            }
            $listData= $modelCollection->getPage($page, $limit , $conditions, $order, $fields );
            $listStaff= array();

            if($listData){
                foreach($listData as $data){
                    if(empty($listStaff[$data['Collection']['idMachine']])){
                        $listStaff[$data['Collection']['idMachine']]= $modelMachine->getMachine($data['Collection']['idMachine'],array('codeStaff','idStaff'));
                    }
                }
            }
            
            $totalData= $modelCollection->find('count',array('conditions' => $conditions));
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
            //$listCollection=$modelCollection->find('all', array('conditions'=>$conditions,'order'=>$order,'fields'=>$fields));
            if(!empty($_POST['inport'])){
                $listCollection= $listData;
                
                $table = array(
                    array('label' => __('STT'), 'width' => 5),
                    array('label' => __('Mã máy'),'width' => 17, 'filter' => true, 'wrap' => true),
                    array('label' => __('Mã nhân viên'), 'width' => 15, 'filter' => true, 'wrap' => true),
                    array('label' => __('Thời gian'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Doanh thu bán hàng(vnđ)'), 'width' => 15, 'filter' => true),
                    array('label' => __('Số tiền nhân viên thu(vnđ)'), 'width' => 15, 'filter' => true),
                );
                $data= array();
                if(!empty($listCollection)){
                    foreach ($listCollection as $key => $value) {
                        $stt= $key+1;
                        $time=date('d/m/Y H:i:s',$value['Collection']['timeServer']);
                        $data[]= array( $stt,
                            $value['Collection']['codeMachine'],
                            !empty($value['Collection']['codeStaff'])?$value['Collection']['codeStaff']:'Admin',
                            $time,
                            $value['Collection']['moneyCalculate'],
                            $value['Collection']['money'],
                        );
                    }
                        // $cua=array('','Tổng cộng',$tongSL,'',$tongTien,'');
                        // array_push($data,$cua);
                }
                $exportsController = new ExportsController();
                $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Lich-su-thu-tien-tai-may')));
            }

            setVariable('listData',$listData);
            setVariable('listStaff',$listStaff);

            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
            setVariable('mess',$mess);
        }

    }else{
        $modelMachine->redirect($urlHomes.'dashboard');
    }
}else{
    $modelMachine->redirect($urlHomes.'login?status=-2');
}
}
function viewCollection($input)
{
    global $isRequestPost;

    global $urlHomes;
    global $urlNow;
    global $metaTitleMantan;
    $metaTitleMantan= 'Xem lịch sử thu tiền tại máy';
    $dataSend = $input['request']->data;
    $modelLog= new Log();

    $modelMachine= new Machine();
    $modelCollection= new Collection();
    $modelProduct= new Product();

    
    if ($isRequestPost) {
        $dat['money']=(int)str_replace(array('.',',',' '),'',$dataSend['money']);
        $id= '';
        $dk= array('_id'=> new MongoId($_GET['id']));
        if($modelCollection->updateAll($dat,$dk))
        {
            $mess="Lưu thành công";
            setVariable('mess',$mess);
        }
    }
    $data=$modelCollection->find('first', array('conditions'=>array('_id'=>new MongoID($_GET['id']))));
    $listStaff= array();

    if(empty($listStaff[$data['Collection']['idMachine']])){
        $listStaff[$data['Collection']['idMachine']]= $modelMachine->getMachine($data['Collection']['idMachine'],array('codeStaff','idStaff'));


    }
    if(!empty($dataSend['reason'])){
       $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' sửa thông tin lịch sử thu tiền tại máy '.$data['Collection']['idMachine'].', ID là '.$_GET['id'].'.Với lý do:'.$dataSend['reason'];
   }
   $saveLog['Log']['time']= time();
   $modelLog->save($saveLog);
   setVariable('listStaff',$listStaff);
   setVariable('data',$data);
}
function infoCollection($input)
{
    global $isRequestPost;

    global $urlHomes;
    global $urlNow;
    global $metaTitleMantan;
    $metaTitleMantan= 'Xem lịch sử thu tiền tại máy';
    $dataSend = $input['request']->data;
    $modelLog= new Log();

    $modelMachine= new Machine();
    $modelCollection= new Collection();
    $modelProduct= new Product();

    
    if ($isRequestPost) {
        $dat['money']=(int)str_replace(array('.',',',' '),'',$dataSend['money']);
        $dat['reason']=$dataSend['reason'];
        $id= '';
        $dk= array('_id'=> new MongoId($_GET['id']));
        if($modelCollection->updateAll($dat,$dk))
        {
            $mess="Lưu thành công";
            setVariable('mess',$mess);
        }
    }
    $data=$modelCollection->find('first', array('conditions'=>array('_id'=>new MongoID($_GET['id']))));
    $listStaff= array();
    $modelMachine= new Machine;
    $machine=$modelMachine->getMachine($data['Collection']['idMachine']);
    if(empty($listStaff[$data['Collection']['idMachine']])){
        $listStaff[$data['Collection']['idMachine']]= $modelMachine->getMachine($data['Collection']['idMachine'],array('codeStaff','idStaff'));


    }
    if(!empty($dataSend['reason'])){
       $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa thông tin lịch sử thu tiền tại máy: '.$machine['Machine']['code'].', Thời gian: '.date(' d/m/Y H:i:s',$data['Collection']['timeServer']).', số tiền nhân viên thu: '.$data['Collection']['money'].' Lý do:'.$dataSend['reason'];
   }
   $saveLog['Log']['time']= time();
   $modelLog->save($saveLog);
   setVariable('listStaff',$listStaff);
   setVariable('data',$data);
}
?>