<?php
function listCompany($input)
{
    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $urlNow;
    global $modelOption;
    global $metaTitleMantan;
    $metaTitleMantan= 'Danh sách công ty';

    $dataSend = $input['request']->data;
    $modelCompany= new Company();

    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listCompany', $_SESSION['infoStaff']['Staff']['permission']))){
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;

            $conditions = array('delete'=>'false');
            $order = array('expires'=>'ASC');
            $fields= array('name','taxCode','phone','nameBoss','email','status','numberBranch','idCity','code');
            //$conditions['delete']= 'false';
            if(!empty($_GET['name'])){
                $key=trim($_GET['name']);
                $conditions['slug.name']= array('$regex' => createSlugMantan($key));
            }

            if(!empty($_GET['phone'])){
                $phone=trim($_GET['phone']);
                $conditions['phone']= array('$regex' => $phone);
            }
            if(!empty($_GET['address'])){
                $address=trim($_GET['address']);
                $conditions['$or'][0]['address']= array('$regex' => createSlugMantan($address));
                $conditions['$or'][1]['slug.address']= array('$regex' => createSlugMantan($address));

            }
            if(!empty($_GET['email'])){
                $email=trim($_GET['email']);
                $conditions['$or'][0]['email']= array('$regex' => createSlugMantan($email));
                $conditions['$or'][1]['slug.email']= array('$regex' => createSlugMantan($email));
            }
            if(!empty($_GET['area'])){
                $conditions['area']= $_GET['area'];
            }
            if(!empty($_GET['idCity'])){
                $conditions['idCity']= $_GET['idCity'];
            }
            if(!empty($_GET['idDistrict'])){
                $conditions['idDistrict']= $_GET['idDistrict'];
            }

            if(!empty($_GET['taxCode'])){
               // $conditions['slug.code']= array('$regex' =>createSlugMantan($_GET['code']));
                $conditions['$or'][0]['taxCode']= array('$regex' => createSlugMantan($_GET['taxCode']));
                $conditions['$or'][1]['slug.taxCode']= array('$regex' => createSlugMantan($_GET['taxCode']));

            }
            if(!empty($_GET['code'])){
               // $conditions['slug.code']= array('$regex' =>createSlugMantan($_GET['code']));
                $conditions['$or'][0]['code']= array('$regex' => createSlugMantan($_GET['code']));
                $conditions['$or'][1]['slug.code']= array('$regex' => createSlugMantan($_GET['code']));

            }
            if(!empty($_GET['wards'])){
               $wards=trim($_GET['wards']);
               $conditions['slug.wards']= array('$regex' =>createSlugMantan($wards));
           }
           if(!empty($_GET['status'])){
             $conditions['status']= array('$regex' => $_GET['status']);
         }
         if(isset($_GET['nameBoss'])&&$_GET['nameBoss']!=null){
            $nameBoss=trim($_GET['nameBoss']);
            $conditions['slug.nameBoss']=array('$regex' =>createSlugMantan($nameBoss)); ;
        }
        if(isset($_GET['numberBranch'])&&$_GET['numberBranch']!=null){
            $numberBranch=trim($_GET['numberBranch']);
            $conditions['numberBranch']=(int)$numberBranch;
        }
        $listData= $modelCompany->getPage($page, $limit , $conditions, $order, $fields );

        $totalData= $modelCompany->find('count',array('conditions' => $conditions));
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
        $listCityKiosk = $modelOption->getOption('cityKiosk');
        setVariable('listData',$listData);
        setVariable('listCityKiosk',$listCityKiosk);
        setVariable('page',$page);
        setVariable('totalPage',$totalPage);
        setVariable('back',$back);
        setVariable('next',$next);
        setVariable('urlPage',$urlPage);
        setVariable('mess',$mess);
    }else{
        $modelCompany->redirect($urlHomes.'dashboard');
    }
}else{
    $modelCompany->redirect($urlHomes.'login?status=-2');
}
}

