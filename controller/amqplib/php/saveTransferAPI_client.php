<?php
define('AMQP_DEBUG', true);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();


$channel->exchange_declare('saveTransferAPI', 'fanout', false, false, false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = '{"code":"123456","coupon":"","codeProduct":"32","typePay":"1","time":"1234567","quantity":"1","moneyCalculate":"1000","moneyInput":"2000","status":"1"}';
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'saveTransferAPI');

echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();

?>