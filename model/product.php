<?php
class Product extends AppModel {

    var $name = 'Product';

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

    function getProduct($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getProductCode($code,$fields=array() ) {
        $dk = array('code' => $code);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function isExistUser($data,$type='code') {
        $conditions[$type]= $data;
        
        $data = $this->find('first', array('conditions' => $conditions));
        return $data;
    }

}

?>