function addCompany($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin công ty';

    $modelCompany= new Company();
    $modelLog= new Log();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addCompany', $_SESSION['infoStaff']['Staff']['permission']))){

            $mess= '';
            $data= array();
            if(!empty($_GET['id'])){
                $data= $modelCompany->getCompany($_GET['id']);
            }
            $listCityKiosk = $modelOption->getOption('cityKiosk');

            if ($isRequestPost) {
                $dataSend= arrayMap($input['request']->data);
                $datacode= (isset($dataSend['code']))?$dataSend['code']:"";
                $checkCode= $modelCompany->getcodeCompany($datacode,array('code'));
                if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Company']['id'] ) ){
                    $dataSend= arrayMap($input['request']->data);
                    if(!empty(trim($dataSend['name']))){
                        if(empty($_GET['id'])){
                            $data['Company']['numberBranch']= 0;
                        }
                        $data['Company']['name']= $dataSend['name'];
                        $data['Company']['address']= $dataSend['address'];
                        $data['Company']['email']= $dataSend['email'];
                        $data['Company']['phone']= $dataSend['phone'];
                        $data['Company']['status']= $dataSend['status'];
                        $data['Company']['taxCode']= $dataSend['taxCode'];
                        $data['Company']['area']= $dataSend['area'];
                        $data['Company']['idCity']= $dataSend['idCity'];
                        $data['Company']['idDistrict']= $dataSend['idDistrict'];
                        $data['Company']['wards']= $dataSend['wards'];
                        $data['Company']['nameBoss']= $dataSend['nameBoss'];
                        $data['Company']['note']= $dataSend['note'];
                        $data['Company']['delete']= 'false';
                        if(!empty($dataSend['code'])){
                          $data['Company']['code']= trim($dataSend['code']);
                          $data['Company']['slug']['code']= createSlugMantan($dataSend['code']);

                      }
                      $data['Company']['slug']['address']= createSlugMantan($dataSend['address']);
                      $data['Company']['slug']['wards']= createSlugMantan($dataSend['wards']);
                      $data['Company']['slug']['nameBoss']= createSlugMantan($dataSend['nameBoss']);

                      $data['Company']['slug']['email']= createSlugMantan($dataSend['email']);
                      $data['Company']['slug']['name']= createSlugMantan($dataSend['name']);
                      $data['Company']['slug']['taxCode']= createSlugMantan($dataSend['taxCode']);
                      if($dataSend['status']=='lock'){
                       $data['Company']['expires']=(int)1;
                   }
                   if($dataSend['status']=='active'){
                       $data['Company']['expires']=(int)0;
                   }

                   if($modelCompany->save($data)){
                    $mess= 'Lưu thành công';
                    $id= '';
                    if(empty($_GET['id'])){
                       $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm công ty mới có tên: '.$dataSend['name'].' Có mã công ty: '.$dataSend['code'];
                   }else{
                    if(!empty($dataSend['reason'])){
                        $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa thông tin công ty: '.$dataSend['name'].'. Lý do sửa: '.$dataSend['reason'];
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
            $mess= 'Bạn không được để trống tên công ty';
        }}else{
            $mess="Mã công ty đã tồn tại";
        }
    }
    setVariable('mess',$mess);
    setVariable('data',$data);
    setVariable('listCityKiosk',$listCityKiosk);
}else{
    $modelOption->redirect($urlHomes.'dashboard');
}
}else{
    $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function viewCompany($input){
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin công ty';

    $modelCompany= new Company();
    $modelLog= new Log();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewCompany', $_SESSION['infoStaff']['Staff']['permission']))){
            $id=$input['request']->params['pass']['1'];
            if(!empty($id)){
                $data=$modelCompany->getCompany($id);
                setVariable('data',$data);
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
function deleteCompany($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $urlNow;
    $metaTitleMantan= 'Khóa công ty';

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteCompany', $_SESSION['infoStaff']['Staff']['permission']))){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelCompany= new Company();
            $modelLog= new Log();

            if(!empty($_GET['id'])){
                $company=$modelCompany->getCompany($_GET['id']);
                if($company['Company']['numberBranch']==0){
                $data['$set']['delete']= 'true';
                $dk= array('_id'=>new MongoId($_GET['id']));

                if($modelCompany->updateAll($data,$dk)){
                	// lưu lịch sử tạo sản phẩm
                    $saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa công ty có mã: '.$company['Company']['code'];
                    $modelLog->save($saveLog);

                    $modelOption->redirect($urlHomes.'listCompany');
                }else{
                    $modelOption->redirect($urlHomes.'listCompany');
                }
            }
            else
            {
                    $modelOption->redirect($urlHomes.'listCompany?mess=-2');
            }

            }else{
                $modelOption->redirect($urlHomes.'listCompany');
            }
        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}

// xử lý chi nhánh
function listBranch($input){
    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $urlNow;
    global $modelOption;
    global $metaTitleMantan;
    $metaTitleMantan= 'Danh sách chi nhánh công ty';

    $dataSend = $input['request']->data;
    $modelBranch= new Branch();

    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listBranch', $_SESSION['infoStaff']['Staff']['permission']))){
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions = array('status'=>'active');
            $order = array('created'=>'DESC');
            $fields= array('name','phone','address','email','status','numberGroup','idCompany','code','nameBoss');

            if(!empty($_GET['idCompany'])){
                $conditions['idCompany']= array('$regex' => $_GET['idCompany']);
            }
            if(!empty($_GET['name'])){
                $key= createSlugMantan(trim($_GET['name']));
                $conditions['slug.name']= array('$regex' => $key);
            }
            if(!empty($_GET['email'])){
                $email=createSlugMantan(trim($_GET['email']));
                $conditions['emailslug']= array('$regex' =>$email);
            }
            if(!empty($_GET['phone'])){
                $key= createSlugMantan(trim($_GET['phone']));
                $conditions['phone']= array('$regex' => $key);
            }
            if(!empty($_GET['address'])){
                $conditions['slug.address']= array('$regex' => createSlugMantan(trim($_GET['address'])));
            }
            if(!empty($_GET['area'])){
                $conditions['area']= $_GET['area'];
            }
            if(!empty($_GET['idCity'])){
                $conditions['idCity']= $_GET['idCity'];
            }
            if(!empty($_GET['idDistrict'])){
                $conditions['idDistrict']= $_GET['idDistrict'];
            }
            if(isset($_GET['numberGroup'])&&$_GET['numberGroup']!=null){

                $conditions['numberGroup']= (int)$_GET['numberGroup'];

            }

            if(!empty($_GET['wards'])){
                $wards=trim($_GET['wards']);
                $conditions['slug.wards']= array('$regex' =>createSlugMantan($wards));
            }

            if(!empty($_GET['nameBoss'])){
                $conditions['slug.nameBoss']= array('$regex' => createSlugMantan(trim($_GET['nameBoss'])));
            }

            if(!empty($_GET['code'])){
                $conditions['slug.code']= array('$regex' => createSlugMantan(trim($_GET['code'])));
            }

            $listData= $modelBranch->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelBranch->find('count',array('conditions' => $conditions));
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

            setVariable('listData',$listData);

            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
            setVariable('mess',$mess);
        }else{
            $modelBranch->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelBranch->redirect($urlHomes.'login?status=-2');
    }
}

function addBranch($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin chi nhánh';

    $modelBranch= new Branch();
    $modelLog= new Log();
    $modelCompany= new Company();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addBranch', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['idCompany'])){
                $mess= '';
                $data= array();
                if(!empty($_GET['id'])){
                    $data= $modelBranch->getBranch($_GET['id']);
                }
                $listCityKiosk = $modelOption->getOption('cityKiosk');

                if ($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);
                    $datacode= (isset($dataSend['code']))?$dataSend['code']:"";
                    $checkCode= $modelBranch->getBranchCode($datacode,array('code'));
                    if(empty($checkCode)|| (!empty($_GET['id']) && $_GET['id']==$checkCode['Branch']['id'] ) ){
                        $dataSend= arrayMap($input['request']->data);
                        if(!empty(trim($dataSend['name']))){
                            if(empty($_GET['id'])){
                                $data['Branch']['numberGroup']= 0;
                                $data['Branch']['status']= 'active';
                            }

                            $data['Branch']['name']= $dataSend['name'];
                            if(!empty($dataSend['code'])){
                              $data['Branch']['code']= $dataSend['code'];
                              $data['Branch']['slug']['code']= createSlugMantan($dataSend['code']);
                          }

                          $data['Branch']['address']= $dataSend['address'];
                          $data['Branch']['slug']['address']= createSlugMantan(trim($dataSend['address']));

                          $data['Branch']['email']= $dataSend['email'];
                          $data['Branch']['emailslug']= createSlugMantan(trim($dataSend['email']));
                          $data['Branch']['phone']= $dataSend['phone'];
                          $data['Branch']['area']= $dataSend['area'];
                          $data['Branch']['idCity']= $dataSend['idCity'];
                          $data['Branch']['idDistrict']= $dataSend['idDistrict'];
                          $data['Branch']['wards']= $dataSend['wards'];
                          $data['Branch']['slug']['wards']= createSlugMantan(trim($dataSend['wards']));
                          $data['Branch']['nameBoss']= $dataSend['nameBoss'];
                          $data['Branch']['idCompany']= $_GET['idCompany'];
                          $data['Branch']['note']= $dataSend['note'];
                       // $data['Branch']['reason']= $dataSend['reason'];
                          $data['Branch']['slug']['name']= createSlugMantan(trim($dataSend['name']));
                          $data['Branch']['slug']['nameBoss']= createSlugMantan(trim($dataSend['nameBoss']));

                          if($modelBranch->save($data)){
                            $mess= 'Lưu thành công';
                            $id= '';
                            if(empty($_GET['id'])){
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm chi nhánh mới có tên: '.$dataSend['name'].', Có mã chi nhánh: '.$data['Branch']['code'];
                            }else{
                                if(!empty($dataSend['reason'])){
                                 $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa thông tin chi nhánh: '.$dataSend['name'].' Lý do:'.$dataSend['reason'];
                             }

                         }

                         $saveLog['Log']['time']= time();
                         $modelLog->save($saveLog);

                         if(empty($_GET['id'])){
                            $saveCompany['$inc']['numberBranch']= 1;
                            $dk= array('_id'=> new MongoId($_GET['idCompany']));
                            $modelCompany->updateAll($saveCompany,$dk);
                        }

                        if(empty($_GET['id'])){
                            $data= array();
                        }
                    }else{
                        $mess= 'Lưu thất bại';
                    }
                }else{
                    $mess= 'Bạn không được để trống tên chi nhánh';
                }
            }else{
                $mess= "Mã chi nhánh đã tồn tại";
            }  }
            setVariable('mess',$mess);
            setVariable('data',$data);
            setVariable('listCityKiosk',$listCityKiosk);
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

function infoBranch($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin chi nhánh';

    $modelBranch= new Branch();
    $modelLog= new Log();
    $modelCompany= new Company();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoBranch', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['idCompany'])){
                $mess= '';
                $data= array();
                if(!empty($_GET['id'])){
                    $data= $modelBranch->getBranch($_GET['id']);
                }
                $listCityKiosk = $modelOption->getOption('cityKiosk');

                if ($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);
                    $datacode= (isset($dataSend['code']))?$dataSend['code']:"";
                    $checkCode= $modelBranch->getBranchCode($datacode,array('code'));
                    if(empty($checkCode)|| (!empty($_GET['id']) && $_GET['id']==$checkCode['Branch']['id'] ) ){
                        $dataSend= arrayMap($input['request']->data);
                        if(!empty(trim($dataSend['name']))){
                            if(empty($_GET['id'])){
                                $data['Branch']['numberGroup']= 0;
                                $data['Branch']['status']= 'active';
                            }

                            $data['Branch']['name']= $dataSend['name'];
                            if(!empty($dataSend['code'])){
                              $data['Branch']['code']= $dataSend['code'];
                              $data['Branch']['slug']['code']= createSlugMantan($dataSend['code']);
                          }

                          $data['Branch']['address']= $dataSend['address'];
                          $data['Branch']['slug']['address']= createSlugMantan(trim($dataSend['address']));

                          $data['Branch']['email']= $dataSend['email'];
                          $data['Branch']['emailslug']= createSlugMantan(trim($dataSend['email']));
                          $data['Branch']['phone']= $dataSend['phone'];
                          $data['Branch']['area']= $dataSend['area'];
                          $data['Branch']['idCity']= $dataSend['idCity'];
                          $data['Branch']['idDistrict']= $dataSend['idDistrict'];
                          $data['Branch']['wards']= $dataSend['wards'];
                          $data['Branch']['slug']['wards']= createSlugMantan(trim($dataSend['wards']));
                          $data['Branch']['nameBoss']= $dataSend['nameBoss'];
                          $data['Branch']['idCompany']= $_GET['idCompany'];
                          $data['Branch']['note']= $dataSend['note'];
                       // $data['Branch']['reason']= $dataSend['reason'];
                          $data['Branch']['slug']['name']= createSlugMantan(trim($dataSend['name']));
                          $data['Branch']['slug']['nameBoss']= createSlugMantan(trim($dataSend['nameBoss']));

                          if($modelBranch->save($data)){
                            $mess= 'Lưu thành công';
                            $id= '';
                            if(empty($_GET['id'])){
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' tạo thông tin chi nhánh mới có tên là '.$dataSend['name'];
                            }else{
                                if(!empty($dataSend['reason'])){
                                 $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' sửa thông tin chi nhánh cũ có tên là '.$dataSend['name'].', ID là '.$_GET['id'].'.Với lý do:'.$dataSend['reason'];
                             }

                         }

                         $saveLog['Log']['time']= time();
                         $modelLog->save($saveLog);

                         if(empty($_GET['id'])){
                            $saveCompany['$inc']['numberBranch']= 1;
                            $dk= array('_id'=> new MongoId($_GET['idCompany']));
                            $modelCompany->updateAll($saveCompany,$dk);
                        }

                        if(empty($_GET['id'])){
                            $data= array();
                        }
                    }else{
                        $mess= 'Lưu thất bại';
                    }
                }else{
                    $mess= 'Bạn không được để trống tên chi nhánh';
                }
            }else{
                $mess= "Mã chi nhánh đã tồn tại";
            }  }
            setVariable('mess',$mess);
            setVariable('data',$data);
            setVariable('listCityKiosk',$listCityKiosk);
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

function deleteBranch($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $urlNow;
    $metaTitleMantan= 'Khóa chi nhánh';

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteBranch', $_SESSION['infoStaff']['Staff']['permission']))){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelBranch= new Branch();
            $modelLog= new Log();
            $modelCompany= new Company();

            if(!empty($_GET['id'])){
                $data['$set']['status']= 'lock';
                $dk= array('_id'=>new MongoId($_GET['id']));
                $brach = $modelBranch-> getBranch($_GET['id']);
                if ($brach['Branch']['numberGroup']==0) {
                if($modelBranch->updateAll($data,$dk)){
                    // lưu lịch sử tạo sản phẩm
                    $saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa chi nhánh có mã: '.$brach['Branch']['code'];
                    $modelLog->save($saveLog);

                    $saveCompany['$inc']['numberBranch']= -1;
                    $dkCompany= array('_id'=> new MongoId($_GET['idCompany']));
                    $modelCompany->updateAll($saveCompany,$dkCompany);

                    $modelOption->redirect($urlHomes.'listBranch?status=deleteCompanyDone&idCompany='.$_GET['idCompany']);
                }else{
                    $modelOption->redirect($urlHomes.'listBranch?status=deleteCompanyFail&idCompany='.$_GET['idCompany']);
                }
            }
            else
            {
                    $modelOption->redirect($urlHomes.'listBranch?idCompany='.$_GET['idCompany'].'&mess=-2');
            }

            }else{
                $modelOption->redirect($urlHomes.'listCompany');
            }
        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}

// xử lý nhóm phân quyền
function groupPermission($input)
{
    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $urlNow;
    global $modelOption;
    global $metaTitleMantan;
    $metaTitleMantan= 'Nhóm phân quyền';

    $dataSend = $input['request']->data;
    $modelPermission= new Permission();

    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('groupPermission', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['idCompany']) && !empty($_GET['idBranch'])){
                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions = array('status'=>'active','idBranch'=>$_GET['idBranch']);
                $order = array('created'=>'DESC');
                $fields= array('name','status','idCompany','idBranch','numberStaff','code','leader');
                if(!empty($_GET['idCompany'])){
                   $conditions['idCompany']= $_GET['idCompany'];
               }

               if(!empty($_GET['idBranch'])){
                   $conditions['idBranch']= $_GET['idBranch'];
               }
               if(!empty($_GET['code'])){
                $code=trim($_GET['code']);
                $code1=createSlugMantan($code);
                $conditions['codeCP']=array('$regex' => $code1);
            }
            if(!empty($_GET['leader'])){
                $leader=trim($_GET['leader']);
                $leader1=createSlugMantan($leader);
                $conditions['leaderCp']=array('$regex' => $leader1);
            }
            if(isset($_GET['numberStaff'])&&$_GET['numberStaff']!=null){
                $numberStaff=trim($_GET['numberStaff']);
                $conditions['numberStaff']= (int)$numberStaff;
            }
            if(!empty($_GET['name'])){
                $key= trim($_GET['name']);
                $key1=createSlugMantan($key);
                $conditions['nameCp']= array('$regex' => $key1);
            }

            $listData= $modelPermission->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelPermission->find('count',array('conditions' => $conditions));
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

            setVariable('listData',$listData);

            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
            setVariable('mess',$mess);
        }else{
            $modelPermission->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelPermission->redirect($urlHomes.'dashboard');
    }
}else{
    $modelPermission->redirect($urlHomes.'login?status=-2');
}
}

function permissionStaff($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Cấu hình phân quyền cho nhân viên';
    $modelStaff= new Staff();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('permissionStaff', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['id'])){
                $data= $modelStaff->getStaff($_GET['id'],array('permission','code','idPermission'));
                $mess= '';
                if($isRequestPost){
                    $dataSend= arrayMap($input['request']->data);
                    $modelLog= new log();
                    $modelPermission = new Permission();
                    $permission = $modelPermission->getPermission(@$data['Staff']['idPermission']);
                    if($data){
                        $save['$set']['permission']= (!empty($dataSend['permission']))?$dataSend['permission']:array();
                        $id= new MongoId($_GET['id']);
                        if($modelStaff->updateAll($save,array('_id'=>$id)) ){
                            $mess= 'Lưu phân quyền thành công';
                            $data['Staff']['permission']= $save['$set']['permission'];
                    $saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa nhóm phân quyền: '.@$permission['Permission']['code'];
                    $modelLog->save($saveLog);

                        }else{
                            $mess= 'Lưu thất bại';
                        }
                    }
                }

                setVariable('data',$data);
                setVariable('mess',$mess);
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

function addPermission($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Cấu hình nhóm phân quyền';

    $modelPermission= new Permission();
    $modelLog= new Log();
    $modelBranch= new Branch();
    $modelStaff= new Staff();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addPermission', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['idCompany']) && !empty($_GET['idBranch'])){
                $mess= '';
                $data= array();
                if(!empty($_GET['id'])){
                    $data= $modelPermission->getPermission($_GET['id']);
                }

                if ($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);
                    $datacode=(isset($dataSend['code']))?$dataSend['code']:"";
                    $checkCode= $modelPermission->getPermissionCode($datacode,array('code'));
                    if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Permission']['id'] ) ){
                        $dataSend= arrayMap($input['request']->data);
                        if(!empty(trim($dataSend['name']))){
                            if(empty($_GET['id'])){
                                $data['Permission']['status']= 'active';
                                $data['Permission']['numberStaff']= 0;
                            }
                            if(!empty($dataSend['code'])){
                              $data['Permission']['code']= $dataSend['code'];
                              $data['Permission']['codeCP']=createSlugMantan($dataSend['code']) ;
                          }


                          $data['Permission']['leader']= $dataSend['leader'];
                          $data['Permission']['leaderCp']=createSlugMantan($dataSend['leader']) ;
                          $data['Permission']['name']= $dataSend['name'];
                          $data['Permission']['nameCp']=createSlugMantan($dataSend['name']) ;
                          $data['Permission']['permission']= (!empty($dataSend['permission']))?$dataSend['permission']:array();
                          $data['Permission']['idCompany']= $_GET['idCompany'];
                          $data['Permission']['idBranch']= $_GET['idBranch'];

                          $data['Permission']['slug']['name']= createSlugMantan($dataSend['name']);

                          if($modelPermission->save($data)){
                            $mess= 'Lưu thành công';
                            $id= '';
                            if(empty($_GET['id'])){
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm mới nhóm quyền có tên: '.$dataSend['name'].' Có mã nhóm quyền: '.$data['Permission']['code'];
                            }else{
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa nhóm quyền: '.$dataSend['name'];
                            }

                            $saveLog['Log']['time']= time();
                            $modelLog->save($saveLog);

                            if(!empty($_GET['id'])){
                                $conditionsStaff = array('status'=>'active','idPermission'=>$_GET['id']);
                                $saveStaff['$set']['permission']= (!empty($dataSend['permission']))?$dataSend['permission']:array();

                                $modelStaff->updateAll($saveStaff,$conditionsStaff);
                            }

                            if(empty($_GET['id'])){
                                $saveBranch['$inc']['numberGroup']= 1;
                                $dkBranch= array('_id'=> new MongoId($_GET['idBranch']));
                                $modelBranch->updateAll($saveBranch,$dkBranch);
                            }

                            if(empty($_GET['id'])){
                                $data= array();
                            }
                        }else{
                            $mess= 'Lưu thất bại';
                        }
                    }else{
                        $mess= 'Bạn không được để trống tên nhóm phân quyền';
                    }
                }
                else{
                    $mess= "Mã nhóm đã tồn tại";
                }
            }
            setVariable('mess',$mess);
            setVariable('data',$data);
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

function infoPermission($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Cấu hình nhóm phân quyền';

    $modelPermission= new Permission();
    $modelLog= new Log();
    $modelBranch= new Branch();
    $modelStaff= new Staff();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoPermission', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['idCompany']) && !empty($_GET['idBranch'])){
                $mess= '';
                $data= array();
                if(!empty($_GET['id'])){
                    $data= $modelPermission->getPermission($_GET['id']);
                }

                if ($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);
                    $datacode=(isset($dataSend['code']))?$dataSend['code']:"";
                    $checkCode= $modelPermission->getPermissionCode($datacode,array('code'));
                    if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Permission']['id'] ) ){
                        $dataSend= arrayMap($input['request']->data);
                        if(!empty(trim($dataSend['name']))){
                            if(empty($_GET['id'])){
                                $data['Permission']['status']= 'active';
                                $data['Permission']['numberStaff']= 0;
                            }
                            if(!empty($dataSend['code'])){
                              $data['Permission']['code']= $dataSend['code'];
                              $data['Permission']['codeCP']=createSlugMantan($dataSend['code']) ;
                          }


                          $data['Permission']['leader']= $dataSend['leader'];
                          $data['Permission']['leaderCp']=createSlugMantan($dataSend['leader']) ;
                          $data['Permission']['name']= $dataSend['name'];
                          $data['Permission']['nameCp']=createSlugMantan($dataSend['name']) ;
                          $data['Permission']['permission']= (!empty($dataSend['permission']))?$dataSend['permission']:array();
                          $data['Permission']['idCompany']= $_GET['idCompany'];
                          $data['Permission']['idBranch']= $_GET['idBranch'];

                          $data['Permission']['slug']['name']= createSlugMantan($dataSend['name']);

                          if($modelPermission->save($data)){
                            $mess= 'Lưu thành công';
                            $id= '';
                            if(empty($_GET['id'])){
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' tạo nhóm phân quyền mới mới có tên là '.$dataSend['name'];
                            }else{
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' sửa nhóm phân quyền có tên là '.$dataSend['name'].', ID là '.$_GET['id'];
                            }

                            $saveLog['Log']['time']= time();
                            $modelLog->save($saveLog);

                            if(!empty($_GET['id'])){
                                $conditionsStaff = array('status'=>'active','idPermission'=>$_GET['id']);
                                $saveStaff['$set']['permission']= (!empty($dataSend['permission']))?$dataSend['permission']:array();

                                $modelStaff->updateAll($saveStaff,$conditionsStaff);
                            }

                            if(empty($_GET['id'])){
                                $saveBranch['$inc']['numberGroup']= 1;
                                $dkBranch= array('_id'=> new MongoId($_GET['idBranch']));
                                $modelBranch->updateAll($saveBranch,$dkBranch);
                            }

                            if(empty($_GET['id'])){
                                $data= array();
                            }
                        }else{
                            $mess= 'Lưu thất bại';
                        }
                    }else{
                        $mess= 'Bạn không được để trống tên nhóm phân quyền';
                    }
                }
                else{
                    $mess= "Mã nhóm đã tồn tại";
                }
            }
            setVariable('mess',$mess);
            setVariable('data',$data);
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

