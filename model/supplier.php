<?php
class Supplier extends AppModel {

    var $name = 'Supplier';

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

    function getSupplier($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
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