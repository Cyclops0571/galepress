<?php

$baseDir = "/home/admin/public_html/";
require_once $baseDir . "php-amqplib/vendor/autoload.php";

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$lockFile = $baseDir . 'lock/CreateInteractivePDF_Task.lock';
$fp = fopen($lockFile, 'r+');
/* Activate the LOCK_NB option on an LOCK_EX operation */
if (!flock($fp, LOCK_EX | LOCK_NB)) {
	echo 'Unable to obtain lock';
	exit(-1);
}

$callback = function() {
	$tmpString = exec("/usr/local/bin/php /home/admin/domains/galepress.com/public_html/artisan createinteractivepdf:run");
	echo $tmpString;
};
$connection = new AMQPConnection('localhost', 5672, 'galepress', 'galeprens');
$channel = $connection->channel();
$channel->queue_declare('queue_interactivepdf', false, false, false, false);
$channel->basic_consume('queue_interactivepdf', '', false, true, false, false, $callback);
while (count($channel->callbacks)) {
	$channel->wait();
}
$channel->close();
$connection->close();