function deletePermission($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $urlNow;
    $metaTitleMantan= 'Khóa nhóm phân quyền';

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deletePermission', $_SESSION['infoStaff']['Staff']['permission']))){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelPermission= new Permission();
            $modelLog= new Log();
            $modelBranch= new Branch();

            if(!empty($_GET['id'])){
                $data['$set']['status']= 'lock';
                $dk= array('_id'=>new MongoId($_GET['id']));
                $permission = $modelPermission->getPermission($_GET['id']);
                if($permission['Permission']['numberStaff']==0){
                if($modelPermission->updateAll($data,$dk)){
                    // lưu lịch sử tạo sản phẩm
                    $saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa nhóm phân quyền có mã: '.$permission['Permission']['code'];
                    $modelLog->save($saveLog);

                    $saveBranch['$inc']['numberGroup']= -1;
                    $dkBranch= array('_id'=> new MongoId($_GET['idBranch']));
                    $modelBranch->updateAll($saveBranch,$dkBranch);

                    $modelOption->redirect($urlHomes.'groupPermission?status=deleteGroupPermissionDone&idCompany='.$_GET['idCompany'].'&idBranch='.$_GET['idBranch']);
                }else{
                    $modelOption->redirect($urlHomes.'groupPermission?status=deleteGroupPermissionFail&idCompany='.$_GET['idCompany'].'&idBranch='.$_GET['idBranch']);
                }
            }
            else
            {
                    $modelOption->redirect($urlHomes.'groupPermission?idCompany='.$_GET['idCompany'].'&idBranch='.$_GET['idBranch'].'&mess=-2');
            }

            }else{
                $modelOption->redirect($urlHomes.'listCompany');
            }
        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}

