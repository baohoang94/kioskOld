<?php

class UpExcel extends AppModel

  {

      var $name = 'SaveFile'; //đây là khai báo thuộc tính, có tên là 1 danh từ.



      function getPage($page,$limit,$conditions,$creatOn) //funtion: đây là khai báo hành động,có tên là 1 động từ.

      {

          $array= array(

                           'limit' => $limit,

                           'page' => $page,

                           'order' => array('created' => 'desc'),

                           'conditions' => $conditions

                           //'createdOn' => new MongoDB\BSON\UTCDateTime

                       );

          return $this -> find('all', $array);

      }
      function getSave($idContact)// get: hàm lấy ra. Lấy trường dữ liệu theo ID. Khi dữ liệu được nhập vào ở trang quản trị, dữ liệu đó sẽ được gán 1 ID và đưa lên rồi lưu trên csdl(mongodb). Để dữ liệu show ra trên trang client, ta phải lấy dữ liệu đấy ra từ csdl(bằng cách gọi ID của dữ liệu đó) rồi add vào trang client.

      {

            $idContact= new MongoId($idContact);

            $dk = array ('_id' => $idContact);

            $Contact = $this -> find('first', array('conditions' => $dk) );

            return $Contact;



      }






  }

 ?>
