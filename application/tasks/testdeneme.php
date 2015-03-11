<?php

require_once path("base") . "php-amqplib/vendor/autoload.php";

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class TestDeneme_Task {

	public function run() {
		echo Laravel\Request::env();
		$connection = new AMQPConnection('localhost', 5672, 'galepress', 'galeprens');
		$channel = $connection->channel();
		$channel->queue_declare('queue_interactivepdf', false, false, false, false);
		$msg = new AMQPMessage('Hello World!');
		$channel->basic_publish($msg, '', 'queue_interactivepdf');
		echo " [x] Sent 'Hello World!'\n";
		$channel->close();
		$connection->close();
	}

	public function consume() {

		$connection = new AMQPConnection('localhost', 5672, 'galepress', 'galeprens');
		$channel = $connection->channel();
		$channel->queue_declare('queue_interactivepdf', false, true, false, false);
		echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
		$callback = function($msg) {
			echo " [x] Received ", $msg->body, "\n";
		};
		$channel->basic_consume('queue_interactivepdf', '', false, true, false, false, $callback);
		while (count($channel->callbacks)) {
			echo "calisiyorum";
			ob_flush();
			$channel->wait();
		}
		$channel->close();
		$connection->close();
	}

}
