<?php 
	// sao lưu bảng máy
class Machinebackup extends AppModel {

	var $name = 'Machinebackup';

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

	function getMachinebackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}
}
// sao lưu đối tác
class Patnerbackup extends AppModel {

	var $name = 'Patnerbackup';

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

	function getPatnerbackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}
}
// sap lưu điểm đặt
class Placebackup extends AppModel {

	var $name = 'Placebackup';

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

	function getPlacebackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}

}
//sản phẩm sao lưu
class Productbackup extends AppModel {

	var $name = 'Productbackup';

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
	function getProductbackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}
}
// sao lưu nhà phân phối
class Supplierbackup extends AppModel {

	var $name = 'Supplierbackup';

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

	function getSupplierbackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}
}
// sao lưu lịch sử giao dịch
class Transferbackup extends AppModel {

	var $name = 'Transferbackup';

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

	function getTransferbackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}

}
// sao lưu chi nhánh đặt máy
class Branchbackup extends AppModel {

	var $name = 'Branchbackup';

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

	function getBranchbackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}

}
// sao lưu lịch sử thu tiền tại máy
class Collectionbackup extends AppModel {

	var $name = 'Collectionbackup';

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

}
// sao lưu thông báo máy lỗi 
class Errorbackup extends AppModel {

	var $name = 'Errorbackup';

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

	function getErrorbackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}
}
// sao lưu nhân viên
class Staffbackup extends AppModel {

	var $name = 'Staffbackup';

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

	function getStaffbackup($id,$fields=array() ) {
		$id = new MongoId($id);
		$dk = array('_id' => $id);
		$return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
		return $return;
	}
}
// sao lưu mã coupon
class Couponbackup extends AppModel {

    var $name = 'Couponbackup';

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

    function getCouponbackup($id,$fields=array() ) {
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