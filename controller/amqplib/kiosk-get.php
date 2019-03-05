<?php
define('AMQP_DEBUG', false);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();
$channel->queue_declare('getInfoMachineAPI', false, false, false, false);

function fib($n) {
	if ($n == 0)
		return 0;
	if ($n == 1)
		return 1;
	return fib($n-1) + fib($n-2);
}

echo " [x] Awaiting RPC requests\n";

$callback = function($req) {
	$dataSend= json_decode($req->body);

	echo $req->body;

	$msg = new AMQPMessage(
		(string) $dataSend['code'],
		array('correlation_id' => $req->get('correlation_id'))
		);
	$req->delivery_info['channel']->basic_publish(
		$msg, '', $req->get('reply_to'));
	$req->delivery_info['channel']->basic_ack(
		$req->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('getInfoMachineAPI', '', false, false, false, false, $callback);
echo 'abc';
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();



/*
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once __DIR__ . '/config.php';
$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();

$channel->exchange_declare('topic_logs', 'topic', false, false, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$binding_keys = array_slice($argv, 1);
if( empty($binding_keys )) {
    file_put_contents('php://stderr', "Usage: $argv[0] [binding_key]\n");
    exit(1);
}

foreach($binding_keys as $binding_key) {
    $channel->queue_bind($queue_name, 'topic_logs', $binding_key);
}

echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function($msg){
  echo ' [x] ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
*/
?>