<?php
define('AMQP_DEBUG', true);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();


$channel->exchange_declare('transferAPI', 'topic', false, false, false);

//$data = implode(' ', array_slice($argv, 1));
//if(empty($data)) $data = '{"code":"123456","status":"3"}';
//var_dump($_POST);
if(!empty($_POST['codeMachine'])){
	$data = '';
	if(!empty($_POST['data'])) $data = $_POST['data'];
	//var_dump($data);
	$msg = new AMQPMessage($data);

	$channel->basic_publish($msg, 'transferAPI',$_POST['codeMachine'].'.command.finishTransaction');

	echo " [x] Sent data", $data, "\n";

	$channel->close();
	$connection->close();
}
?>
