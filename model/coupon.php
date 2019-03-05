<?php
class Coupon extends AppModel {

    var $name = 'Coupon';

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

    function getCoupon($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getCouponCode($code,$fields=array() ) {
        $dk = array('codeCoupon' => $code);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

}

?>