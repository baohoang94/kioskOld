<?php
class Machine extends AppModel {

    var $name = 'Machine';

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

    function getMachine($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getMachineCode($code,$fields=array() ) {
        $dk = array('code' => $code);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }
    function getMachineCodeAsset($code,$fields=array() ) {
        $dk = array('codeasset' => $code);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }
    function getMachineByPlace($id,$fields=array()){
       $dk = array('idPlace' => $id);
       $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
       return $return;
   }
   function checkLoginByToken($token='',$fields=null, $dk= array()) {
    $dk['accessToken']= $token;
    $return = $this->find('first', array('conditions' => $dk, 'fields'=>$fields));
    return $return;
}

}

?>