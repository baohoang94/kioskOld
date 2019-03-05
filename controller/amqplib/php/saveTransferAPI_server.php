<?php
define('AMQP_DEBUG', false);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();


$channel->exchange_declare('transferAPI', 'topic', false, false, false);

list($queue_name, ,) = $channel->queue_declare("transferAPI.server243", false, true, true, false);

$channel->queue_bind('transferAPI.server243','transferAPI','*.transactions');

echo ' [*] Waiting for saveTransferAPI. To exit press CTRL+C', "\n";

$callback = function($msg){
  	echo ' [x] ', $msg->body.' --- '.$msg->delivery_info['routing_key'], "\n";

  	$data= json_decode($msg->body);
  	
  	$stringSend= array();
  	$url= DOMAIN.'saveTransferAPI';

	foreach($data as $key=>$value){
		$stringSend[]= $key.'='.$value;
	}
	

	$stringSend= implode('&', $stringSend);
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$stringSend);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	curl_close ($ch);

	echo $server_output;

	//$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>