// xử lý tài khoản nhân viên
function listStaffCompany($input)
{
    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $urlNow;
    global $modelOption;
    global $metaTitleMantan;
    $metaTitleMantan= 'Danh sách nhân viên';
    $modelPermission=new Permission;
    $dataSend = $input['request']->data;
    $modelStaff= new Staff();

    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listStaffCompany', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['idCompany']) && !empty($_GET['idBranch']) && !empty($_GET['idPermission'])){
                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions = array('status'=>'active','idPermission'=>$_GET['idPermission']);
                $order = array('created'=>'DESC');
                $fields= array('code','fullName','birthday','email','phone','address','idCompany','idBranch','idPermission','idCompany','idBranch','idPermission','wards','directManager','indirectManager','area');
                if(!empty($_GET['idCompany'])){
                    $conditions['idCompany']=$_GET['idCompany'];
                }
                if(!empty($_GET['idBranch'])){
                    $conditions['idBranch']=$_GET['idBranch'];
                }
                if(!empty($_GET['idPermission'])){
                    $conditions['idPermission']=$_GET['idPermission'];
                }
                if(!empty($_GET['name'])){
                    $key=createSlugMantan(($_GET['name']));
                    $conditions['slug.fullName']= array('$regex' => $key);
                }
                if(!empty($_GET['birthday'])){
                    $birthday= trim(($_GET['birthday']));
                    $conditions['birthday']= array('$regex' => $birthday);
                }
                if(!empty($_GET['email'])){
                    $email= createSlugMantan(trim($_GET['email']));
                    $conditions['slug.email']= array('$regex' => $email);
                }
                if(!empty($_GET['phone'])){
                    $phone= trim(($_GET['phone']));
                    $conditions['phone']= array('$regex' => $phone);
                }
                if(!empty($_GET['area'])){
                    $conditions['area']= $_GET['area'];
                }
                if(!empty($_GET['idCity'])){
                    $conditions['idCity']= $_GET['idCity'];
                }
                if(!empty($_GET['idDistrict'])){
                    $conditions['idDistrict']= $_GET['idDistrict'];
                }

                if(!empty($_GET['wards'])){
                    $wards=createSlugMantan(trim($_GET['wards']));
                    $conditions['slug.wards']= array('$regex' => $wards);
                }
                if(!empty($_GET['address'])){
                    $address=createSlugMantan(trim($_GET['address']));
                    $conditions['slug.address']= array('$regex' => $address);
                }
                if(!empty($_GET['dateTrial'])){
                    $dateTrial=trim($_GET['dateTrial']);
                    $conditions['dateTrial']= array('$regex' => $dateTrial);
                }
                if(!empty($_GET['dateStart'])){
                    $dateStart=trim($_GET['dateStart']);
                    $conditions['dateStart']= array('$regex' => $dateStart);
                }
                if(!empty($_GET['position'])){
                    $position=createSlugMantan(trim($_GET['position']));
                    $conditions['slug.position']= array('$regex' => $position);
                }
                if(!empty($_GET['directManager'])){
                    $directManager=createSlugMantan(trim($_GET['directManager']));
                    $conditions['slug.directManager']= array('$regex' => $directManager);
                }
                if(!empty($_GET['indirectManager'])){
                    $indirectManager=createSlugMantan(trim($_GET['indirectManager']));
                    $conditions['slug.indirectManager']= array('$regex' => $indirectManager);
                }
                $listData= $modelStaff->getPage($page, $limit , $conditions, $order, $fields );

                $totalData= $modelStaff->find('count',array('conditions' => $conditions));
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

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
            }else{
                $modelPermission->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelPermission->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelPermission->redirect($urlHomes.'login?status=-2');
    }
}

