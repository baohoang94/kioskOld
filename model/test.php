<?php

class Test extends AppModel //biến appmodel có chức năng đưa dữ liệu phía client lên mongodb và lưu trên đấy. ý nghĩa câu lệnh: class tên Test sẽ kế thừa tính năng của biến Appmodel.

{

    var $name = 'test';
    function getPage($page,$limit,$conditions) //get: hàm lấy ra. Set: hàm gán.

    {
        $array= array(
                         'limit' => $limit,
                         'page' => $page,
                         'order' => array('created' => 'desc'),
                         'conditions' => $conditions
                     );
        return $this -> find('all', $array);
    }
    function getTest($idContact)
    {

          $idContact= new MongoId($idContact);

          $dk = array ('_id' => $idContact);

          $Contact = $this -> find('first', array('conditions' => $dk) );

          return $Contact;

    }

}

 ?>
