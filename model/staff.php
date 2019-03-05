<?php
class Staff extends AppModel {

    var $name = 'Staff';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc'),$fields=null) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields'=>$fields
        );
        return $this->find('all', $array);
    }

    function getStaff($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getStaffByCode($code,$fields=array() ) {
        $dk = array('code' => $code);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function checkLogin($code, $password) {
        $dk = array('code' => $code, 'pass' => md5($password),'status'=>'active');
        $lay = array('pass' => 0);

        $return = $this->find('first', array('conditions' => $dk, 'fields' => $lay));

        return $return;
    }

    function isExistUser($data,$type='code') {
        $conditions[$type]= $data;
        
        $data = $this->find('first', array('conditions' => $conditions));
        return $data;
    }

}

?>