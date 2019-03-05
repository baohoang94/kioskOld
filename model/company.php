<?php
class Company extends AppModel {

    var $name = 'Company';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'asc'),$fields=null) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields'=>$fields
        );
        return $this->find('all', $array);
    }

    function getCompany($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }
    function getcodeCompany($code,$fields=array() ) {
        $dk = array('code' => $code);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

}

?>