function addStaffCompany($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $listArea;

    global $contactSite;
    global $smtpSite;
    $metaTitleMantan= 'Cài đặt tài khoản nhân viên';

    $modelPermission= new Permission();
    $modelLog= new Log();
    $modelBranch= new Branch();
    $modelStaff= new Staff();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addStaffCompany', $_SESSION['infoStaff']['Staff']['permission']))){
            if(!empty($_GET['idCompany']) && !empty($_GET['idBranch']) && !empty($_GET['idPermission'])){
                $mess= '';
                $data= array();
                if(!empty($_GET['id'])){
                    $data= $modelStaff->getStaff($_GET['id']);
                }
                $listCityKiosk = $modelOption->getOption('cityKiosk');

                if ($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);
                    if(!empty(trim($dataSend['fullName'])) ){
                        if(!empty($dataSend['code'])){
                            $checkCode= $modelStaff->getStaffByCode($dataSend['code'],array('code'));
                        }
                        if(empty($checkCode) || (!empty($_GET['id']) && $_GET['id']==$checkCode['Staff']['id'] ) ){

                            if(empty($_GET['id'])){
                                $data['Staff']['status']= 'active';
                            }

                            $data['Staff']['fullName']= $dataSend['fullName'];
                            if(!empty($dataSend['code'])){
                              $data['Staff']['code']= $dataSend['code'];
                              $data['Staff']['slug']['code']= createSlugMantan(trim($dataSend['code']));
                          }

                          $permission= $modelPermission->getPermission($_GET['idPermission'],array('permission'));

                          $data['Staff']['idCompany']= $_GET['idCompany'];
                          $data['Staff']['pass']= (isset($dataSend['password']))?md5($dataSend['password']):$data['Staff']['pass'];
                          $data['Staff']['idBranch']= $_GET['idBranch'];
                          $data['Staff']['idPermission']= $_GET['idPermission'];
                          $data['Staff']['fullName']= $dataSend['fullName'];
                          $data['Staff']['sex']= $dataSend['sex'];
                          $data['Staff']['birthday']= $dataSend['birthday'];
                          $data['Staff']['email']= $dataSend['email'];
                          $data['Staff']['slug']['email']= createSlugMantan($dataSend['email']);
                          $data['Staff']['phone']= $dataSend['phone'];
                          $data['Staff']['area']= $dataSend['area'];
                          $data['Staff']['idCity']= $dataSend['idCity'];
                          $data['Staff']['idDistrict']= $dataSend['idDistrict'];
                          $data['Staff']['slug']['wards']= createSlugMantan($dataSend['wards']);
                          $data['Staff']['slug']['address']= createSlugMantan($dataSend['address']);
                          $data['Staff']['wards']= $dataSend['wards'];
                          $data['Staff']['address']= $dataSend['address'];
                          $data['Staff']['dateTrial']= $dataSend['dateTrial'];
                          $data['Staff']['dateStart']= $dataSend['dateStart'];
                          $data['Staff']['position']= $dataSend['position'];
                          $data['Staff']['slug']['position']= createSlugMantan($dataSend['position']);
                          $data['Staff']['slug']['directManager']= createSlugMantan($dataSend['directManager']);
                          $data['Staff']['slug']['indirectManager']= createSlugMantan($dataSend['indirectManager']);
                          $data['Staff']['directManager']= $dataSend['directManager'];
                          $data['Staff']['indirectManager']= $dataSend['indirectManager'];
                          $data['Staff']['desc']= $dataSend['desc'];
                          $data['Staff']['permission']= $permission['Permission']['permission'];

                          $data['Staff']['slug']['fullName']= createSlugMantan($dataSend['fullName']);

                          if($modelStaff->save($data)){
                            $mess= 'Lưu thành công';
                            $id= '';
                            if(empty($_GET['id'])){
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Thêm mới tài khoản nhân viên có tên: '.$dataSend['fullName'].', mã nhân viên: '.$dataSend['code'];
                                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                                $to = array(trim($dataSend['email']));
                                $cc = array();
                                $bcc = array();
                                $subject = '[' . $smtpSite['Option']['value']['show'] . '] Tài khoản của bạn đã được khởi tạo thành công';


                                $content = 'Xin chào '.$data['Staff']['fullName'].'<br/>';
                                $content.= '<br/>Thông tin đăng nhập của bạn là:<br/>
                                Tên đăng nhập: '.$data['Staff']['code'].'<br/>
                                Mật khẩu: '.$dataSend['password'].'<br/>
                                Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

                                $modelStaff->sendMail($from, $to, $cc, $bcc, $subject, $content);
                            }else{
                                if(!empty($dataSend['reason'])){
                                 $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Sửa thông tin tài khoản nhân viên có tên: '.$dataSend['fullName'].', mã nhân viên: '.$data['Staff']['code'].' Lý do sửa: '.$dataSend['reason'];
                             }

                         }

                         $saveLog['Log']['time']= time();
                         $modelLog->save($saveLog);

                         if(empty($_GET['id'])){
                            $savePermission['$inc']['numberStaff']= 1;
                            $dkPermission= array('_id'=> new MongoId($_GET['idPermission']));
                            $modelPermission->updateAll($savePermission,$dkPermission);
                        }

                        if(empty($_GET['id'])){
                            $data= array();
                        }
                    }else{
                        $mess= 'Lưu thất bại';
                    }
                }else{
                    $mess= 'Mã nhân viên đã tồn tại';
                }
            }else{
                $mess= 'Bạn không được để trống tên và mã nhân viên';
            }
        }
        setVariable('mess',$mess);
        setVariable('data',$data);
        setVariable('listCityKiosk',$listCityKiosk);
        setVariable('listArea',$listArea);
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
function infoStaffCompany($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $listArea;

    global $contactSite;
    global $smtpSite;
    $metaTitleMantan= 'Cài đặt tài khoản nhân viên';

    $modelPermission= new Permission();
    $modelLog= new Log();
    $modelBranch= new Branch();
    $modelStaff= new Staff();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoStaffCompany', $_SESSION['infoStaff']['Staff']['permission']))){

                if(!empty($_GET['id'])){
                    $data= $modelStaff->getStaff($_GET['id']);
                }
                $listCityKiosk = $modelOption->getOption('cityKiosk');



        setVariable('data',$data);
        setVariable('listCityKiosk',$listCityKiosk);
        setVariable('listArea',$listArea);
    }else{
        $modelOption->redirect($urlHomes.'dashboard');
    }
}else{
    $modelOption->redirect($urlHomes.'login?status=-2');
}
}
function infoStaffCom($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $listArea;

    global $contactSite;
    global $smtpSite;
    $metaTitleMantan= 'Cài đặt tài khoản nhân viên';

    $modelPermission= new Permission();
    $modelLog= new Log();
    $modelBranch= new Branch();
    $modelStaff= new Staff();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoStaffCom', $_SESSION['infoStaff']['Staff']['permission']))){

                if(!empty($_GET['id'])){
                    $data= $modelStaff->getStaff($_GET['id']);
                }
                $listCityKiosk = $modelOption->getOption('cityKiosk');



        setVariable('data',$data);
        setVariable('listCityKiosk',$listCityKiosk);
        setVariable('listArea',$listArea);
    }else{
        $modelOption->redirect($urlHomes.'dashboard');
    }
}else{
    $modelOption->redirect($urlHomes.'login?status=-2');
}
}

