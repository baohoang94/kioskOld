<?php
define('AMQP_DEBUG', false);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();

$channel->queue_declare('setInfoMachineAPI', false, true, false, false);

echo " [x] Awaiting RPC requests updateConfigMachineAPI\n";
$callback = function($req) {
	echo $req->body."\n";

	//$data= json_decode($req->body);
  	$data['machine']= $req->body;
  	$stringSend= array();
  	$url= DOMAIN.'updateConfigMachineAPI';

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

	$msg = new AMQPMessage(
		(string) $server_output,
		array('correlation_id' => $req->get('correlation_id'))
		);

	$req->delivery_info['channel']->basic_publish($msg, '', $req->get('reply_to'));
	$req->delivery_info['channel']->basic_ack($req->delivery_info['delivery_tag']);};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('setInfoMachineAPI', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>
