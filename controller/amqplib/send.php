<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();
$channel->queue_declare('getInfoMachineAPI', false, false, false, false);
$msg = new AMQPMessage('{"code":"123456"}');
$channel->basic_publish($msg, '', 'getInfoMachineAPI');
echo " [x] Sent 'Hello World!'\n";
$channel->close();
$connection->close();
?>