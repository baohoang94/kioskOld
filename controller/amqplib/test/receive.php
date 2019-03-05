<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
echo " [*] Waiting for messages. To exit press CTRL+C\n";
$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";

    $server_output='ok đã nhận và gửi lại';

    $msg = new AMQPMessage((string) trim($server_output)); //trả lại dữ liệu vào mq theo tên tương ứng lấy được từ trang web.

	//$req->delivery_info['channel']->basic_publish($msg, '', 'hello');
	//$req->delivery_info['channel']->basic_ack($req->delivery_info['delivery_tag']);
};
$channel->basic_qos(null, 1, null);
$channel->basic_consume('hello', '', false, true, false, false, $callback);
while (count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>