function deleteStaffCompany($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $urlNow;
    $metaTitleMantan= 'Khóa tài khoản nhân viên';

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteStaffCompany', $_SESSION['infoStaff']['Staff']['permission']))){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelPermission= new Permission();
            $modelLog= new Log();
            $modelBranch= new Branch();
            $modelStaff= new Staff();

            if(!empty($_GET['id'])){
                $data['$set']['status']= 'lock';
                $dk= array('_id'=>new MongoId($_GET['id']));
                $staff=$modelStaff-> getStaff($_GET['id']);
                if($modelStaff->updateAll($data,$dk)){
                    $saveLog['Log']['time']= time();
                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' Khóa tài khoản nhân viên có mã: '.$staff['Staff']['code'];
                    $modelLog->save($saveLog);

                    $savePermission['$inc']['numberStaff']= -1;
                    $dkPermission= array('_id'=> new MongoId($_GET['idPermission']));
                    $modelPermission->updateAll($savePermission,$dkPermission);

                    $modelOption->redirect($urlHomes.'listStaffCompany?status=deleteStaffDone&idCompany='.$_GET['idCompany'].'&idBranch='.$_GET['idBranch'].'&idPermission='.$_GET['idPermission']);
                }else{
                    $modelOption->redirect($urlHomes.'listStaffCompany?status=deleteStaffFail&idCompany='.$_GET['idCompany'].'&idBranch='.$_GET['idBranch'].'&idPermission='.$_GET['idPermission']);
                }

            }else{
                $modelOption->redirect($urlHomes.'listCompany');
            }
        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}
?>
