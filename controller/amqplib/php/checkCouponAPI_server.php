<?php
define('AMQP_DEBUG', false);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();

// Để RabbitMQ không bao giờ mất hàng đợi, chúng ta chuyển tham số thứ ba cho queue_declare là true:
$channel->queue_declare('queryCouponAPI', false, true, false, false);

echo " [x] Awaiting RPC requests queryCouponAPI \n";
$callback = function($req) {
	echo $req->body."\n";

	$data= json_decode($req->body); //thong tin lay ve từ MQ.
  	
  	$stringSend= array();
  	$url= DOMAIN.'checkCouponAPI'; //tạo url để truy cập trang web.

	foreach($data as $key=>$value){
		$stringSend[]= $key.'='.$value;
	}
	
	$stringSend= implode('&', $stringSend);
	//"php://input";
	//thực hiện curl gửi dữ liệu lên trang web.
	// http://vms.sab.com.vn/checkCouponAPI?
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$stringSend);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch); //gán dữ liệu từ trang web trả về vào thằng $server_output.

	curl_close ($ch);
	
	echo trim($server_output); //thực hiện iệc xóa các khaongr trắng của dãy dữ liệu nhận về.

	$msg = new AMQPMessage( //trả lại dữ liệu vào mq theo tên tương ứng lấy được từ trang web.
		(string) trim($server_output),
		array('correlation_id' => $req->get('correlation_id'))
		);

	$req->delivery_info['channel']->basic_publish($msg, '', $req->get('reply_to'));
	$req->delivery_info['channel']->basic_ack($req->delivery_info['delivery_tag']);
};

//  Điều này nói với RabbitMQ không được gửi nhiều hơn một tin nhắn cho một nhân viên tại một thời điểm. Hay nói cách khác, đừng gửi tin nhắn mới cho một nhân viên cho đến khi nó được xử lý và thừa nhận tin nhắn trước đó. Thay vào đó, nó sẽ gửi nó cho nhân viên tiếp theo mà vẫn không bận.
$channel->basic_qos(null, 1, null);
// Xác nhận tin nhắn được tắt theo mặc định. Đã đến lúc bật chúng bằng cách đặt tham số thứ tư là basic_consume thành false (đúng nghĩa là không có ack) và gửi xác nhận thích hợp từ nhân viên, sau khi chúng ta hoàn thành một nhiệm vụ.
$channel->basic_consume('queryCouponAPI', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>
