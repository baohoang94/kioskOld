<?php
class Transfer extends AppModel {

    var $name = 'Transfer';

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

    function getTransfer($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getTransferByOrder($idOrder,$fields=array() ) {
        $dk = array('orderId' => (int)$idOrder);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getTransferByTransaction($machineCode,$transactionId,$fields=array() ) {
        $dk = array('codeMachine' => $machineCode,'transactionId'=>$transactionId);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

}

?>